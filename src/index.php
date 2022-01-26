<?php
//session_start();
require_once 'login_processing.php';
require_once 'header.php';

$user_id = '';
$username = '';
//$email = '';
$password = '';
//$pswrepeat = '';
//$login = $_SESSION['login'];

?>
  
    <div class="h-full w-full p-4 border-4 border-teal-400 bg-gray-100">
            <form class="flex flex-col content-center justify-items-center" method="post" action="login_processing.php">
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
                <label class="mb-1" for="username">Username (8 chars minimum):</label>
                <input class="pl-2" type="text" name="username" value="<?php echo $username ?>" placeholder="Enter a username" mrequired />
                <label class="mb-1" for="password">Password (8 chars minimum):</label>
                <input class="pl-2" type="password" name="password" value="<?php echo $password ?>" placeholder="Enter a password" required />
                <button class="bg-teal-700 text-gray-200 mt-2 w-56 text-center" type="submit" name="login">Login</button>
            </form>
            <form method="post" action="login_processing.php">
            <button class="bg-red-700 text-gray-200 mt-2 w-56 text-center" type="submit" name="create-user">Create new user</button>
            </form>
    </div>
</body>
<?php
require_once 'footer.php';
