<?php
// admin_login.php
include 'db.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM admins WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($adminId, $hashedPassword);

    if ($stmt->fetch() && password_verify($password, $hashedPassword)) {
        $_SESSION['admin_id'] = $adminId;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "Invalid email or password.";
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
    <title>Admin Login - JobGhana</title>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/login.css">
</head>

<body>
    <?php include 'header.php' ?>

    <div class="login_all">
        <h2>Admin Login</h2>
        <form method="POST" action="">
            <div class="forms">
                <label>Email Address:</label>
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="forms">
            <label>Password:</label>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="forms">
                <button type="submit">Login</button>
            </div>
        </form>
    </div>
</body>

</html>