<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
  header("Location: admin_login.php");
  exit();
}

// Handle actions
if (isset($_GET['approve'])) {
  $id = intval($_GET['approve']);
  $conn->query("UPDATE drivers SET status='approved' WHERE id=$id");
}
if (isset($_GET['reject'])) {
  $id = intval($_GET['reject']);
  $conn->query("UPDATE drivers SET status='rejected' WHERE id=$id");
}
if (isset($_GET['delete'])) {
  $id = intval($_GET['delete']);
  $conn->query("DELETE FROM drivers WHERE id=$id");
}

// Fetch all drivers
$drivers = $conn->query("SELECT * FROM drivers ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Drivers</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-primary">Manage All Drivers</h2>
    <a href="admin_index.php" class="btn btn-secondary">Back to Dashboard</a>
  </div>

  <?php if ($drivers->num_rows > 0): ?>
    <div class="table-responsive">
      <table class="table table-bordered table-striped shadow-sm">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Vehicle No</th>
            <th>Status</th>
            <th>License</th>
            <th>Vehicle</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($d = $drivers->fetch_assoc()): ?>
            <tr>
              <td><?= $d['id'] ?></td>
              <td><?= htmlspecialchars($d['name']) ?></td>
              <td><?= htmlspecialchars($d['phone']) ?></td>
              <td><?= htmlspecialchars($d['email']) ?></td>
              <td><?= htmlspecialchars($d['vehicle_no']) ?></td>
              <td>
                <?php
                  $status = $d['status'];
                  $badge = match($status) {
                    'approved' => 'success',
                    'pending' => 'warning',
                    'rejected' => 'danger',
                    default => 'secondary'
                  };
                ?>
                <span class="badge bg-<?= $badge ?>"><?= ucfirst($status) ?></span>
              </td>
              <td>
                <a href="../<?= $d['license_image'] ?>" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
              </td>
              <td>
                <a href="../<?= $d['vehicle_image'] ?>" target="_blank" class="btn btn-sm btn-outline-secondary">View</a>
              </td>
              <td>
                <?php if ($status === 'pending'): ?>
                  <a href="?approve=<?= $d['id'] ?>" class="btn btn-sm btn-success">Approve</a>
                  <a href="?reject=<?= $d['id'] ?>" class="btn btn-sm btn-warning">Reject</a>
                <?php endif; ?>
                <a href="?delete=<?= $d['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this driver?');">Delete</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-info">No drivers found in the system.</div>
  <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
