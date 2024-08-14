<?php
// db.php
$host = 'localhost';
$db = 'jobghana';
$user = 'root'; // Change if you have a different username
$pass = ''; // Change if you have a password set

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
