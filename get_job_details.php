<?php
include 'db.php';

if (isset($_GET['id'])) {
    $jobId = intval($_GET['id']);

    $stmt = $conn->prepare("SELECT company_logo, job_title, company_name, company_location, job_type, salary, about_role FROM jobs WHERE id = ?");
    $stmt->bind_param("i", $jobId);
    $stmt->execute();
    $stmt->bind_result($companyLogo, $jobTitle, $companyName, $companyLocation, $jobType, $salary, $aboutRole);
    $stmt->fetch();

    $jobDetails = array(
        'company_logo' => $companyLogo,
        'job_title' => $jobTitle,
        'company_name' => $companyName,
        'company_location' => $companyLocation,
        'job_type' => $jobType,
        'salary' => $salary,
        'about_role' => $aboutRole
    );

    echo json_encode($jobDetails);

    $stmt->close();
}

$conn->close();
?>
