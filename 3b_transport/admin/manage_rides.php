<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header("Location: admin_login.php");
  exit();
}

include '../includes/db.php';

$rides = $conn->query("SELECT * FROM rides ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Rides</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-primary">All Rides</h2>
    <a href="admin_index.php" class="btn btn-secondary">Back to Dashboard</a>
  </div>

  <?php if ($rides->num_rows > 0): ?>
    <div class="table-responsive">
      <table class="table table-bordered table-hover shadow-sm">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Pickup Location</th>
            <th>Drop Location</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($r = $rides->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($r['id']) ?></td>
              <td><?= htmlspecialchars($r['pickup']) ?></td>
              <td><?= htmlspecialchars($r['drop_location']) ?></td>
              <td><?= htmlspecialchars($r['status']) ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-info">No rides found.</div>
  <?php endif; ?>
</div>

</body>
</html>
