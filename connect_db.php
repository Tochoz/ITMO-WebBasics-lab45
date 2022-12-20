<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbtitle = "denisnovik";
// Create connection


try {
//    $db = new PDO(`mysql:host={$servername};dbname={$dbname};chapset=utf8`,$username,$password);    // set the PDO error mode to exception
    $db = new PDO("mysql:host=$servername;dbname=$dbtitle", $username, $password);    // set the PDO error mode to exception

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//    echo "Database connected successfully<br>";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "<br>";
}
?>