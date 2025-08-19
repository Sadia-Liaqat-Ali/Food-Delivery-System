<?php
session_start();
include("dbconnection.php");

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email     = mysqli_real_escape_string($conn, $_POST['email']);
    $password  = $_POST['password'];
    $user_type = mysqli_real_escape_string($conn, $_POST['user_type']);

    // Get user by email + user_type
    $query = "SELECT * FROM tblusers WHERE email='$email' AND user_type='$user_type' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        // Verify hashed password
        if (password_verify($password, $row['password'])) {
            // Save session info
            $_SESSION['userid']     = $row['id'];
            $_SESSION['name']       = $row['name'];
            $_SESSION['email']      = $row['email'];
            $_SESSION['user_type']  = $row['user_type'];

            // Redirect by role
            if ($row['user_type'] == 'admin') {
                header("Location: admin/admin_dashboard.php");
            } elseif ($row['user_type'] == 'customer') {
                header("Location: customer/customer_dashboard.php");
            } elseif ($row['user_type'] == 'rider') {
                header("Location: rider/rider_dashboard.php");
            }
            exit;
        } else {
            $message = "Invalid email or password.";
        }
    } else {
        $message = "Invalid email, password or user type.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/auth_style.css" rel="stylesheet">
</head>
<body>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-5 form-box">
      <h3 class="text-center mb-4">Login (All Users)</h3>

      <?php if ($message): ?>
        <div class="alert alert-danger"><?php echo $message; ?></div>
      <?php endif; ?>

      <form method="POST" action="">
        <div class="mb-3">
          <label>Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
          <label>Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
          <label>User Type</label>
          <select name="user_type" class="form-select" required>
            <option value="">-- Select --</option>
            <option value="admin">Admin</option>
            <option value="customer">Customer</option>
            <option value="rider">Rider</option>
          </select>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>

        <p class="mt-3 text-center">
          Go back to <a href="register.php">Register</a>
        </p>
        <p class="mt-3 text-center">
          Go back to <a href="index.php">Goto Home</a>
        </p>
      </form>
    </div>
  </div>
</div>

</body>
</html>
