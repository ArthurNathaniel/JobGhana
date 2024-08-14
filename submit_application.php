<?php
include 'db.php';
session_start();

if (!isset($_SESSION['job_seeker_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jobId = intval($_POST['job_id']);
    $fullName = $_POST['full_name'];
    $location = $_POST['location'];
    $phoneNumber = $_POST['phone_number'];
    $email = $_POST['email'];

    // Handle file uploads
    $cv = $_FILES['cv'];
    $resume = $_FILES['resume'];
    
    if ($cv['error'] === UPLOAD_ERR_OK && $resume['error'] === UPLOAD_ERR_OK) {
        $cvPath = 'uploads/' . basename($cv['name']);
        $resumePath = 'uploads/' . basename($resume['name']);
        
        if (move_uploaded_file($cv['tmp_name'], $cvPath) && move_uploaded_file($resume['tmp_name'], $resumePath)) {
            // Prepare and execute the insertion query
            $stmt = $conn->prepare("INSERT INTO job_applications (job_id, job_seeker_id, full_name, location, phone_number, email, cv, resume) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iissssss", $jobId, $_SESSION['job_seeker_id'], $fullName, $location, $phoneNumber, $email, $cvPath, $resumePath);

            if ($stmt->execute()) {
                echo "Application submitted successfully!";
            } else {
                echo "Failed to submit application: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Failed to upload files.";
        }
    } else {
        echo "Error uploading files.";
    }
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
