<?php
include 'db.php';
session_start();

if (!isset($_SESSION['employer_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch Business Profile for the logged-in employer
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
    <meta name="description" content="View your Business Profile.">
    <meta name="keywords" content="Business Profile, JobGhana">
    <meta name="author" content="JobGhana">
    <?php include 'cdn.php'; ?>
    <title>Business Profile - JobGhana</title>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/business_profile.css">
    
</head>
<body>
<?php include 'navbar.php'; ?>
    <div class="all_pages">
        <?php include 'sidebar_employer.php'; ?>
        <div class="main_page">
            <div class="company_details_container">
                <div class="company_details_header">
                    <h2>Business Profile</h2>
                </div>
                <div class="company_profile_picture">
                    <img src="<?php echo htmlspecialchars($company['profile_picture']); ?>" alt="Company Profile Picture">
                </div>
                <div class="company_info">
                    <h3>Registered Company Name: <?php echo htmlspecialchars($company['registered_company_name']); ?></h3>
                    <p><strong>Trading Company Name:</strong> <?php echo htmlspecialchars($company['trading_company_name']); ?></p>
                    <p><strong>Company Email:</strong> <?php echo htmlspecialchars($company['company_email']); ?></p>
                    <p><strong>Company Phone Number:</strong> <?php echo htmlspecialchars($company['company_phone_number']); ?></p>
                    <p><strong>Company Type:</strong> <?php echo htmlspecialchars($company['company_type']); ?></p>
                    <p><strong>Contact Number:</strong> <?php echo htmlspecialchars($company['contact_number']); ?></p>
                    <p><strong>Location:</strong> <?php echo htmlspecialchars($company['location']); ?></p>
                </div>
                <button class="edit_button" id="editBtn">Edit</button>
            </div>
        </div>
    </div>

    <!-- Modal for editing Business Profile -->
    <div id="editModal" class="modal">
        <div class="modal_content">
            <span class="close">&times;</span>
            <form class="modal_form" action="update_company_details.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="employer_id" value="<?php echo $employerId; ?>">
                <label for="registered_company_name">Registered Company Name:</label>
                <input type="text" name="registered_company_name" id="registered_company_name" value="<?php echo htmlspecialchars($company['registered_company_name']); ?>" required>

                <label for="trading_company_name">Trading Company Name:</label>
                <input type="text" name="trading_company_name" id="trading_company_name" value="<?php echo htmlspecialchars($company['trading_company_name']); ?>">

                <label for="company_email">Company Email:</label>
                <input type="email" name="company_email" id="company_email" value="<?php echo htmlspecialchars($company['company_email']); ?>" required>

                <label for="company_phone_number">Company Phone Number:</label>
                <input type="tel" name="company_phone_number" id="company_phone_number" value="<?php echo htmlspecialchars($company['company_phone_number']); ?>" required>

                <label for="company_type">Company Type:</label>
                <select name="company_type" id="company_type" required>
                    <option value="private" <?php if ($company['company_type'] == 'private') echo 'selected'; ?>>Private</option>
                    <option value="public" <?php if ($company['company_type'] == 'public') echo 'selected'; ?>>Public</option>
                </select>

                <label for="contact_number">Contact Number:</label>
                <input type="tel" name="contact_number" id="contact_number" value="<?php echo htmlspecialchars($company['contact_number']); ?>">

                <label for="location">Location:</label>
                <input type="text" name="location" id="location" value="<?php echo htmlspecialchars($company['location']); ?>">

                <label for="profile_picture">Profile Picture:</label>
                <input type="file" name="profile_picture" id="profile_picture">

                <button type="submit">Save Changes</button>
            </form>
        </div>
    </div>

    <script>
        // Get modal and button elements
        var modal = document.getElementById("editModal");
        var btn = document.getElementById("editBtn");
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
