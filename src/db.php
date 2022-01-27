<?php
// connect to database and return db object
function connectToDbPdo($dbparams)
{
    $dbname = $dbparams[0];
    $host = $dbparams[1];
    $user = $dbparams[2];
    $psw = $dbparams[3];
    try {
        $connection = new PDO("mysql:dbname={$dbname};host={$host}", "{$user}", "{$psw}", [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        return $connection;
    }
}