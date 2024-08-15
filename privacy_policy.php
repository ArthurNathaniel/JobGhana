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
        <h1>Privacy Policy</h1>

<p>This Privacy Policy describes how JobGhana collects, uses, and discloses your information when you use our platform as an employer.</p>

<h2>1. Information We Collect</h2>
<p>We collect the following types of information:</p>
<ul>
    <li><strong>Personal Information:</strong> Name, email address, phone number, and other contact details.</li>
    <li><strong>Company Information:</strong> Registered company name, trading name, company type, and contact details.</li>
    <li><strong>Usage Data:</strong> Details about your interactions with our platform, including job postings and applications.</li>
</ul>

<h2>2. How We Use Your Information</h2>
<p>Your information is used for the following purposes:</p>
<ul>
    <li>To provide and maintain our services.</li>
    <li>To communicate with you about your account and services.</li>
    <li>To improve our platform and services.</li>
    <li>To comply with legal obligations.</li>
</ul>

<h2>3. Information Sharing</h2>
<p>We may share your information with third parties in the following circumstances:</p>
<ul>
    <li>With your consent or at your direction.</li>
    <li>For compliance with legal obligations.</li>
    <li>To protect the rights and safety of JobGhana, our users, and the public.</li>
</ul>

<h2>4. Data Security</h2>
<p>We implement appropriate security measures to protect your information from unauthorized access, alteration, disclosure, or destruction.</p>

<h2>5. Your Data Protection Rights</h2>
<p>You have the right to:</p>
<ul>
    <li>Access, update, or delete your personal information.</li>
    <li>Object to or restrict the processing of your data.</li>
    <li>Withdraw consent where we rely on your consent to process your data.</li>
</ul>

<h2>6. Changes to This Privacy Policy</h2>
<p>We may update our Privacy Policy from time to time. Any changes will be posted on this page, and we will notify you of any significant changes.</p>

<h2>7. Contact Us</h2>
<p>If you have any questions about this Privacy Policy, please contact us at <span class="highlight">privacy@jobghana.com</span>.</p>

<a href="account_settings.php" class="back_to_dashboard">Back to Account Settings</a>
        </div>
    </div>
</body>

</html>