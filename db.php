<?php
$servername = "dbmovierental.mysql.database.azure.com";
$username = "albatin";
$password = "Grupi7123";
$dbname = "movie_rental";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
