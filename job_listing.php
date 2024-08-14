<?php
include 'db.php';
session_start();

if (!isset($_SESSION['job_seeker_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch job listings
$stmt = $conn->prepare("SELECT id, company_logo, job_title, company_name, company_location, job_type, salary FROM jobs");
$stmt->execute();
$result = $stmt->get_result();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Browse job listings and view detailed information about each job.">
    <meta name="keywords" content="job listings, JobGhana, job search">
    <meta name="author" content="JobGhana">
    <?php include 'cdn.php'; ?>
    <title>Job Listings - JobGhana</title>
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
            background-color: #fff;
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
            align-self: center;
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
            color: #1c5947;
        }
        .jobs_flex{
            display: flex;
            gap: 20px;
        }
    </style>
    <script>
        function bookmarkJob(jobId) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "bookmark_job.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        alert("Job bookmarked successfully!");
                    } else {
                        alert("Failed to bookmark the job.");
                    }
                }
            };
            xhr.send("job_id=" + jobId);
        }
    </script>
</head>

<body>
    <div class="all_pages">
        <?php include 'sidebar.php'; ?>
        <div class="main_page job_l">
            <h2>Job Listings</h2>
            <?php while ($row = $result->fetch_assoc()): ?>
                <a href="view_job.php?id=<?php echo $row['id']; ?>" class="view_job">
                    <div class="job_card">
                        <div class="job_image">
                            <img src="<?php echo htmlspecialchars($row['company_logo']); ?>" alt="Company Logo">
                        </div>
                        <div class="job_details">
                            <h2><?php echo htmlspecialchars($row['job_title']); ?></h2>
                            <h4><?php echo htmlspecialchars($row['company_name']); ?></h4>
                            <div class="jobs_flex">
                            <p>Location: <?php echo htmlspecialchars($row['company_location']); ?></p>
                            <p>Job Type: <?php echo htmlspecialchars($row['job_type']); ?></p>
                            </div>
                            <p>Salary: <?php echo htmlspecialchars($row['salary']); ?></p>
                        </div>
                        <div class="job_ocon" onclick="bookmarkJob(<?php echo $row['id']; ?>)">
                            <h1><i class="fa-solid fa-bookmark"></i></h1>
                        </div>
                    </div>
                </a>
            <?php endwhile; ?>
        </div>
    </div>
</body>

</html>