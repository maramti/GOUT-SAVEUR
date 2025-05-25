<?php
$servername = "localhost";
$db_username = "maram";
$db_pwd = "ekhdemstp777";
$db_name = "db_pfa";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$db_name", $db_username, $db_pwd);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>