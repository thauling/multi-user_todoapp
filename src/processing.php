<?php
//session_start();
//echo 'processing.php loaded';

$task_id = 0;
$edit = false;
$title = "";
$description = "";
$dbparams = ['db', 'db', 'user', 'secret'];


if (isset($_POST['save'])) {
    $conn = connectToDbPdo($dbparams);
    createTask($conn, $_POST['title'], $_POST['description']);
    header("location: index.php");
}

if (isset($_GET['delete'])) {
    // add if logic to check that id exists
    $conn = connectToDbPdo($dbparams);
    deleteTask($conn, $_GET['delete']);
    header("location: index.php"); //ANY print needs t obe removed regardless whether or not it is invoked! W T F
    //echo "<p> <strong> Reload page to see the change </strong> </p>";
}


if (isset($_GET['edit'])) {
    $conn = connectToDbPdo($dbparams);
    $_SESSION['edit'] = true;
    //echo "<br>" . $_GET['edit'] . "<br>";
    $row = getOneRow($conn, $_GET['edit']);
    //var_dump($row);
    $task_id = $row['task_id'];
    $title = $row['title'];
    $description = $row['description'];

    $_SESSION['task_id'] = $task_id;
    $_SESSION['title'] = $title;
    $_SESSION['description'] = $description;
   
}

if (isset($_POST['update'])) {
    $conn = connectToDbPdo($dbparams);
    echo  $_POST['title'] . $_POST['description'] . $_POST['task_id'];
    updateTask($conn,  $_POST['title'], $_POST['description'], $_POST['task_id']);
}


///////////////////////////////////////////////////////////////////////////////////////////////
// functions

// connect to database and return db object
function connectToDbPdo($dbparams){
    $dbname = $dbparams[0];
    $host = $dbparams[1];
    $user = $dbparams[2];
    $psw = $dbparams[3];
    try {
    //print "host: {$host}, user: {$user}, psw: {$psw}, dbname: {$dbname}<br>";
    $connection = new PDO("mysql:dbname={$dbname};host={$host}","{$user}","{$psw}",[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    //isset($connection) ? print "Connected" : "Not connected"; 
}
catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
} finally {
    return $connection;
}
}

// create/ insert task
function createTask($conn, $title, $description){
    try {
    $sql = "INSERT INTO tasks (title, description) VALUES (:title, :description)";   
    $stmt = $conn->prepare($sql); //because named params are not natively supported by mysqli
    $stmt->execute([
        ':title' => $title,
        ':description' => $description
    ]);
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
}

// get all rows from database
function getAllTasks($conn){
    try{
    $sql = "SELECT * FROM tasks";
    $data = $conn->query($sql)->fetchAll();
    return $data;
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
}

// get one task/ row based on ID
function getOneRow($conn, $task_id){
    try{
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
function updateTask($conn, $title, $description, $task_id){
    try {
    $sql = "UPDATE tasks set title = :title, description = :description WHERE task_id = :task_id";
    $stmt = $conn->prepare($sql); //because named params are not natively supported by mysqli
    $stmt->execute([
        ':title' => $title,
        ':description' => $description,
        ':task_id' => $task_id
    ]);
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    } 
}


// delete a task from the databse that has an ID equal to the selected one 
function deleteTask($conn, $task_id){
    try {
    $sql = "DELETE FROM tasks WHERE task_id = :task_id";
    $stmt = $conn->prepare($sql); //because named params are not natively supported by mysqli
    $stmt->execute([
        ':task_id' => $task_id
    ]);
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
}
// 
//header('Location: index.php');