<?php
// register.php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = $_POST['full_name'];
    $dateOfBirth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phone_number'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM job_seekers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('An account with this email already exists.');</script>";
    } else {
        // Insert new job seeker into database
        $stmt = $conn->prepare("INSERT INTO job_seekers (full_name, date_of_birth, gender, email, phone_number, password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $fullName, $dateOfBirth, $gender, $email, $phoneNumber, $password);

        if ($stmt->execute()) {
            header("Location: job_seekers_login.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
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
    <meta name="description" content="Register as a job seeker on JobGhana to start applying for jobs that match your profile and skills.">
    <meta name="keywords" content="job seeker registration, job application, JobGhana, register for jobs">
    <meta name="author" content="JobGhana">
    <?php include 'cdn.php' ?>
    <title>Job Seeker Registration - JobGhana</title>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/signup.css">
</head>

<body>
    <?php include 'header.php' ?>
    <div class="signup_all">
        <h2>Get started.</h2>
        <form method="POST" action="">
            <div class="forms">
                <label>Full Name</label>
                <input type="text" name="full_name" placeholder="Full Name" required>
            </div>

            <div class="forms_grid">
                <div class="forms">
                    <label>Date of Birth</label>
                    <input type="date" name="date_of_birth" required>
                </div>
                <div class="forms">
                    <label>Gender</label>
                    <select name="gender" required>
                        <option value="" selected hidden>Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>
            <div class="forms">
                <label>Email address</label>
                <input type="email" name="email" placeholder="Email" required>
            </div> 
            
            <div class="forms">
                <label>Phone Number</label>
                <input type="text" name="phone_number" placeholder="Phone Number" required>
            </div>
            <div class="forms">
                <label>Password</label>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="forms">
                <button type="submit">Register</button>
            </div>
            <div class="forms">
                <p>Already signed up? <a href="job_seekers_login.php">Log in</a></p>
            </div>
        </form>
    </div>
</body>

</html>
