<?php
include 'db.php';
session_start();

if (!isset($_SESSION['employer_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch company details for the logged-in employer
$employerId = $_SESSION['employer_id'];
$stmt = $conn->prepare("SELECT * FROM company_details WHERE employer_id = ?");
$stmt->bind_param("i", $employerId);
$stmt->execute();
$result = $stmt->get_result();
$company = $result->fetch_assoc();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="View your company details.">
    <meta name="keywords" content="company details, JobGhana">
    <meta name="author" content="JobGhana">
    <?php include 'cdn.php'; ?>
    <title>Company Details - JobGhana</title>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/company_details.css">
    <style>
       .account_setting{
        border: 2px dashed #ddd;
        display: flex;
        gap: 30px;
        align-items: center;
        padding: 0 2%;
        padding-block: 20px;
        margin-top: 20px;
       }
       .account_setting a{
        text-decoration: none;
        color: #000;
        height: 100%;
       }
       .account_details a{
        text-decoration: none;
        color: #333;
       }
       .account_icons{
        background-color: #ddd;
        padding: 0 10px;
        padding-block: 3px;
       }
       .account_icons i{
       color: #1c5947;
       }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>
    <div class="all_pages">
    <?php include 'sidebar_employer.php'; ?>
    <div class="main_page">
         <h1>Accont Setting</h1>
         <div class="account_setting">
            <div class="account_icons">
                <h1><i class="fa-solid fa-lock"></i></h1>
            </div>
            <div class="account_details">
                <h3>Password</h3>
                <p><a href="">Request for a change of password</a></p>
            </div>
         </div>

         <div class="account_setting">
            <div class="account_icons">
                <h1><i class="fa-solid fa-briefcase"></i></h1>
            </div>
            <a href="terms_and_conditions.php">
            <div class="account_details">
                <h3>Terms and Conditions</h3>
                <p>Learn about our terms to ensure your don't misuse JobGhana</p>
            </div>
            </a>
         </div>

         <div class="account_setting">
            <div class="account_icons">
                <h1><i class="fa-solid fa-file-lines"></i></h1>
            </div>
            <a href="privacy_policy.php">
            <div class="account_details">
                <h3>Privacy policy</h3>
                <p>Learn about how JobGhana is committed to protecting your privacy</p>
            </div>
            </a>
         </div>

        </div>
    </div>

  

</body>
</html>
