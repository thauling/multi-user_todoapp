<?php
session_start();
require_once "processing.php";

//$_SESSION['login'] = true;

$conn = connectToDbPdo($dbparams);


if (isset($_POST["login"])){
   // $_SESSION['login'] = false;
    header("Location: index.php");
    exit();
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
        if ($password !== $password_confirm) {
            $msg = "Passwords do not match.";
        } else {
        $sql = "INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)";   
        $stmt = $conn->prepare($sql); //because named params are not natively supported by mysqli
        $stmt->execute([
            ':username' => htmlspecialchars($username),
            ':email' => htmlspecialchars($email),
            ':password' => htmlspecialchars($password),
            ':role' => $role
        ]);
        $msg = $username . "added.";

    }
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        } finally {
            return $msg;
        }
    
}

function deleteUser($conn) {

}

function updateRole($conn) {

}