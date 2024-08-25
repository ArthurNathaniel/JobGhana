<?php
include 'db.php';
session_start();

if (!isset($_SESSION['job_seeker_id'])) {
    header("Location: job_seekers_login.php");
    exit();
}

// Ensure job ID is set
if (!isset($_GET['id'])) {
    echo "Job ID is required.";
    exit();
}

$jobId = intval($_GET['id']);

// Fetch job details
$stmt = $conn->prepare("SELECT company_logo, job_title, company_name, company_location, job_type, salary, about_role FROM jobs WHERE id = ?");
$stmt->bind_param("i", $jobId);
$stmt->execute();
$job = $stmt->get_result()->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Job - JobGhana</title>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/view_job.css">
    <style>
        .job_details {
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 20px;
        }

        .job_image img {
            max-width: 200px;
            height: auto;
            border: 1px solid #ddd;
        }

        .apply_button {
            margin-top: 20px;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            border-radius: 5px;
        }

        .apply_button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="all_pages">
        <?php include 'sidebar.php'; ?>
        <div class="main_page">
            <h2><?php echo htmlspecialchars($job['job_title']); ?></h2>
            <div class="job_details">
                <div class="job_image">
                    <img src="<?php echo htmlspecialchars($job['company_logo']); ?>" alt="Company Logo">
                </div>
                <h3><?php echo htmlspecialchars($job['company_name']); ?></h3>
                <p><strong>Location:</strong> <?php echo htmlspecialchars($job['company_location']); ?></p>
                <p><strong>Job Type:</strong> <?php echo htmlspecialchars($job['job_type']); ?></p>
                <p><strong>Salary:</strong> <?php echo htmlspecialchars($job['salary']); ?></p>
                <p><strong>About the Role:</strong> <?php echo htmlspecialchars($job['about_role']); ?></p>
                <a href="apply_job.php?id=<?php echo $jobId; ?>" class="apply_button">Apply Now</a>
            </div>
        </div>
    </div>
</body>
</html>
