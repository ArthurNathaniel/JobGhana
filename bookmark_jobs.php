<?php
include 'db.php';
session_start();

if (!isset($_SESSION['job_seeker_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch bookmarked jobs
$jobSeekerId = $_SESSION['job_seeker_id'];
$stmt = $conn->prepare("SELECT jobs.id, jobs.company_logo, jobs.job_title, jobs.company_name, jobs.company_location, jobs.job_type, jobs.salary FROM jobs INNER JOIN bookmarked_jobs ON jobs.id = bookmarked_jobs.job_id WHERE bookmarked_jobs.job_seeker_id = ?");
$stmt->bind_param("i", $jobSeekerId);
$stmt->execute();
$result = $stmt->get_result();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Your bookmarked job listings.">
    <meta name="keywords" content="bookmarked jobs, JobGhana">
    <meta name="author" content="JobGhana">
    <?php include 'cdn.php'; ?>
    <title>Bookmarked Jobs - JobGhana</title>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/job_listings.css">
    <style>
        .job_card {
            border: 2px solid #ddd;
            padding: 10px;
            margin-bottom: 20px;
            display: flex;
            position: relative;
            gap: 20px;
            text-decoration: none;
            color: inherit;
            background-color: #f9f9f9;
        }

        .job_image img {
            height: 150px;
            width: 150px;
            object-fit: cover;
            border: 2px solid #ddd;
        }

        .job_details {
            display: flex;
            flex-direction: column;
        }

        .job_details h2 {
            margin: 0;
        }

        .job_details p {
            margin: 5px 0;
        }

        .apply_button {
            margin-top: 10px;
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

        .view_job {
            color: #000;
            text-decoration: none;
        }

        .job_l {
            padding: 0 5%;
        }

        .job_ocon {
            position: absolute;
            right: 20px;
            cursor: pointer;
        }

        .job_ocon i {
            color: red;
        }

        .job_ocon i:hover {
            color: #cc0000;
        }
    </style>
    <script>
        function bookmarkJob(jobId) {
            if (confirm('Are you sure you want to remove this job from your bookmarks?')) {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'remove_bookmark.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        alert('Job removed from bookmarks.');
                        location.reload(); // Refresh the page to update the list
                    } else {
                        alert('Failed to remove job from bookmarks. Please try again.');
                    }
                };
                xhr.send('job_id=' + jobId);
            }
        }
    </script>
</head>
<body>
    <div class="all_pages">
        <?php include 'sidebar.php'; ?>
        <div class="main_page job_l">
            <h2>Bookmarked Jobs</h2>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                <a href="view_job.php?id=<?php echo $row['id']; ?>" class="view_job">
                    <div class="job_card">
                        <div class="job_image">
                            <img src="<?php echo htmlspecialchars($row['company_logo']); ?>" alt="Company Logo">
                        </div>
                        <div class="job_details">
                            <h2><?php echo htmlspecialchars($row['job_title']); ?></h2>
                            <h4><?php echo htmlspecialchars($row['company_name']); ?></h4>
                            <p>Location: <?php echo htmlspecialchars($row['company_location']); ?></p>
                            <p>Job Type: <?php echo htmlspecialchars($row['job_type']); ?></p>
                            <p>Salary: <?php echo htmlspecialchars($row['salary']); ?></p>
                        </div>
                        <div class="job_ocon" onclick="bookmarkJob(<?php echo $row['id']; ?>)">
                            <h1><i class="fa-solid fa-trash-can"></i></h1>
                        </div>
                    </div>
                </a>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No bookmarked jobs found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
