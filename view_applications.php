<?php
include 'db.php';
session_start();

if (!isset($_SESSION['employer_id'])) {
    header("Location: login.php");
    exit();
}

$employerId = $_SESSION['employer_id'];

// Fetch job applications for the employer's jobs
$stmt = $conn->prepare("
    SELECT ja.id, ja.full_name, ja.location, ja.phone_number, ja.email, ja.cv, ja.resume, j.job_title
    FROM job_applications ja
    JOIN jobs j ON ja.job_id = j.id
    WHERE j.employer_id = ?
");
$stmt->bind_param("i", $employerId);
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Job Applications</title>
    <?php include 'cdn.php'; ?>

    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/applications.css">
   
</head>
<body>
<?php include 'navbar.php'; ?>

    <div class="all_pages">
        <?php include 'sidebar.php'; ?>
        <div class="main_page">
            <h2>Job Applications</h2>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($application = $result->fetch_assoc()): ?>
                    <div class="application-card">
                        <p><strong>Job Title: </strong><?php echo htmlspecialchars($application['job_title']); ?></p>
                        <p><strong>Full Name:</strong> <?php echo htmlspecialchars($application['full_name']); ?></p>
                        <p><strong>Location:</strong> <?php echo htmlspecialchars($application['location']); ?></p>
                        <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($application['phone_number']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($application['email']); ?></p>
                        <p><strong>Open: </strong><a href="<?php echo htmlspecialchars($application['cv']); ?>" target="_blank">View CV</a></p>
                        <p><strong>Open: </strong><a href="<?php echo htmlspecialchars($application['resume']); ?>" target="_blank">View Resume</a></p>                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No applications found for your jobs.</p>
            <?php endif; ?>
            <?php $stmt->close(); ?>
        </div>
    </div>
</body>
</html>
<?php $conn->close(); ?>
