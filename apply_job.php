<?php
include 'db.php';
session_start();

if (!isset($_SESSION['job_seeker_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    echo "Job ID is required.";
    exit();
}

$jobId = intval($_GET['id']);

// Fetch job details
$stmt = $conn->prepare("SELECT job_title FROM jobs WHERE id = ?");
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
    <title>Apply for Job - JobGhana</title>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/apply_job.css">
    <style>
        .apply_form {
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .form-group input[type="file"] {
            padding: 0;
        }

        .submit_button {
            padding: 10px 15px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .submit_button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="all_pages">
        <?php include 'sidebar.php'; ?>
        <div class="main_page">
            <h1>Apply for Job</h1>
            <div class="apply_form">
                <h2><?php echo htmlspecialchars($job['job_title']); ?></h2>
                <form method="POST" action="submit_application.php" enctype="multipart/form-data">
                    <input type="hidden" name="job_id" value="<?php echo $jobId; ?>">
                    <div class="form-group">
                        <label for="full_name">Full Name:</label>
                        <input type="text" name="full_name" id="full_name" value="<?php echo htmlspecialchars($_SESSION['full_name']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="location">Location:</label>
                        <input type="text" name="location" id="location" required>
                    </div>
                    <div class="form-group">
                        <label for="phone_number">Phone Number:</label>
                        <input type="text" name="phone_number" id="phone_number" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address:</label>
                        <input type="email" name="email" id="email" required>
                    </div>
                    <div class="form-group">
                        <label for="cv">CV:</label>
                        <input type="file" name="cv" id="cv" required>
                    </div>
                    <div class="form-group">
                        <label for="resume">Resume:</label>
                        <input type="file" name="resume" id="resume" required>
                    </div>
                    <button type="submit" class="submit_button">Submit Application</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
