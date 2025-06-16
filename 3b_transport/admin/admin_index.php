<head> <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Icons (optional for icons like bi-truck) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<!-- Manage Drivers Card -->

<div class="container my-5">
  <div class="card shadow-lg border-0 rounded-4">
    <div class="card-header bg-primary text-white rounded-top-4">
      <h4 class="mb-0"><i class="bi bi-truck-front"></i> Manage Drivers</h4>
    </div>
    <div class="card-body">
      <p class="text-muted">View, approve, reject, or remove driver records.</p>
      <div class="text-end mb-3">
        <a href="new_driver.php" class="btn btn-success btn-sm">+ Add New Driver</a>
      </div>

      <?php
        include '../includes/db.php';
        $drivers = $conn->query("SELECT * FROM drivers ORDER BY id DESC");
      ?>

      <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>Driver</th>
              <th>Phone</th>
              <th>Email</th>
              <th>Vehicle</th>
              <th>Status</th>
              <th>License</th>
              <th>Vehicle Image</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php $count = 1; while ($d = $drivers->fetch_assoc()): ?>
              <tr>
                <td><?= $count++ ?></td>
                <td><?= htmlspecialchars($d['name']) ?></td>
                <td><?= htmlspecialchars($d['phone']) ?></td>
                <td><?= htmlspecialchars($d['email']) ?></td>
                <td><?= htmlspecialchars($d['vehicle_no']) ?></td>
                <td>
                  <?php
                    $badge = match($d['status']) {
                      'approved' => 'success',
                      'pending' => 'warning',
                      'rejected' => 'danger',
                      default => 'secondary'
                    };
                  ?>
                  <span class="badge bg-<?= $badge ?>"><?= ucfirst($d['status']) ?></span>
                </td>
                <td>
                  <?php if (!empty($d['license_image'])): ?>
                    <a href="../<?= $d['license_image'] ?>" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if (!empty($d['vehicle_image'])): ?>
                    <a href="../<?= $d['vehicle_image'] ?>" target="_blank" class="btn btn-sm btn-outline-secondary">View</a>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if ($d['status'] === 'pending'): ?>
                    <a href="manage_driver.php?approve=<?= $d['id'] ?>" class="btn btn-sm btn-success mb-1">Approve</a>
                    <a href="manage_driver.php?reject=<?= $d['id'] ?>" class="btn btn-sm btn-warning mb-1">Reject</a>
                  <?php endif; ?>
                  <a href="manage_driver.php?delete=<?= $d['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this driver?')">Delete</a>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
