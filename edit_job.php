<?php
include 'db.php';
session_start();

// Ensure employer_id is set in session
if (!isset($_SESSION['employer_id'])) {
    header("Location: login.php");
    exit();
}

$employerId = $_SESSION['employer_id'];

// Check if job ID is provided
if (!isset($_GET['id'])) {
    echo "Job ID is required.";
    exit();
}

$jobId = intval($_GET['id']);

// Fetch job details
$stmt = $conn->prepare("SELECT company_logo, job_title, company_name, company_location, job_type, salary, about_role FROM jobs WHERE id = ? AND employer_id = ?");
$stmt->bind_param("ii", $jobId, $employerId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Job not found or you do not have permission to edit this job.";
    exit();
}

$job = $result->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission
    $companyLogo = $_FILES['company_logo']['name'];
    $jobTitle = $_POST['job_title'];
    $companyName = $_POST['company_name'];
    $companyLocation = $_POST['company_location'];
    $jobType = $_POST['job_type'];
    $salary = $_POST['salary'];
    $aboutRole = $_POST['about_role'];

    // Handle file upload
    if ($companyLogo) {
        $targetDir = "uploads/";
        $companyLogoPath = $targetDir . basename($companyLogo);

        if (move_uploaded_file($_FILES['company_logo']['tmp_name'], $companyLogoPath)) {
            // Update job with new logo
            $stmt = $conn->prepare("UPDATE jobs SET company_logo = ?, job_title = ?, company_name = ?, company_location = ?, job_type = ?, salary = ?, about_role = ? WHERE id = ?");
            $stmt->bind_param("sssssssi", $companyLogoPath, $jobTitle, $companyName, $companyLocation, $jobType, $salary, $aboutRole, $jobId);
        } else {
            echo "Failed to upload company logo.";
            exit();
        }
    } else {
        // Update job without changing the logo
        $stmt = $conn->prepare("UPDATE jobs SET job_title = ?, company_name = ?, company_location = ?, job_type = ?, salary = ?, about_role = ? WHERE id = ?");
        $stmt->bind_param("ssssssi", $jobTitle, $companyName, $companyLocation, $jobType, $salary, $aboutRole, $jobId);
    }

    if ($stmt->execute()) {
        echo "Job updated successfully.";
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
    <title>Edit Job - JobGhana</title>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/edit_job.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.snow.min.css">
</head>
<body>
    <div class="all_pages">
        <?php include 'sidebar.php'; ?>
        <div class="main_page job_edit_form">
            <h2>Edit Job Listing</h2>
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="forms">
                    <label for="company_logo">Company Logo:</label>
                    <input type="file" name="company_logo" id="company_logo">
                    <?php if ($job['company_logo']): ?>
                        <img src="<?php echo htmlspecialchars($job['company_logo']); ?>" alt="Company Logo">
                    <?php endif; ?>
                </div>
                <div class="forms">
                    <label for="job_title">Job Title:</label>
                    <input type="text" name="job_title" id="job_title" value="<?php echo htmlspecialchars($job['job_title']); ?>" required>
                </div>
                <div class="forms">
                    <label for="company_name">Company Name:</label>
                    <input type="text" name="company_name" id="company_name" value="<?php echo htmlspecialchars($job['company_name']); ?>" required>
                </div>
                <div class="forms">
                    <label for="company_location">Company Location:</label>
                    <input type="text" name="company_location" id="company_location" value="<?php echo htmlspecialchars($job['company_location']); ?>" required>
                </div>
                <div class="forms">
                    <label for="job_type">Job Type:</label>
                    <select name="job_type" id="job_type" required>
                        <option value="Remote" <?php echo $job['job_type'] === 'Remote' ? 'selected' : ''; ?>>Remote</option>
                        <option value="In Person" <?php echo $job['job_type'] === 'In Person' ? 'selected' : ''; ?>>In Person</option>
                        <option value="Hybrid" <?php echo $job['job_type'] === 'Hybrid' ? 'selected' : ''; ?>>Hybrid</option>
                    </select>
                </div>
                <div class="forms">
                    <label for="salary">Salary:</label>
                    <input type="text" name="salary" id="salary" value="<?php echo htmlspecialchars($job['salary']); ?>">
                </div>
                <div class="forms">
                    <label for="about_role">About the Role:</label>
                    <div id="editor" style="height: 200px;"><?php echo htmlspecialchars(strip_tags($job['about_role'])); ?></div>
                    <textarea name="about_role" id="about_role" style="display:none;"><?php echo htmlspecialchars(strip_tags($job['about_role'])); ?></textarea>
                </div>
                <div class="forms">
                    <button type="submit">Update Job</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.min.js"></script>
    <script>
        // Initialize Quill editor
        var quill = new Quill('#editor', {
            theme: 'snow'
        });

        // Set editor content
        quill.root.innerHTML = `<?php echo addslashes(strip_tags($job['about_role'])); ?>`;

        // Sync the content of Quill editor with the textarea
        document.querySelector('form').onsubmit = function() {
            document.querySelector('textarea[name=about_role]').value = quill.root.innerHTML;
        };
    </script>
</body>
</html>
