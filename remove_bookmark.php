<?php
include 'db.php';
session_start();

if (!isset($_SESSION['job_seeker_id'])) {
    echo "You must be logged in to perform this action.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['job_id'])) {
    $jobSeekerId = $_SESSION['job_seeker_id'];
    $jobId = intval($_POST['job_id']);

    $stmt = $conn->prepare("DELETE FROM bookmarked_jobs WHERE job_seeker_id = ? AND job_id = ?");
    $stmt->bind_param("ii", $jobSeekerId, $jobId);

    if ($stmt->execute()) {
        echo "Success";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
