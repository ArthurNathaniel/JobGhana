<?php
// get_employer_details.php
include 'db.php';

if (isset($_GET['id'])) {
    $employerId = $_GET['id'];

    // Fetch employer details
    $stmt = $conn->prepare("
        SELECT cd.registered_company_name, cd.trading_company_name, cd.company_email, cd.company_phone_number, cd.company_type, cd.business_certificate, cd.contact_number, cd.location, cd.ghana_card_id
        FROM company_details cd
        WHERE cd.employer_id = ?
    ");
    $stmt->bind_param("i", $employerId);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($registeredCompanyName, $tradingCompanyName, $companyEmail, $companyPhoneNumber, $companyType, $businessCertificate, $contactNumber, $location, $ghanaCardId);

    if ($stmt->fetch()) {
        echo "<p><strong>Registered Company Name:</strong> " . htmlspecialchars($registeredCompanyName) . "</p>";
        echo "<p><strong>Trading Company Name:</strong> " . htmlspecialchars($tradingCompanyName) . "</p>";
        echo "<p><strong>Company Email:</strong> " . htmlspecialchars($companyEmail) . "</p>";
        echo "<p><strong>Company Phone Number:</strong> " . htmlspecialchars($companyPhoneNumber) . "</p>";
        echo "<p><strong>Company Type:</strong> " . htmlspecialchars($companyType) . "</p>";
        echo "<p><strong>Business Certificate:</strong> <a href='" . htmlspecialchars($businessCertificate) . "' target='_blank'>View Certificate</a></p>";
        echo "<p><strong>Contact Number:</strong> " . htmlspecialchars($contactNumber) . "</p>";
        echo "<p><strong>Location:</strong> " . htmlspecialchars($location) . "</p>";
        echo "<p><strong>Ghana Card ID:</strong> <a href='" . htmlspecialchars($ghanaCardId) . "' target='_blank'>View ID</a></p>";
    } else {
        echo "<p>No details found.</p>";
    }

    $stmt->close();
}

$conn->close();
?>
