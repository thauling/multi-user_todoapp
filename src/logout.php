<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
  }
require_once "header.php";

///////////////////////////////////////////////////////////////////////////////////////////////
// debug
var_dump($_SESSION['processing']);
var_dump($_SESSION['login_processing']);
var_dump($_SESSION['index']);
var_dump($_SESSION['tasks']);
var_dump($_SESSION['permitted']);
?>

<body>
    <main class="h-full w-full p-4 border-4 border-teal-400 bg-gray-100">
        <h2>Would you like to log out?</h2>
        <form method="post" action="login_processing.php">
        <button class="bg-red-700 text-gray-200 mt-2 w-56 text-center" type="submit" name="logout">Logout</button>
        <button class="bg-teal-700 text-gray-200 mt-2 w-56 text-center" type="submit" name="cancel">Cancel</button>
    </form>

    </main>

<?php
require_once "footer.php";
