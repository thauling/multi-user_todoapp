<?php
//session_start();

// connect to database and return db object
function connectToDbPdo($dbparams)
{
    $dbname = $dbparams[0];
    $host = $dbparams[1];
    $user = $dbparams[2];
    $psw = $dbparams[3];
    try {
        //print "host: {$host}, user: {$user}, psw: {$psw}, dbname: {$dbname}<br>";
        $connection = new PDO("mysql:dbname={$dbname};host={$host}", "{$user}", "{$psw}", [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        //isset($connection) ? print "Connected" : "Not connected"; 
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        return $connection;
    }
}