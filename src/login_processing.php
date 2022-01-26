<?php
session_start();
require_once "processing.php";

//$_SESSION['login'] = true;

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
    header("Location: index.php");
    exit();
}

//////////////////////////////////////////////////////////////////////////////////////////////
// functions
function createUser($conn, $username, $email, $password, $password_confirmation, $role) {

}

function deleteUser($conn) {

}

function updateRole($conn) {

}