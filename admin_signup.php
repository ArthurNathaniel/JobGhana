<?php
// admin_signup.php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO admins (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        header("Location: admin_login.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'cdn.php' ?>
    <title>Admin Signup - JobGhana</title>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/login.css">
</head>

<body>
    <?php include 'header.php' ?>

    <div class="login_all">
    <h2>Admin Signup</h2>
    <form method="POST" action="">
        <div class="forms">
            <input type="text" name="username" placeholder="Username" required>
        </div>
        <div class="forms">
            <input type="email" name="email" placeholder="Email" required>
        </div>
        <div class="forms">
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <div class="forms">
            <button type="submit">Sign Up</button>
        </div>
    </form>
    </div>
</body>

</html>