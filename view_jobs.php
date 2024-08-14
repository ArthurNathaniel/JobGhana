<?php
include 'db.php';
session_start();

// Ensure employer_id is set in session
if (!isset($_SESSION['employer_id'])) {
    header("Location: login.php");
    exit();
}

$employerId = $_SESSION['employer_id'];

// Fetch jobs added by the employer
$stmt = $conn->prepare("SELECT id, company_logo, job_title, company_name, company_location, job_type, salary, about_role FROM jobs WHERE employer_id = ?");
$stmt->bind_param("i", $employerId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Jobs - JobGhana</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/view_jobs.css">
    <style>
        .job-listing-table {
            width: 100%;
            border-collapse: collapse;
        }
        .job-listing-table th, .job-listing-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .job-listing-table th {
            background-color: #1c5947;
            color: #fff;
        }
        .job-listing-table img {
            max-width: 100px;
            max-height: 100px;
        }
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgb(0,0,0); 
            background-color: rgba(0,0,0,0.4); 
            padding-top: 60px; 
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto; 
            padding: 20px;
            border: 1px solid #888;
            width: 80%; 
        }
        .modal-content img{
            width: 100px;
            height: 100px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .actions{
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 150px;
        }
        .actions a{
            color: #000;
        }
    </style>
</head>
<body>
    <div class="all_pages">
        <?php include 'sidebar.php'; ?>
        <div class="main_page job_listing_view">
            <h2>Your Jobs</h2>
            <table class="job-listing-table">
                <thead>
                    <tr>
                        <th>Company Logo</th>
                        <th>Job Title</th>
                        <th>Company Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><img src="<?php echo htmlspecialchars($row['company_logo']); ?>" alt="Company Logo"></td>
                        <td><?php echo htmlspecialchars($row['job_title']); ?></td>
                        <td><?php echo htmlspecialchars($row['company_name']); ?></td>
                        <td class="actions">
                            <a href="#" class="view-job" data-id="<?php echo $row['id']; ?>"><i class="fa-regular fa-eye"></i></a> | 
                            <a href="edit_job.php?id=<?php echo $row['id']; ?>"><i class="fa-regular fa-pen-to-square"></i></a> | 
                            <a href="delete_job.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this job?');"><i class="fa-solid fa-trash-can"></i></a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for Viewing Job Details -->
    <div id="jobModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Job Details</h2>
            <div id="jobDetails"></div>
        </div>
    </div>

    <script>
        var modal = document.getElementById("jobModal");
        var span = document.getElementsByClassName("close")[0];
        var jobDetails = document.getElementById("jobDetails");

        document.querySelectorAll('.view-job').forEach(function(button) {
            button.onclick = function() {
                var jobId = this.getAttribute('data-id');

                fetch('get_job_details.php?id=' + jobId)
                    .then(response => response.json())
                    .then(data => {
                        jobDetails.innerHTML = `
                            <p><strong>Company Logo:</strong></p>
                            <img src="${data.company_logo}" alt="Company Logo">
                            <p><strong>Job Title:</strong> ${data.job_title}</p>
                            <p><strong>Company Name:</strong> ${data.company_name}</p>
                            <p><strong>Location:</strong> ${data.company_location}</p>
                            <p><strong>Job Type:</strong> ${data.job_type}</p>
                            <p><strong>Salary:</strong> ${data.salary}</p>
                            <p><strong>About the Role:</strong></p>
                            <div>${data.about_role}</div>
                        `;
                        modal.style.display = "block";
                    })
                    .catch(error => console.error('Error:', error));
            };
        });

        span.onclick = function() {
            modal.style.display = "none";
        };

        window.onclick = function(event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        };
    </script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
