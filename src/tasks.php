<?php
session_start();
require_once 'processing.php';
require_once 'header.php';
//require_once 'footer.php';

var_dump($_POST['login']);
var_dump($_POST['cancel']);
var_dump($_POST['create-user']);
var_dump($_POST['logout']);

if (isset($_GET)) {
    $edit = $_SESSION['edit'];
    $task_id = $_SESSION['task_id'];
    $title =  $_SESSION['title'];
    $description =  $_SESSION['description'];
} else {
    $edit = false;
    $task_id = $_SESSION['task_id'];
    $title = $_SESSION['title'];
    $description =  $_SESSION['description'];
}

$dbparams = ['db', 'db', 'user', 'secret'];
$conn = connectToDbPdo($dbparams);
$rows = getAllTasks($conn);

//$_SESSION['permitted'] = true;
?>

<main class="h-full w-full m-0 p-0 bg-gray-100">
<?php if ($_SESSION['permitted']) :
echo "permitted?" .$_SESSION['permitted'];
    ?> 
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
    <div class="h-full w-full m-1 p-1 bg-gray-100">
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
        <?php else: 
            echo "permitted?" .$_SESSION['permitted'];?>
            <h2>You are logged out, please log in on <a href="index.php" homescreen. ></a></h2>
            <?php endif; ?>
</main>
</body>
<?php
require_once 'footer.php';
