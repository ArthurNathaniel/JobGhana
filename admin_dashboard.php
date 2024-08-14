<?php
// admin_dashboard.php
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

// Fetch employers who have completed all steps but are not yet approved
$result = $conn->query("
    SELECT e.id, e.full_name, e.work_email
    FROM employers e
    JOIN company_details cd ON e.id = cd.employer_id
    WHERE e.approved = 0
");

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script>
        function showAlert(message) {
            alert(message);
        }
    </script>
</head>
<body>
    <h2>Admin Dashboard</h2>
    <h3>Pending Employer Approvals</h3>

    <?php if (isset($message)): ?>
        <script>
            showAlert("<?php echo addslashes($message); ?>");
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
                            <form method="POST" action="">
                                <input type="hidden" name="employer_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="approve">Approve</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No pending approvals.</p>
    <?php endif; ?>
</body>
</html>
