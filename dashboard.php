<?php
// dashboard.php
include 'db.php';
session_start();

if (!isset($_SESSION['employer_id'])) {
    header("Location: login.php");
    exit();
}

$employerId = $_SESSION['employer_id'];

// Check approval status
$stmt = $conn->prepare("SELECT approved FROM employers WHERE id = ?");
$stmt->bind_param("i", $employerId);
$stmt->execute();
$stmt->bind_result($approved);
$stmt->fetch();
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Dashboard</title>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/dashboarsd.css">
</head>
<body>
    
    <div class="dashboard_all">
    <?php include 'sidebar.php' ?>

  
    <div class="dashboard_page">
    <h2>Welcome to Your Dashboard</h2>
    <?php if ($approved): ?>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>


        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>


        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>



        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <p>Your account has been approved. You can now access the full dashboard features.</p>
        <!-- Display additional dashboard features here -->
    <?php else: ?>
        <p>Your registration is pending approval. Please wait for an admin to review your information.</p>
    <?php endif; ?>
    </div>
    </div>
</body>
</html>
