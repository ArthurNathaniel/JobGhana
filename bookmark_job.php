<?php
include 'db.php';
session_start();

if (!isset($_SESSION['job_seeker_id'])) {
    http_response_code(401); // Unauthorized
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jobId = intval($_POST['job_id']);
    $jobSeekerId = $_SESSION['job_seeker_id'];

    // Check if the job is already bookmarked
    $stmt = $conn->prepare("SELECT * FROM bookmarked_jobs WHERE job_seeker_id = ? AND job_id = ?");
    $stmt->bind_param("ii", $jobSeekerId, $jobId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        // If not already bookmarked, insert a new bookmark
        $stmt = $conn->prepare("INSERT INTO bookmarked_jobs (job_seeker_id, job_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $jobSeekerId, $jobId);

        if ($stmt->execute()) {
            echo "Job bookmarked successfully!";
        } else {
            http_response_code(500); // Internal Server Error
            echo "Failed to bookmark the job.";
        }
    } else {
        echo "Job already bookmarked.";
    }
    $stmt->close();
    $conn->close();
} else {
    http_response_code(405); // Method Not Allowed
}
?>
