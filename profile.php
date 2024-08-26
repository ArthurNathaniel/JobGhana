<?php
// profile.php
include 'db.php';
session_start();

if (!isset($_SESSION['job_seeker_id'])) {
    header("Location: login.php");
    exit();
}

$jobSeekerId = $_SESSION['job_seeker_id'];

// Fetch job seeker details
$stmt = $conn->prepare("SELECT full_name, profile_picture, work_experience, interests_skills, education FROM job_seekers WHERE id = ?");
$stmt->bind_param("i", $jobSeekerId);
$stmt->execute();
$stmt->bind_result($fullName, $profilePicture, $workExperience, $interestsSkills, $education);
$stmt->fetch();
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="View your profile on JobGhana to see your work experience, skills, and education, and review your profile picture.">
    <meta name="keywords" content="job seeker profile, JobGhana, work experience, skills, education">
    <meta name="author" content="JobGhana">
    <title>Job Seeker Profile - JobGhana</title>
    <?php include 'cdn.php' ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/profile.css">
    <style>
      
    </style>
</head>
<body>
   <div class="all_pages">
   <?php include 'sidebar.php' ?>
   <div class="main_page">
   <h2>Job Seeker Profile</h2>
    <h3>Welcome, <?php echo htmlspecialchars($fullName); ?>!</h3>
    <div class="profile-section">
        <label>Profile Picture:</label>
        <?php if ($profilePicture): ?>
            <img src="<?php echo htmlspecialchars($profilePicture); ?>" alt="Profile Picture">
        <?php else: ?>
            <p>No profile picture uploaded.</p>
        <?php endif; ?>
    </div>
    <div class="profile-section">
        <label>Work Experience:</label>
        <p><?php echo $workExperience; ?></p>
    </div>
    <div class="profile-section">
        <label>Interests and Skills:</label>
        <p><?php echo $interestsSkills; ?></p>
    </div>
    <div class="profile-section">
        <label>Education:</label>
        <p><?php echo $education; ?></p>
    </div>
 <div class="edit_profile">
 <a href="edit_profile.php">
    <button>Edit Profile</button>
 </a>
 </div>
   </div>
   </div>
</body>
</html>
