<?php
include 'db.php';
session_start();

if (!isset($_SESSION['job_seeker_id'])) {
    header("Location: login.php");
    exit();
}

// Function to calculate time difference
// Function to calculate time difference
function timeAgo($datetime, $full = false) {
    try {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        // Calculate weeks manually
        $weeks = floor($diff->days / 7); // Use days to calculate weeks
        $days = $diff->days % 7; // Remainder days after weeks calculation

        $string = [
            'y' => $diff->y . ' year' . ($diff->y > 1 ? 's' : ''),
            'm' => $diff->m . ' month' . ($diff->m > 1 ? 's' : ''),
            'w' => $weeks . ' week' . ($weeks > 1 ? 's' : ''),
            'd' => $days . ' day' . ($days > 1 ? 's' : ''),
            'h' => $diff->h . ' hour' . ($diff->h > 1 ? 's' : ''),
            'i' => $diff->i . ' minute' . ($diff->i > 1 ? 's' : ''),
            's' => $diff->s . ' second' . ($diff->s > 1 ? 's' : ''),
        ];

        // Remove empty time periods
        foreach ($string as $k => &$v) {
            if ($v === '0 year' || $v === '0 month' || $v === '0 week' || $v === '0 day' || $v === '0 hour' || $v === '0 minute' || $v === '0 second') {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1); // Show only the largest time unit
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    } catch (Exception $e) {
        return 'Unknown time';
    }
}



// Fetch job listings with the latest jobs first
$stmt = $conn->prepare("SELECT id, company_logo, job_title, company_name, company_location, job_type, salary, created_at FROM jobs ORDER BY created_at DESC");
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
    <?php include 'home_navbar.php'; ?>
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
                            <p>Posted: <?php echo htmlspecialchars(timeAgo($row['created_at'])); ?></p>
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
