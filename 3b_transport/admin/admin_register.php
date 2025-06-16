<?php
session_start();
if (isset($_SESSION['admin_id'])) {
  header("Location: admin_index.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Register</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow">
          <div class="card-body">
            <h4 class="card-title text-center mb-4">Admin Registration</h4>
            <form action="" method="post">
              <input type="text" name="fullname" class="form-control mb-3" placeholder="Full Name" required>
              <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
              <input type="text" name="phone" class="form-control mb-3" placeholder="Phone Number" required>
              <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
              <button type="submit" name="register" class="btn btn-primary w-100">Register</button>
              <p class="text-center mt-3">Already registered? <a href="admin_login.php">Login</a></p>
            </form>
            <?php
              if (isset($_POST['register'])) {
                include '../includes/db.php';
                $fullname = $_POST['fullname'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

                $stmt = $conn->prepare("INSERT INTO admins (full_name, email, phone, password) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $fullname, $email, $phone, $password);
                if ($stmt->execute()) {
                  echo "<div class='alert alert-success mt-3'>Registration successful. <a href='admin_login.php'>Login here</a></div>";
                } else {
                  echo "<div class='alert alert-danger mt-3'>Error: $conn->error</div>";
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
