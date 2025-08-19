<?php
session_start();
include("../dbconnection.php");

$msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name     = $_POST['name'];
    $password = $_POST['password'];

    $query = "SELECT * FROM tblrestaurants_delivery 
              WHERE name = '$name' 
              AND password = '$password' 
              AND type = 'restaurant' LIMIT 1";

    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        $_SESSION['restaurant_id']      = $row['id'];
        $_SESSION['restaurant_name']    = $row['name'];
        $_SESSION['restaurant_contact'] = $row['contact'];
        header("Location: restaurant_dashboard.php");
        exit;
    } else {
        $msg = "Invalid restaurant name or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Restaurant Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/css/auth_style.css" rel="stylesheet">
</head>
<body>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-5 form-box">
      <h3 class="text-center mb-4">Restaurant Login</h3>

      <?php if (!empty($message)): ?>
        <div class="alert alert-danger"><?php echo $message; ?></div>
      <?php endif; ?>

      <!-- keep your backend PHP form processing intact, just update HTML -->
      <form method="POST" action="">
        <div class="mb-3">
          <label>Restaurant Name</label>
          <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
          <label>Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>

        <p class="mt-3 text-center">
          Go back to <a href="../register.php">Register</a>
        </p>
        <p class="mt-3 text-center">
          Go back to <a href="../index.php">Goto Home</a>
        </p>
      </form>
    </div>
  </div>
</div>

</body>
</html>
