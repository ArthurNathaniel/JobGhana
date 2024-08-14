<?php
// upload_documents.php
include 'db.php';
session_start();

if (!isset($_SESSION['employer_id'])) {
    header("Location: login.php");
    exit();
}

$employerId = $_SESSION['employer_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $businessCertificate = $_FILES['business_certificate']['name'];
    $contactNumber = $_POST['contact_number'];
    $location = $_POST['location'];
    $ghanaCardId = $_FILES['ghana_card_id']['name'];
    $profilePicture = $_FILES['profile_picture']['name'];

    $targetDir = "uploads/";
    $businessCertificatePath = $targetDir . basename($businessCertificate);
    $ghanaCardIdPath = $targetDir . basename($ghanaCardId);
    $profilePicturePath = $targetDir . basename($profilePicture);

    if (move_uploaded_file($_FILES['business_certificate']['tmp_name'], $businessCertificatePath) &&
        move_uploaded_file($_FILES['ghana_card_id']['tmp_name'], $ghanaCardIdPath) &&
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], $profilePicturePath)) {
        
        $stmt = $conn->prepare("UPDATE company_details SET business_certificate = ?, contact_number = ?, location = ?, ghana_card_id = ?, profile_picture = ? WHERE employer_id = ?");
        $stmt->bind_param("sssssi", $businessCertificatePath, $contactNumber, $location, $ghanaCardIdPath, $profilePicturePath, $employerId);

        if ($stmt->execute()) {
            // Update employer status to pending
            $stmtUpdate = $conn->prepare("UPDATE employers SET approved = 0 WHERE id = ?");
            $stmtUpdate->bind_param("i", $employerId);
            $stmtUpdate->execute();
            $stmtUpdate->close();

            header("Location: dashboard.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Failed to upload files.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Provide or update your business certificate, contact number, location, Ghana card ID, and profile picture on JobGhana to ensure your company profile is complete and up-to-date.">
    <meta name="keywords" content="business certificate, contact number, company location, Ghana card ID, profile picture, JobGhana, employer profile, update business details">
    <meta name="author" content="JobGhana">
    <title>Upload Documents - JobGhana</title>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/company_details.css">
</head>
<body>
<?php include 'header.php'; ?>

<div class="company_details_all">
    <div class="forms">
        <h2>Upload Documents</h2>
    </div>
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="forms">
            <label for="business_certificate">Business Certificate:</label>
            <input type="file" name="business_certificate" id="business_certificate" required>
        </div>
        <div class="forms">
            <label>Contact Number:</label>
            <input type="text" name="contact_number" placeholder="Contact Number" required>
        </div>
        <div class="forms">
            <label>Location:</label>
            <input type="text" name="location" placeholder="Location" required>
        </div>
        <div class="forms">
            <label for="ghana_card_id">Ghana Card ID:</label>
            <input type="file" name="ghana_card_id" id="ghana_card_id" required>
        </div>
        <div class="forms">
            <label for="profile_picture">Profile Picture:</label>
            <input type="file" name="profile_picture" id="profile_picture" required>
        </div>
        <div class="forms">
            <button type="submit">Submit</button>
        </div>
    </form>
</div>
</body>
</html>
