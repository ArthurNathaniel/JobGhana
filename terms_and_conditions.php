<?php
include 'db.php';
session_start();

if (!isset($_SESSION['employer_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Terms and Conditions for employers using JobGhana.">
    <meta name="keywords" content="terms and conditions, JobGhana, employer terms">
    <meta name="author" content="JobGhana">
    <?php include 'cdn.php'; ?>
    <title>Terms and Conditions - JobGhana</title>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/account_settings.css">
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="all_pages">
        <?php include 'sidebar.php'; ?>
        <div class="main_page">
            <h1>Terms and Conditions</h1>

            <p>Welcome to JobGhana. These terms and conditions outline the rules and regulations for the use of JobGhana's platform by employers.</p>

            <h2>1. Introduction</h2>
            <p>By accessing this platform, we assume you accept these terms and conditions in full. Do not continue to use JobGhana if you do not accept all of the terms and conditions stated on this page.</p>

            <h2>2. User Account</h2>
            <p>Employers are responsible for maintaining the confidentiality of their account information and for all activities that occur under their account.</p>

            <h2>3. Job Postings</h2>
            <p>Employers must provide accurate, complete, and updated information for all job postings. JobGhana reserves the right to remove any posting that is misleading or fraudulent.</p>

            <h2>4. Prohibited Activities</h2>
            <p>Employers are prohibited from:</p>
            <ul>
                <li>Posting false or misleading information.</li>
                <li>Engaging in spamming or unsolicited communications.</li>
                <li>Posting discriminatory or offensive content.</li>
            </ul>

            <h2>5. Intellectual Property</h2>
            <p>The content, layout, design, data, and graphics on this platform are protected by copyright and intellectual property laws. Unauthorized use is prohibited.</p>

            <h2>6. Termination</h2>
            <p>JobGhana reserves the right to terminate access to any employer account at its discretion, without notice, for conduct that violates these terms and conditions.</p>

            <h2>7. Limitation of Liability</h2>
            <p>JobGhana is not liable for any direct, indirect, incidental, consequential, or punitive damages arising out of or related to your use of this platform.</p>

            <h2>8. Changes to Terms</h2>
            <p>JobGhana reserves the right to modify these terms and conditions at any time. Changes will be effective immediately upon posting on this page.</p>

            <h2>9. Contact Us</h2>
            <p>If you have any questions about these Terms, please contact us at <span class="highlight">support@jobghana.com</span>.</p>

            <a href="account_settings.php" class="back_to_dashboard">Back to Account Settings</a>
            </div>
    </div>
</body>

</html>