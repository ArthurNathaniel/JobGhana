<?php
// signup.php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = $_POST['full_name'];
    $email = $_POST['work_email'];
    $phone = $_POST['phone_number'];
    $role = $_POST['role'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO employers (full_name, work_email, phone_number, role, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $fullName, $email, $phone, $role, $password);

    if ($stmt->execute()) {
        header("Location: login.php");
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
    <meta name="description" content="Sign up as an employer on JobGhana, Ghana's leading job portal. Find and hire top talent in Ghana quickly and efficiently.">
    <meta name="keywords" content="employer signup, JobGhana, job portal Ghana, hiring in Ghana, recruit talent, employer registration">
    <meta name="author" content="JobGhana">
    <?php include 'cdn.php' ?>
    <title>Employer Signup - JobGhana</title>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/signup.css">
</head>

<body>
    <?php include 'header.php' ?>
    <div class="signup_all">
       <div class="forms">
       <h2>Get started.</h2>
       <p>Set up your account as your company admin.</p>
       </div>

        <form method="POST" action="">
            <div class="forms">
                <label>Full name</label>
                <input type="text" name="full_name" placeholder="Eg. Anthony Kusi" required>
            </div>

            <div class="forms">
                <label>Email Address</label>
                <input type="email" name="work_email" placeholder="Work Email" required>
            </div>

            <div class="forms">
                <label>Phone Number</label>
                <input type="text" name="phone_number" placeholder="Phone Number" required>
            </div>
            <div class="forms">
                <label>Role at Company</label>
                <select name="role" required>
                    <option value="" selected hidden>Select Role at Company</option>
                    <option value="CEO">CEO</option>
                    <option value="Manager">Manager</option>
                    <option value="HR">HR</option>
                </select>
            </div>

            <div class="forms">
            <label>Password</label>
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <div class="forms">
                <button type="submit">Sign Up</button>
            </div>

            <div class="forms">
                <p>Already signed up? <a href="login.php">Log in</a></p>
            </div>

        </form>
    </div>
</body>

</html>