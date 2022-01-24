<?php
session_start();

require_once 'processing.php';
require_once 'header.php';
require_once 'footer.php';


if (isset($_GET)) {
    $edit = true;
    $task_id = $_SESSION['task_id'];
    $title =  $_SESSION['title'];
    $description =  $_SESSION['description'];
} else {
    $edit = false;
    $title = '';
    $description = '';
}

$dbparams = ['db', 'db', 'user', 'secret'];
$conn = connectToDbPdo($dbparams);
$rows = getAllTasks($conn);

// if (isset($_POST['save'])) {
//     createTask($conn, $_POST['title'], $_POST['description']);
//     $_POST = null; //does not have the desired effect of resetting 
//     $title = '';
//     $description = '';
// }

// if (isset($_POST['update'])) {
//     updateTask($conn, $_POST['title'],  $_POST['description'], $_POST['task_id']);
//     $_POST = null; //does not have the desired effect of resetting 
//     $title = '';
//     $description = '';
// }

// if (isset($_GET['delete'])) {
//     // add if logic to check that id exists
//     deleteTask($conn, $_GET['delete']);
//     header("location: index.php");
//     //echo "<p> <strong> Reload page to see the change </strong> </p>";
// }

// if (isset($_GET['edit'])) {
//     $edit = true;
//     echo "<br>" . $_GET['edit'] . "<br>";
//     $row = getOneRow($conn, $_GET['edit']);
//     if (count($row) == 1) {


//     }
//     echo $row['title'] . "<br>" . $row['task_id'];
//     if (isset($_POST['update'])) {
//         //updateTask($conn, $_POST['title'],  $_POST['description'], $row['task_id']);
//         echo "UPDATE pressed <br>" . $_POST['title'] . "<br>" . $_POST['description'] . "<br>" . $_POST['task_id'] . "<br>" . $row['task_id'] . "<br>";
//     }
// }


?>
<!--
<script type="text/javascript">
    //location.reload();
</script>
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class=update-delete>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Created</th>
                </tr>
            </thead>
            <?php
            foreach ($rows as $row) : ?>
                <tr>
                    <td><?= $row['task_id']; ?></td>
                    <td><?= $row['title']; ?></td>
                    <td><?= $row['description']; ?></td>
                    <!-- <td><?= $row['completed']; ?></td> -->
                    <td><?= $row['created']; ?></td>
                    <td>
                        <a href="index.php?edit=<?php echo $row['task_id']; ?>">Edit</a> <!-- needs to be GET method-->
                        <a href="processing.php?delete=<?php echo $row['task_id']; ?>">Delete</a> <!-- needs to be GET method-->
                        <a href="index.php?completed=<?php echo $row['task_id']; ?>">Completed!</a> <!-- needs to be GET method-->

                        <!-- <input type="checkbox" name="completed" id="completed"> 
        <label for="completed">Completed:</label> -->
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div class="create">
        <form method="post" action="index.php">
            <input type="hidden" name="task_id" value="<?php echo $task_id; ?>" />
            <label for="title">Write a title for your task:</label>
            <input type="text" name="title" value="<?php echo $title ?>" placeholder="Title for task" required />
            <label for="description">Write a description for your task:</label>
            <input type="text" name="description" value="<?php echo $description ?>" placeholder="Description for task" required />
            <?php
            if ($edit) :
                //$title = $_SESSION['title'];
                //echo $title; ?>
                <button type="submit" name="update">Update</button>

            <?php else : ?>
                <button type="submit" name="save">Save</button>
            <?php endif; ?>
        </form>
    </div>
</body>

</html>