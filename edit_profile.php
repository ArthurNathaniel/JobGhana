<?php
// edit_profile.php
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

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $workExperience = $_POST['work_experience'];
    $interestsSkills = $_POST['interests_skills'];
    $education = $_POST['education'];

    // Handle profile picture upload
    if ($_FILES['profile_picture']['name']) {
        $profilePicture = $_FILES['profile_picture']['name'];
        $targetDir = "uploads/";
        $profilePicturePath = $targetDir . basename($profilePicture);

        if (!move_uploaded_file($_FILES['profile_picture']['tmp_name'], $profilePicturePath)) {
            echo "Failed to upload profile picture.";
            exit();
        }
    } else {
        $profilePicturePath = $profilePicture;
    }

    $stmt = $conn->prepare("UPDATE job_seekers SET profile_picture = ?, work_experience = ?, interests_skills = ?, education = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $profilePicturePath, $workExperience, $interestsSkills, $education, $jobSeekerId);

    if ($stmt->execute()) {
        echo "<script>alert('Profile updated successfully.'); window.location.href='profile.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Edit your profile on JobGhana by updating your work experience, skills, and education, and upload a new profile picture to enhance your profile.">
    <meta name="keywords" content="edit job seeker profile, JobGhana, work experience, skills, education">
    <meta name="author" content="JobGhana">
    <?php include 'cdn.php'; ?>
    <title>Edit Job Seeker Profile - JobGhana</title>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/profile.css">
    
<script src="https://cdn.tiny.cloud/1/zfduric1ly2fmnq9xzc5iu2oql6wk6ljmn2jezstfrbfsvor/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
        tinymce.init({
            selector: 'textarea',  // Apply TinyMCE to all textarea elements
            plugins: 'lists link image table',
            toolbar: 'undo redo | bold italic | bullist numlist outdent indent | link image table',
            menubar: false  // Optionally hide the menu bar
        });
    </script>
</head>
<body>
<div class="all_pages">
   <?php include 'sidebar.php' ?>
   <div class="main_page">
    <h2>Edit Job Seeker Profile</h2>
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="profile-section">
            <label for="profile_picture">Profile Picture:</label>
            <?php if ($profilePicture): ?>
                <img src="<?php echo htmlspecialchars($profilePicture); ?>" alt="Profile Picture">
            <?php endif; ?>
            <input type="file" name="profile_picture" id="profile_picture">
        </div>
        <div class="profile-section">
            <label for="work_experience">Work Experience:</label>
            <textarea name="work_experience" id="work_experience"><?php echo htmlspecialchars($workExperience); ?></textarea>
        </div>
        <div class="profile-section">
            <label for="interests_skills">Interests and Skills:</label>
            <textarea name="interests_skills" id="interests_skills"><?php echo htmlspecialchars($interestsSkills); ?></textarea>
        </div>
        <div class="profile-section">
            <label for="education">Education:</label>
            <textarea name="education" id="education"><?php echo htmlspecialchars($education); ?></textarea>
        </div>
       <div class="edit_profile_btns">
       <button type="submit">Save Changes</button>
       <a href="profile.php">Cancel</a>
       </div>
    </form>
  
    </div>
    </div>
</body>
</html>
