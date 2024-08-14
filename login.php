<?php
// login.php
include 'db.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password, approved, profile_completed FROM employers WHERE work_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($employerId, $hashedPassword, $approved, $profileCompleted);

    if ($stmt->fetch() && password_verify($password, $hashedPassword)) {
        if (!$profileCompleted) {
            // Redirect to company details if profile is not completed
            $_SESSION['employer_id'] = $employerId;
            header("Location: company_details.php");
            exit();
        } elseif (!$approved) {
            // Inform the user if their account is pending approval
            echo "Your account is pending approval.";
        } else {
            // Redirect to the dashboard if approved
            $_SESSION['employer_id'] = $employerId;
            header("Location: dashboard.php");
            exit();
        }
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
    <meta name="description" content="Log in to JobGhana to access your employer account. Manage job postings, review applications, and connect with top talent in Ghana.">
    <meta name="keywords" content="employer login, JobGhana, job portal Ghana, login employer, manage job postings, review applications">
    <meta name="author" content="JobGhana">
    <?php include 'cdn.php' ?>
    <title>Employer Login - JobGhana</title>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/login.css">
</head>

<body>
<?php include 'header.php' ?>

    <div class="login_all">
        <div class="forms">
            <h2>Employer Login</h2>
        </div>
        <form method="POST" action="">
            <div class="forms">
                <label>Email address</label>
                <input type="email" name="email" required>
            </div>
            <div class="forms">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <div class="forms">
                <button type="submit">Login</button>
            </div>
        </form>
    </div>
</body>

</html>