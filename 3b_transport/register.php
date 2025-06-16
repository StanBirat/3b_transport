<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Driver Register</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <script>
    function validatePhone(input) {
      const phonePattern = /^98\d{8}$/;
      if (!phonePattern.test(input.value)) {
        input.setCustomValidity("Please enter validate Phone number");
      } else {
        input.setCustomValidity("");
      }
    }
  </script>
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow">
          <div class="card-body">
            <h4 class="card-title text-center">Driver Register</h4>
            <form action="register.php" method="post" enctype="multipart/form-data">
              <input type="text" name="name" placeholder="Full Name" class="form-control mb-3" required>
              <input type="text" name="phone" placeholder="Phone" class="form-control mb-3" required oninput="validatePhone(this)">
              <input type="email" name="email" placeholder="Email" class="form-control mb-3" required>
              <input type="text" name="vehicle_no" placeholder="Vehicle Number" class="form-control mb-3" required>
              <label>Upload License:</label>
              <input type="file" name="license" class="form-control mb-3" required>
              <label>Upload Vehicle Image:</label>
              <input type="file" name="vehicle" class="form-control mb-3" required>
              <input type="password" name="password" placeholder="Password" class="form-control mb-3" required>
              <button type="submit" name="register" class="btn btn-success w-100">Register</button>
              <p class="text-center mt-3"><a href="login.php">Already registered? Login</a></p>
            </form>
            <?php
  if (isset($_POST['register'])) {
    include 'includes/db.php';  // ✅ corrected path

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $vehicle_no = $_POST['vehicle_no'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $license_path = 'uploads/licenses/' . $_FILES['license']['name'];
    $vehicle_path = 'uploads/vehicles/' . $_FILES['vehicle']['name'];

    // ✅ move files to correct folders
    move_uploaded_file($_FILES['license']['tmp_name'], $license_path);
    move_uploaded_file($_FILES['vehicle']['tmp_name'], $vehicle_path);

    $stmt = $conn->prepare("INSERT INTO drivers (name, phone, email, vehicle_no, license_image, vehicle_image, password, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')");
    $stmt->bind_param("sssssss", $name, $phone, $email, $vehicle_no, $license_path, $vehicle_path, $password);

    if ($stmt->execute()) {
      echo "<div class='alert alert-success mt-2'>Registration submitted. Await admin approval.</div>";
    } else {
      echo "<div class='alert alert-danger mt-2'>Error: " . $conn->error . "</div>";
    }
  }
?>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>