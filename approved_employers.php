<?php
// approved_employers.php
include 'db.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch approved employers with their company details
$query = "
    SELECT e.id, e.full_name, e.work_email, cd.registered_company_name, cd.trading_company_name, cd.company_email, cd.company_phone_number, cd.company_type, cd.business_certificate, cd.contact_number, cd.location, cd.ghana_card_id
    FROM employers e
    JOIN company_details cd ON e.id = cd.employer_id
    WHERE e.approved = 1
";
$result = $conn->query($query);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved Employers</title>
    <style>
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
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; 
            padding: 20px; 
            border: 1px solid #888;
            width: 80%; 
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
    </style>
</head>
<body>
    <h2>Approved Employers</h2>
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
                            <button onclick="openModal('<?php echo $row['id']; ?>')">View Details</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No approved employers.</p>
    <?php endif; ?>

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
