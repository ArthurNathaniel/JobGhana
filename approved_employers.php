<?php
// approved_employers.php
include 'db.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Handle approval action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['approve'])) {
    $employerId = $_POST['employer_id'];

    // Update the employer's approval status to approved
    $stmt = $conn->prepare("UPDATE employers SET approved = 1 WHERE id = ?");
    $stmt->bind_param("i", $employerId);

    if ($stmt->execute()) {
        $message = "Employer approved successfully.";
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch approved employers with their company details
$query = "
    SELECT e.id, e.full_name, e.work_email, cd.registered_company_name, cd.trading_company_name, cd.company_email, cd.company_phone_number, cd.company_type, cd.business_certificate, cd.contact_number, cd.location, cd.ghana_card_id, e.approved
    FROM employers e
    JOIN company_details cd ON e.id = cd.employer_id
";
$result = $conn->query($query);

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'cdn.php'; ?>
    <title>Approved Employers - JobGhana</title>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/approval.css">
</head>

<body>
    <?php include 'home_navbar.php'; ?>
    <div class="approval_all">
        <h2>Approved Employers</h2>

        <?php if (isset($message)): ?>
            <script>
                alert("<?php echo addslashes($message); ?>");
            </script>
        <?php endif; ?>

        <?php if ($result->num_rows > 0): ?>
            <table border="1">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['work_email']); ?></td>
                            <td>
                                <?php if ($row['approved'] == 1): ?>
                                    <button onclick="openModal('<?php echo $row['id']; ?>')">View Details</button>
                                <?php else: ?>
                                    <form method="POST" action="">
                                        <input type="hidden" name="employer_id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" name="approve">Approve</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No approved employers.</p>
        <?php endif; ?>
    </div>

    <!-- Modal -->
    <div id="employerModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Employer Details</h2>
            <div id="modal-body">
                <!-- Employer details will be loaded here -->
            </div>
        </div>
    </div>

    <script>
        function openModal(employerId) {
            // Fetch employer details and display in modal
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_employer_details.php?id=' + employerId, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    document.getElementById('modal-body').innerHTML = xhr.responseText;
                    document.getElementById('employerModal').style.display = 'block';
                }
            };
            xhr.send();
        }

        function closeModal() {
            document.getElementById('employerModal').style.display = 'none';
        }

        // Close the modal when clicking outside of it
        window.onclick = function(event) {
            if (event.target === document.getElementById('employerModal')) {
                closeModal();
            }
        }
    </script>
</body>

</html>