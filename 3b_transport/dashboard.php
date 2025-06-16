<?php
session_start();
if (!isset($_SESSION['driver_id'])) {
  header("Location: login.php");
  exit();
}

include 'includes/db.php'; // Adjust if your structure differs

$driver_id = $_SESSION['driver_id'];
$rides = $conn->query("SELECT * FROM rides WHERE status='pending'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Driver Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    .map {
      width: 100%;
      height: 300px;
    }
  </style>
</head>
<body>
  <div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3>Welcome, <?= htmlspecialchars($_SESSION['driver_name']) ?></h3>
      <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>

    <h5>Pending Ride Requests</h5>
    <?php while($ride = $rides->fetch_assoc()): ?>
      <div class="card mb-4">
        <div class="card-body">
          <h6><strong>Pickup:</strong> <?= htmlspecialchars($ride['pickup']) ?></h6>
          <h6><strong>Drop:</strong> <?= htmlspecialchars($ride['drop_location']) ?></h6>
          <div id="map<?= $ride['id'] ?>" class="map mb-3"></div>
          <a href="ride_action.php?id=<?= $ride['id'] ?>&action=accept" class="btn btn-success btn-sm">Accept</a>
          <a href="ride_action.php?id=<?= $ride['id'] ?>&action=reject" class="btn btn-danger btn-sm">Reject</a>
        </div>
      </div>
    <?php endwhile; ?>
  </div>

  <!-- Google Maps API (replace with your real key) -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY"></script>
 <script>
    function initMap() {
      <?php
      mysqli_data_seek($rides, 0); // rewind pointer to fetch again
      while($ride = $rides->fetch_assoc()):
        $pickup = urlencode($ride['pickup']);
        $drop = urlencode($ride['drop_location']);
      ?>
        const map<?= $ride['id'] ?> = new google.maps.Map(document.getElementById("map<?= $ride['id'] ?>"), {
          zoom: 10,
          center: { lat: 27.700769, lng: 85.300140 } // Default center (Kathmandu)
        });

        const geocoder = new google.maps.Geocoder();
        geocoder.geocode({ address: "<?= $ride['pickup'] ?>" }, function(results, status) {
          if (status === 'OK') {
            new google.maps.Marker({
              map: map<?= $ride['id'] ?>,
              position: results[0].geometry.location,
              label: "P"
            });
            map<?= $ride['id'] ?>.setCenter(results[0].geometry.location);
          }
        });
        geocoder.geocode({ address: "<?= $ride['drop_location'] ?>" }, function(results, status) {
          if (status === 'OK') {
            new google.maps.Marker({
              map: map<?= $ride['id'] ?>,
              position: results[0].geometry.location,
              label: "D"
            });
          }
        });
      <?php endwhile; ?>
    }

    window.onload = initMap;
  </script>
</body>
</html>