<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header("Location: admin_login.php");
  exit();
}
?>
<h2>Welcome, <?= $_SESSION['admin_user'] ?></h2>
<ul>
  <li><a href="approve_driver.php">Approve Drivers</a></li>
  <li><a href="manage_rides.php">Manage Rides</a></li>
  <li><a href="admin_logout.php">Logout</a></li>
</ul>
