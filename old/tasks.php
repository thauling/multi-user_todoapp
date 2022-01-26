<?php
session_start();

require_once 'processing.php';
require_once 'header.php';
//require_once 'footer.php';


if (isset($_GET)) {
    $edit = $_SESSION['edit'];
    $task_id = $_SESSION['task_id'];
    $title =  $_SESSION['title'];
    $description =  $_SESSION['description'];
} else {
    $edit = false;
    $title = $_SESSION['title'];
    $description =  $_SESSION['description'];
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
//     header("location: tasks.php");
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


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>-->
<div class="h-full w-full m-0 p-0 border-2 border-teal-400 bg-gray-100">
    <table class="bg-gray-300 m-0 p-0 table w-full">
        <thead class="table-header-group">
            <tr class="table-row">
                <th class="bg-teal-700 text-gray-200 border text-left px-1 py-1">ID</th>
                <th class="bg-teal-700 text-gray-200 border text-left px-1 py-1">Title</th>
                <th class="bg-teal-700 text-gray-200 border text-left px-1 py-1">Description</th>
                <th class="bg-teal-700 text-gray-200 border text-left px-1 py-1">Created</th>
                <th class="bg-teal-700 text-gray-200 border text-left px-1 py-1">Done?</th>
            </tr>
        </thead>
        <?php
        foreach ($rows as $row) : ?>
            <tr class="table-row">
                <td class="border border-gray-400 text-teal-900 table-cell bg-gray-200"><?= $row['task_id']; ?></td>
                <td class="border border-gray-400 text-teal-900 table-cell bg-gray-200"><?= $row['title']; ?></td>
                <td class="border border-gray-400 text-teal-900 table-cell bg-gray-200"><?= $row['description']; ?></td>
                <!-- <td><?= $row['completed']; ?></td> -->
                <td class="border border-gray-400 text-teal-900 table-cell bg-gray-200"><?= $row['created']; ?></td>
                <td class="border border-gray-400 text-teal-900 table-cell bg-gray-200"><?php if ($row['completed'] == -1) {
                                                                        echo 'nope';
                                                                    } else {
                                                                        echo 'bingo!';
                                                                    } ?></td>
                <td>
                    <a class="bg-gray-700 text-gray-200 mt-2 w-56 text-center" href="tasks.php?edit=<?php echo $row['task_id'];
                                                                                                    ?>">Edit</a> <!-- needs to be GET method-->
                    <a class="bg-red-700 text-gray-200 mt-2 w-56 text-center" href="tasks.php?delete=<?php echo $row['task_id'];
                                                                                                        ?>">Delete</a> <!-- needs to be GET method-->
                    <a class="bg-green-700 text-gray-200 mt-2 w-56 text-center" href="tasks.php?completed=<?php echo $row['task_id'];
                                                                                                            ?>">Complete</a> <!-- needs to be GET method-->

                    <!-- <input type="checkbox" name="completed" id="completed"> 
        <label for="completed">Completed:</label> -->
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<div class="h-full w-full m-1 p-1 border-1 border-gray-400 bg-gray-100">
    <form class="flex flex-col content-center justify-items-center" method="post" action="tasks.php">
        <input type="hidden" name="task_id" value="<?php echo $task_id; ?>" />
        <label for="title">Write a title for your task:</label>
        <input type="text" name="title" value="<?php echo $title ?>" placeholder="Title for task" required />
        <label for="description">Write a description for your task:</label>
        <input type="text" name="description" value="<?php echo $description ?>" placeholder="Description for task" required />
        <?php
        if ($edit) :
            $edit = false;
            //echo $title; 
        ?>
            <button class="bg-teal-700 text-gray-200 mt-2 w-56 text-center" type="submit" name="update">Update</button>

        <?php else : ?>
            <button class="bg-teal-700 text-gray-200 mt-2 w-56 text-center" type="submit" name="save">Save</button>
        <?php endif; ?>
    </form>
</div>
</body>
<?php
require_once 'footer.php';
