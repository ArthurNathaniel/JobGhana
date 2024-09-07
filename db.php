<?php
// db.php
$host = 'localhost';
$db = 'jobghana';
$user = 'root'; // Change if you have a different username
$pass = ''; // Change if you have a password set

// $host = 'longwellconnect.com';
// $db = 'u500921674_jobghana';
// $user = 'u500921674_jobghana'; // Change if you have a different username
// $pass = 'OnGod@123'; // Change if you have a password set

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
