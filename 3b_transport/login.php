<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Driver Login</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-4">
        <div class="card shadow">
          <div class="card-body">
            <h4 class="card-title text-center">Driver Login</h4>
            <form action="login.php" method="post">
              <input type="email" name="email" placeholder="Email" class="form-control mb-3" required>
              <input type="password" name="password" placeholder="Password" class="form-control mb-3" required>
              <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
            </form>
            <p class="text-center mt-3"><a href="register.php">Don't have an account? Register</a></p>
            <?php
if (isset($_POST['login'])) {
  include 'includes/db.php';  // ✅ corrected path
  session_start();
  $email = $_POST['email'];
  $password = $_POST['password'];

  $result = $conn->query("SELECT * FROM drivers WHERE email='$email'");
  if ($result && $result->num_rows === 1) {
    $driver = $result->fetch_assoc();
    if ($driver['status'] !== 'approved') {
      echo "<div class='alert alert-warning mt-2'>Waiting for admin approval.</div>";
    } elseif (password_verify($password, $driver['password'])) {
      $_SESSION['driver_id'] = $driver['id'];
      $_SESSION['driver_name'] = $driver['name'];
      header("Location: dashboard.php");
    } else {
      echo "<div class='alert alert-danger mt-2'>Incorrect password.</div>";
    }
  } else {
    echo "<div class='alert alert-danger mt-2'>Driver not found.</div>";
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