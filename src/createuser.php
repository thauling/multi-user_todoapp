<?php
require_once 'login_processing.php';
require_once 'header.php';

$user_id = '';
$username = '';
$email = '';
$password = '';
$pswrepeat = '';
//$login = $_SESSION['login'];

?>
<main class="h-full w-full p-4 border-4 border-teal-400 bg-gray-100">
    <form class="flex flex-col content-center justify-items-center" method="post" action="login_processing.php">
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
        <label class="mb-1" for="username">Username (8 chars minimum):</label>
        <input class="pl-2" type="text" name="username" value="<?php echo $username ?>" placeholder="Enter a username" minlength="8" required />
        <label class="mb-1" for="password">Email:</label>
        <input class="pl-2" type="email" name="email" value="<?php echo $email ?>" placeholder="Enter your email" required />
        <label class="mb-1" for="password">Password (8 chars minimum):</label>
        <input class="pl-2" type="password" name="password" value="<?php echo $password ?>" placeholder="Enter a password" minlength="8" required />
        <label class="mb-1" for="pswrepeat">Repeat password:</label>
        <input class="pl-2" type="password" name="pswrepeat" value="<?php echo $pswrepeat ?>" placeholder="Repeat your password" minlength="8" required />
        <button class="bg-teal-700 text-gray-200 mt-2 w-56 text-center" type="submit" name="user-submit">Add new user</button>
    </form>
</main>

</body>
<?php
require_once 'footer.php';
