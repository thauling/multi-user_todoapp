<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
  }
require_once "db.php";


$dbparams = ['db', 'db', 'user', 'secret'];

$conn = connectToDbPdo($dbparams);

if (isset($_POST["logout"])) {
    $_SESSION['logout'] = $_POST["logout"];
    $_SESSION['permitted'] = false;
    $_SESSION['msg'] = "Logged out.";
    header("Location: index.php");
}

if (isset($_POST["cancel"])) {
    $_SESSION['cancel'] = $_POST["cancel"];
    header("Location: tasks.php");
}

if (isset($_POST["login"])) {
    $_SESSION['login'] = $_POST["login"];
    $_SESSION['login_processing'] = 'login_create-login';
    $_SESSION['permitted'] = findUser($conn, $_POST['username'], $_POST['password']);
    if ($_SESSION['permitted']) {
        $_SESSION['user_id'] = getUserId($conn, $_POST['username'], $_POST['password']);
        $_SESSION['msg'] =  $_POST['username'] . " is logged in.";
        header("Location: tasks.php");
        exit();
    } else {
        $_SESSION['msg'] = "Password is incorrect.";
        header("Location: index.php");
        exit();
    }
}

if (isset($_POST["create-user"])) {
    $_SESSION['msg'] = '';
    $_SESSION['login_processing'] = 'login_create-user';
    header("Location: createuser.php");
    exit();
}

if (isset($_POST["user-submit"])) {
    $_SESSION['user-submit'] = $_POST["user-submit"];
    if (!checkUniqueUser($conn, $_POST['username'])) {
    $msg = createUser($conn, $_POST['username'], $_POST['email'], $_POST['password'], $_POST['password']);
    $_SESSION['msg'] = "User account created." . " " . $msg;
    header("Location: index.php");
    exit();
    } else {
        $_SESSION['msg'] = "User and/or email already exists, be more creative.";
        header("Location: createuser.php");
    }
}

///////////////////////////////////////////////////////////////////////////////////////////////
// debug
// $_SESSION['login_processing'] = 'loginprocessing';
// var_dump($_SESSION['processing']);
// var_dump($_SESSION['login_processing']);
// var_dump($_SESSION['index']);
// var_dump($_SESSION['tasks']);
//////////////////////////////////////////////////////////////////////////////////////////////
// functions

function createUser($conn, $username, $email, $password, $password_confirm)
{
    try {
        $password = htmlspecialchars($password);
        $password_confirm = htmlspecialchars($password_confirm);
        $username = trim($username);
        $email = trim($email);
        if ($password !== $password_confirm) {
            $msg = "Passwords do not match.";
            //echo "Passwords do not match.";
        } else {
            $psw_hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (username, email, psw_hash) VALUES (:username, :email, :psw_hash)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':username' => htmlspecialchars($username),
                ':email' => htmlspecialchars($email),
                ':psw_hash' => $psw_hash
            ]);
            $msg = $username . " added.";
        }
    } catch (Exception $e) {
        $msg = "Caught exception: " . $e->getMessage();
    } finally {
        return $msg;
    }
}

function findUser($conn, $username, $password)
{
    try {
        $sql = "SELECT psw_hash FROM users WHERE username = :username";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':username' => $username
        ]);
        // var_dump($stmt);
        $psw_hash = $stmt->fetch()['psw_hash'];
        //echo $psw_hash . "<br>";
        // if ($row['username']) {
        return password_verify($password, $psw_hash);
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
}

function getUserId($conn, $username) {
    try {
        //$psw_hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "SELECT user_id FROM users WHERE username = :username";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':username' => $username
        ]);
        // var_dump($stmt);
        $msg = $stmt->fetch()['user_id'];
    } catch (Exception $e) {
        $msg = "Caught exception: " . $e->getMessage();
    }
    return $msg;
}

function checkUniqueUser($conn, $username){
    try {
        $sql = "SELECT user_id FROM users WHERE username = :username";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':username' => $username
        ]);
        return $stmt->rowCount() >= 1;

    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
}
