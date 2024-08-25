<?php
include 'db.php';
session_start();

// Ensure employer_id is set in session
if (!isset($_SESSION['employer_id'])) {
    header("Location: login.php");
    exit();
}

$employerId = $_SESSION['employer_id'];

// Check if job ID is provided
if (!isset($_GET['id'])) {
    echo "Job ID is required.";
    exit();
}

$jobId = intval($_GET['id']);

// Fetch job details to ensure the job exists and belongs to the current employer
$stmt = $conn->prepare("SELECT company_logo FROM jobs WHERE id = ? AND employer_id = ?");
$stmt->bind_param("ii", $jobId, $employerId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('Job not found or you do not have permission to delete this job.');</script>";
    echo "<script>window.location.replace('view_jobs.php');</script>"; 
    exit();
}

$job = $result->fetch_assoc();
$stmt->close();

// Check if the job has any applications
$stmt = $conn->prepare("SELECT COUNT(*) FROM job_applications WHERE job_id = ?");
$stmt->bind_param("i", $jobId);
$stmt->execute();
$stmt->bind_result($applicationCount);
$stmt->fetch();
$stmt->close();

if ($applicationCount > 0) {
    echo "<script>alert('Cannot delete job because there are associated job applications.');</script>";
    echo "<script>window.location.replace('view_jobs.php');</script>"; 
    exit();
}

// Delete job from the database
$stmt = $conn->prepare("DELETE FROM jobs WHERE id = ? AND employer_id = ?");
$stmt->bind_param("ii", $jobId, $employerId);

if ($stmt->execute()) {
    // Optionally, delete the company logo file if it exists
    if (!empty($job['company_logo']) && file_exists($job['company_logo'])) {
        unlink($job['company_logo']);
    }
    echo "<script>alert('Job deleted successfully.');</script>";
    echo "<script>window.location.replace('view_jobs.php');</script>"; 
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
