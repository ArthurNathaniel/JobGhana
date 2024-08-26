<?php
// login.php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM job_seekers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($jobSeekerId, $hashedPassword);

    if ($stmt->fetch() && password_verify($password, $hashedPassword)) {
        $_SESSION['job_seeker_id'] = $jobSeekerId;
        header("Location: profile.php");
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
    <meta name="description" content="Login to your JobGhana account to access job opportunities and manage your profile.">
    <meta name="keywords" content="job seeker login, JobGhana, access job portal">
    <meta name="author" content="JobGhana">
    <?php include 'cdn.php' ?>
    <title>Job Seeker Login - JobGhana</title>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/login.css">
</head>
<body>
<?php include 'header.php' ?>

  <div class="login_all">
  <h2>Job Seeker Login</h2>
    <form method="POST" action="">
    <div class="forms">
    <label>Email address</label>
    <input type="email" name="email" placeholder="Email" required>
    </div>
       <div class="forms">
    
       <label>Password</label>
       <input type="password" name="password" placeholder="Password" required>
       </div>
       <div class="forms">
       <button type="submit">Login</button>
       </div>
       <div class="forms">
        <p>New to JobGhana? <a href="job_seekers_signup.php">Create an account</a></p>
       </div>
    </form>
  </div>
</body>
</html>
