<?php
include 'db.php';
session_start();

if (!isset($_SESSION['employer_id'])) {
    header("Location: login.php");
    exit();
}

$employerId = $_POST['employer_id'];
$registeredCompanyName = $_POST['registered_company_name'];
$tradingCompanyName = $_POST['trading_company_name'];
$companyEmail = $_POST['company_email'];
$companyPhoneNumber = $_POST['company_phone_number'];
$companyType = $_POST['company_type'];
$contactNumber = $_POST['contact_number'];
$location = $_POST['location'];

// Handle profile picture upload
$profilePicturePath = $_POST['existing_profile_picture'];
if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES['profile_picture']['name']);
    if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $targetFile)) {
        $profilePicturePath = $targetFile;
    }
}

// Update company details in the database
$stmt = $conn->prepare("UPDATE company_details SET registered_company_name = ?, trading_company_name = ?, company_email = ?, company_phone_number = ?, company_type = ?, contact_number = ?, location = ?, profile_picture = ? WHERE employer_id = ?");
$stmt->bind_param("ssssssssi", $registeredCompanyName, $tradingCompanyName, $companyEmail, $companyPhoneNumber, $companyType, $contactNumber, $location, $profilePicturePath, $employerId);

if ($stmt->execute()) {
    header("Location: business_profile.php");
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>
