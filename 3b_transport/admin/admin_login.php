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
  <title>Admin Login</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-4">
        <div class="card shadow">
          <div class="card-body">
            <h4 class="card-title text-center mb-4">Admin Login</h4>
            <form method="post">
              <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
              <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
              <button type="submit" name="login" class="btn btn-success w-100">Login</button>
              <p class="text-center mt-3">Not registered? <a href="admin_register.php">Register</a></p>
            </form>
            <?php
              if (isset($_POST['login'])) {
                include '../includes/db.php';
                $email = $_POST['email'];
                $password = $_POST['password'];

                $stmt = $conn->prepare("SELECT * FROM admins WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows === 1) {
                  $admin = $result->fetch_assoc();
                  if (password_verify($password, $admin['password'])) {
                    $_SESSION['admin_id'] = $admin['id'];
                    $_SESSION['admin_name'] = $admin['full_name'];
                    header("Location: admin_index.php");
                  } else {
                    echo "<div class='alert alert-danger mt-2'>Incorrect password.</div>";
                  }
                } else {
                  echo "<div class='alert alert-danger mt-2'>Admin not found.</div>";
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
