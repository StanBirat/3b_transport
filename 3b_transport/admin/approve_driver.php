<?php
include '../includes/db.php';
session_start();
if (!isset($_SESSION['admin_id'])) {
  header("Location: admin_login.php");
  exit();
}

// Approve driver logic
if (isset($_GET['approve'])) {
  $id = $_GET['approve'];
  $conn->query("UPDATE drivers SET status='approved' WHERE id=$id");
}

// Fetch pending drivers
$drivers = $conn->query("SELECT * FROM drivers WHERE status='pending'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Approve Drivers</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-primary">Pending Driver Approvals</h2>
    <div>
      <a href="../register.php" class="btn btn-success me-2">+ Register Driver</a>
      <a href="admin_index.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>
  </div>

  <?php if ($drivers->num_rows > 0): ?>
    <div class="table-responsive">
      <table class="table table-bordered table-striped shadow-sm">
        <thead class="table-dark">
          <tr>
            <th>Full Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Vehicle No</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($d = $drivers->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($d['name']) ?></td>
              <td><?= htmlspecialchars($d['email']) ?></td>
              <td><?= htmlspecialchars($d['phone']) ?></td>
              <td><?= htmlspecialchars($d['vehicle_no']) ?></td>
              <td>
                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#driverModal<?= $d['id'] ?>">View</button>
                <a href="?approve=<?= $d['id'] ?>" class="btn btn-success btn-sm">Approve</a>
              </td>
            </tr>

            <!-- Modal -->
            <div class="modal fade" id="driverModal<?= $d['id'] ?>" tabindex="-1" aria-labelledby="driverModalLabel<?= $d['id'] ?>" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="driverModalLabel<?= $d['id'] ?>">Driver Details: <?= htmlspecialchars($d['name']) ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <p><strong>Email:</strong> <?= htmlspecialchars($d['email']) ?></p>
                    <p><strong>Phone:</strong> <?= htmlspecialchars($d['phone']) ?></p>
                    <p><strong>Vehicle Number:</strong> <?= htmlspecialchars($d['vehicle_no']) ?></p>
                    <p><strong>License Image:</strong><br>
                      <img src="../<?= $d['license_image'] ?>" alt="License" class="img-thumbnail" style="max-height: 200px;">
                    </p>
                    <p><strong>Vehicle Image:</strong><br>
                      <img src="../<?= $d['vehicle_image'] ?>" alt="Vehicle" class="img-thumbnail" style="max-height: 200px;">
                    </p>
                  </div>
                  <div class="modal-footer">
                    <a href="?approve=<?= $d['id'] ?>" class="btn btn-success">Approve</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-info">No pending driver registrations at the moment.</div>
  <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
