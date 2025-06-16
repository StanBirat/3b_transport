<?php
  session_start();
  if (!isset($_SESSION['driver_id'])) {
    header("Location: login.php");
    exit();
  }
  include '../includes/db.php';
  $ride_id = $_GET['id'];
  $action = $_GET['action'];
  $driver_id = $_SESSION['driver_id'];

  if ($action === 'accept') {
    $conn->query("UPDATE rides SET status='accepted', driver_id='$driver_id' WHERE id='$ride_id'");
  } elseif ($action === 'reject') {
    $conn->query("UPDATE rides SET status='rejected' WHERE id='$ride_id'");
  }
  header("Location: dashboard.php");
?>
