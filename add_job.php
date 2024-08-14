<?php
include 'db.php';
session_start();

// Ensure employer_id is set in session
if (!isset($_SESSION['employer_id'])) {
    header("Location: login.php");
    exit();
}

$employerId = $_SESSION['employer_id'];

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if employer exists
    $stmt = $conn->prepare("SELECT id FROM employers WHERE id = ?");
    $stmt->bind_param("i", $employerId);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        echo "Employer ID does not exist.";
        exit();
    }

    $stmt->close();

    // Handle file upload
    if (isset($_FILES['company_logo']) && $_FILES['company_logo']['error'] == UPLOAD_ERR_OK) {
        $companyLogo = $_FILES['company_logo']['name'];
        $jobTitle = $_POST['job_title'];
        $companyName = $_POST['company_name'];
        $companyLocation = $_POST['company_location'];
        $jobType = $_POST['job_type'];
        $salary = $_POST['salary'];
        $aboutRole = $_POST['about_role'];

        // Define target directory
        $targetDir = "uploads/";
        $companyLogoPath = $targetDir . basename($companyLogo);

        if (move_uploaded_file($_FILES['company_logo']['tmp_name'], $companyLogoPath)) {
            // Insert job into the database
            $stmt = $conn->prepare("INSERT INTO jobs (employer_id, company_logo, job_title, company_name, company_location, job_type, salary, about_role) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isssssss", $employerId, $companyLogoPath, $jobTitle, $companyName, $companyLocation, $jobType, $salary, $aboutRole);

            if ($stmt->execute()) {
                echo " <script>alert('Job added successfully.');</script>";
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Failed to upload company logo.";
        }
    } else {
        echo "No file uploaded or upload error.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Add a job listing to JobGhana by providing details such as job title, company name, location, and more.">
    <meta name="keywords" content="add job listing, JobGhana, employer, job details">
    <meta name="author" content="JobGhana">
    <title>Add Job Listing - JobGhana</title>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/add_job.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.snow.min.css">
    <style>
        .forms {
            margin-bottom: 15px;
        }

        img {
            max-width: 100px;
            max-height: 100px;
        }
    </style>
</head>
<body>
    <div class="all_pages">
        <?php include 'sidebar.php'; ?>
        <div class="main_page ">
            <h2>Add Job Listing</h2>
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="forms">
                    <label for="company_logo">Company Logo:</label>
                    <input type="file" name="company_logo" id="company_logo" required>
                </div>
                <div class="forms">
                    <label for="job_title">Job Title:</label>
                    <input type="text" name="job_title" id="job_title" required>
                </div>
                <div class="forms">
                    <label for="company_name">Company Name:</label>
                    <input type="text" name="company_name" id="company_name" required>
                </div>
                <div class="forms">
                    <label for="company_location">Company Location:</label>
                    <input type="text" name="company_location" id="company_location" required>
                </div>
                <div class="forms">
                    <label for="job_type">Job Type:</label>
                    <select name="job_type" id="job_type" required>
                        <option value="" selected hidden>Select Job Type</option>
                        <option value="Remote">Remote</option>
                        <option value="In Person">In Person</option>
                        <option value="Hybrid">Hybrid</option>
                    </select>
                </div>
                <div class="forms">
                    <label for="salary">Salary:</label>
                    <input type="text" name="salary" id="salary" required>
                </div>
                <div class="forms">
                    <label for="about_role">About the Role:</label>
                    <div id="editor" style="height: 200px;"></div>
                    <textarea name="about_role" id="about_role" style="display:none;"></textarea>
                </div>
                <div class="forms">
                    <button type="submit">Add Job</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.min.js"></script>
    <script>
        var quill = new Quill('#editor', {
            theme: 'snow'
        });

        // Sync the content of Quill editor with the textarea
        document.querySelector('form').onsubmit = function() {
            document.querySelector('textarea[name=about_role]').value = quill.root.innerHTML;
        };
    </script>
</body>
</html>
