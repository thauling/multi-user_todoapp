<?php
require_once 'header.php';

$user_id = '';
$username = '';
$email = '';
$password = '';
$pswrepeat = '';

?>

    <div class="h-full w-full p-4 border-4 border-teal-400 bg-gray-100">
            <form class="flex flex-col" method="post" action="index.php">
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
                <label for="username">Username (8 chars minimum):</label>
                <input type="text" name="username" value="<?php echo $username ?>" placeholder="Enter a username" minlength="8" required />
                <label for="password">Email:</label>
                <input type="email" name="email" value="<?php echo $email ?>" placeholder="Enter your email" required />
                <label for="password">Password (8 chars minimum):</label>
                <input type="password" name="password" value="<?php echo $password ?>" placeholder="Enter a password" minlength="8" required />
                <label for="pswrepeat">Repeat password:</label>
                <input type="password" name="pswrepeat" value="<?php echo $pswrepeat ?>" placeholder="Repeat your password" minlength="8" required />
                <button type="submit" name="submit">Submit</button>
            </form>
    </div>
</body>
<?php
require_once 'footer.php';
