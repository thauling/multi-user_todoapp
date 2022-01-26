<?php
session_start();
require_once "processing.php";

//$_SESSION['login'] = true;

$conn = connectToDbPdo($dbparams);


if (isset($_POST["login"])){
   // $_SESSION['login'] = false;
   //findUser($conn, $_POST['username'], $_POST['password']);
   $permitted = findUser($conn, $_POST['username'], $_POST['password']); 
   if ($permitted) {
    header("Location: tasks.php");
    exit();
   } else {
    header("Location: index.php");
    exit();
   }
}

if (isset($_POST["create-user"])){
   // $_SESSION['login'] = true;
    header("Location: createuser.php");
    exit();
}

if (isset($_POST["user-submit"])){
    //$_SESSION['login'] = true;
    // for testing this
    $_POST['role'] = 1;
    createUser($conn, $_POST['username'], $_POST['email'], $_POST['password'], $_POST['password'], $_POST['role']);
    header("Location: index.php");
    exit();
}

//////////////////////////////////////////////////////////////////////////////////////////////
// functions
function createUser($conn, $username, $email, $password, $password_confirm, $role) {
    try {

        // $hash = password_hash($password, PASSWORD_DEFAULT);
        // $hash_confirm = password_hash($password_confirm, PASSWORD_DEFAULT);
        $password = htmlspecialchars($password);
        $password_confirm = htmlspecialchars($password_confirm);
        if ($password !== $password_confirm) {
            $msg = "Passwords do not match.";
            //echo "Passwords do not match.";
        } else {
            $psw_hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, email, psw_hash, role) VALUES (:username, :email, :psw_hash, :role)";   
        $stmt = $conn->prepare($sql); 
        $stmt->execute([
            ':username' => htmlspecialchars($username),
            ':email' => htmlspecialchars($email),
            ':psw_hash' => $psw_hash,
            ':role' => $role
        ]);
        $msg = $username . "added.";
        //echo $username . "added.";

    }
        } catch (Exception $e) {
            $msg = "Caught exception: " . $e->getMessage();
        } finally {
        return $msg;
        }
}

function findUser($conn, $username, $password) {
    try{
        $sql = "SELECT psw_hash FROM users WHERE username = :username";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':username' => $username
        ]);
       // var_dump($stmt);
        $psw_hash = $stmt->fetch()['psw_hash'];
        //echo $psw_hash . "<br>";
       // if ($row['username']) {
            if (password_verify($password, $psw_hash)) {
                $login = true;
            } else {
                $login = false;
            }
        //} 
        return $login;
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }


function deleteUser($conn) {

}

function updateRole($conn) {

}