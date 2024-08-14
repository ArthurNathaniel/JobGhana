<?php
// company_details.php
include 'db.php';
session_start();

if (!isset($_SESSION['employer_id'])) {
    header("Location: login.php");
    exit();
}

$employerId = $_SESSION['employer_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $registeredCompanyName = $_POST['registered_company_name'];
    $tradingCompanyName = $_POST['trading_company_name'];
    $companyEmail = $_POST['company_email'];
    $companyPhoneNumber = $_POST['company_phone_number'];
    $companyType = $_POST['company_type'];

    $stmt = $conn->prepare("INSERT INTO company_details (employer_id, registered_company_name, trading_company_name, company_email, company_phone_number, company_type) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $employerId, $registeredCompanyName, $tradingCompanyName, $companyEmail, $companyPhoneNumber, $companyType);

    if ($stmt->execute()) {
        // Update profile_completed to true
        $stmtUpdate = $conn->prepare("UPDATE employers SET profile_completed = 1 WHERE id = ?");
        $stmtUpdate->bind_param("i", $employerId);
        $stmtUpdate->execute();
        $stmtUpdate->close();

        header("Location: upload_documents.php");
        exit();
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
    <meta name="description" content="Update or view company details on JobGhana. Enter your registered company name, trading name, email, and phone number to ensure your company profile is accurate.">
    <meta name="keywords" content="company details, JobGhana, update company information, employer profile, registered company name, trading company name, company email, company phone number">
    <meta name="author" content="JobGhana">
    <title>Company Details - JobGhana</title>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/company_details.css">
</head>

<body>
    <?php include 'header.php' ?>

    <div class="company_details_all">
        <div class="forms">
            <h2>Company Details</h2>
        </div>
        <form method="POST" action="">
            <div class="forms">
                <label>Registered Company Name</label>
                <input type="text" name="registered_company_name" placeholder="Registered Company Name" required>
            </div>
            <div class="forms">
                <label>Trading Company Name</label>
                <input type="text" name="trading_company_name" placeholder="Trading Company Name (Optional)">
            </div>
            <div class="forms">
                <label>Company Email</label>
                <input type="email" name="company_email" placeholder="Company Email" required>
            </div>
            <div class="forms">
                <label>Company Phone Number</label>
                <input type="text" name="company_phone_number" placeholder="Company Phone Number" required>
            </div>
            <div class="forms">
                <label>Company Type</label>
                <select name="company_type" required>
                    <option value="" selected hidden>Select Company Type</option>

                    <option value="private">Private</option>
                    <option value="public">Public</option>
                </select>
            </div>
            <div class="forms">
                <button type="submit">Next</button>
            </div>
        </form>
    </div>
</body>

</html>