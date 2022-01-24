<?php
require_once 'header.php';

$user_id = '';
$username = '';
$email = '';
$password = '';
$pswrepeat = '';

?>

<body>
    <div class="inline-block p-6 bg-gradient-to-b from-green-400 to-blue-400">
    <div class="create bg-gray-100 h-5">
        <table class="table">
            <form method="post" action="index.php">
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
                <label for="username">Come up with a username (8 characters minimum):</label>
                <input type="text" name="username" value="<?php echo $username ?>" placeholder="Enter a username" minlength="8" required />
                <label for="password">Enter your email:</label>
                <input type="email" name="email" value="<?php echo $email ?>" placeholder="Enter your email" required />
                <label for="password">Password (8 characters minimum):</label>
                <input type="password" name="password" value="<?php echo $password ?>" placeholder="Enter a password" minlength="8" required />
                <label for="pswrepeat">Repeat password:</label>
                <input type="password" name="pswrepeat" value="<?php echo $pswrepeat ?>" placeholder="Repeat your password" minlength="8" required />
                <button type="submit" name="submit">Submit</button>
            </form>
    </div>
    </div>
</body>
<?php
require_once 'footer.php';
