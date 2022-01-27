<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
//require_once "login_processing.php";
require_once "db.php";

$_SESSION['edit'] = false;
$_SESSION['task_id'] = 0;
$_SESSION['title'] = '';
$_SESSION['description'] = '';

$task_id = 0;
$edit = false;
$title = "";
$description = "";
$dbparams = ['db', 'db', 'user', 'secret'];

if (isset($_POST['save'])) {
    $conn = connectToDbPdo($dbparams);
    createTask($conn, $_POST['title'], $_POST['description'], $_SESSION['user_id']);
    header("location: tasks.php");
    exit(); // Question for Bjorn and Sebbe: Do I always need this?
}

if (isset($_GET['delete'])) {
    $conn = connectToDbPdo($dbparams);  // Question for Bjorn and Sebbe: Is it better practise/ safer to establish connection after conditional or should I just have one such stmt as in login_processing?
    deleteTask($conn, $_GET['delete']); // because of D R Y ?
    header("location: tasks.php"); 
    exit();
}


if (isset($_GET['edit'])) {
    $conn = connectToDbPdo($dbparams);
    $_SESSION['edit'] = true;
    $row = getOneRow($conn, $_GET['edit']);
    $_SESSION['task_id'] = $row['task_id'];
    $_SESSION['title'] = $row['title'];
    $_SESSION['description'] = $row['description'];
}

if (isset($_POST['update'])) {
    $conn = connectToDbPdo($dbparams);
    updateTask($conn,  $_POST['title'], $_POST['description'], $_POST['task_id']);
    $_SESSION['edit'] = false;
    $_SESSION['title'] = '';
    $_SESSION['description'] = '';
    header("location: tasks.php"); 
    exit();
}

if (isset($_GET['completed'])) {
    $conn = connectToDbPdo($dbparams);
    toggleCompleted($conn, $_GET['completed']);
    header("location: tasks.php"); 
    exit();
}

///////////////////////////////////////////////////////////////////////////////////////////////
// debug
// $_SESSION['processing'] = 'processing';
// var_dump($_SESSION['processing']);
// var_dump($_SESSION['login_processing']);
// var_dump($_SESSION['index']);
// var_dump($_SESSION['tasks']);
///////////////////////////////////////////////////////////////////////////////////////////////
// functions


// create/ insert task
function createTask($conn, $title, $description, $user_id)
{
    try {
        $sql = "INSERT INTO tasks (title, description, user_id) VALUES (:title, :description, :user_id)";
        $stmt = $conn->prepare($sql); //because named params are not natively supported by mysqli
        $stmt->execute([
            ':title' => htmlspecialchars($title),
            ':description' => htmlspecialchars($description),
            ':user_id' => $user_id
        ]);
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
}

// get one task/ row based on ID
function getOneRow($conn, $task_id)
{
    try {
        $sql = "SELECT * FROM tasks WHERE task_id = :task_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':task_id' => $task_id
        ]);
        // var_dump($stmt);
        $row = $stmt->fetch();
        return $row;
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
}

// update title and description of task in database with selected ID
function updateTask($conn, $title, $description, $task_id)
{
    try {
        $sql = "UPDATE tasks set title = :title, description = :description WHERE task_id = :task_id";
        $stmt = $conn->prepare($sql); 
        $stmt->execute([
            ':title' => htmlspecialchars($title),
            ':description' => htmlspecialchars($description),
            ':task_id' => $task_id
        ]);
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
}


// delete a task from the databse that has an ID equal to the selected one 
function deleteTask($conn, $task_id)
{
    try {
        $sql = "DELETE FROM tasks WHERE task_id = :task_id";
        $stmt = $conn->prepare($sql); 
        $stmt->execute([
            ':task_id' => $task_id
        ]);
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
}

// label task as complete
function toggleCompleted($conn, $task_id)
{
    try {
        $row = getOneRow($conn, $task_id); 
        $completed = $row['completed'];
        $sql = "UPDATE tasks set completed = -:completed WHERE task_id = :task_id";
        $stmt = $conn->prepare($sql); //because named params are not natively supported by mysqli
        $stmt->execute([
            ':task_id' => $task_id,
            ':completed' => $completed
        ]);
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
}


// get all rows from database for permitted, logged-in user, invoke this func() directly after login
function fetchAllUserTasks($conn, $user_id)
{
    try {
    $sql = "SELECT * FROM tasks WHERE user_id = :user_id";
    $stmt = $conn->prepare($sql); 
        $stmt->execute([
            ':user_id' => $user_id
        ]);
        $rows = $stmt->fetchAll();
        return $rows;
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
}

function deleteAllUserTasks($conn, $user_id) 
{
    try {
        $sql = "DELETE FROM tasks WHERE user_id = :user_id";
        $stmt = $conn->prepare($sql); 
        $stmt->execute([
            ':user_id' => $user_id
        ]);
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
}

function setAllCompleted($conn, $user_id)
{
    try {
        $sql = "UPDATE tasks set completed = 1 WHERE user_id = :user_id";
        $stmt = $conn->prepare($sql); 
        $stmt->execute([
            ':user_id' => $user_id
        ]);
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
}

