<?php
include("dbconnection.php");

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name       = mysqli_real_escape_string($conn, $_POST['name']);
    $email      = mysqli_real_escape_string($conn, $_POST['email']);
    $password   = $_POST['password'];
    $mobile     = mysqli_real_escape_string($conn, $_POST['mobile']);
    $address    = mysqli_real_escape_string($conn, $_POST['address']);
    $user_type  = mysqli_real_escape_string($conn, $_POST['user_type']);

    // Hash the password securely
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Dummy verification code (6-digit)
    $verification_code = rand(100000, 999999);

    // Insert user into database
    $sql = "INSERT INTO tblusers (name, email, password, mobile, address, user_type, verification_code, is_verified)
            VALUES ('$name', '$email', '$hashed_password', '$mobile', '$address', '$user_type', '$verification_code', 0)";
    
    if (mysqli_query($conn, $sql)) {
        $message = "Registration successful. A verification code has been sent to your mobile: <strong>$verification_code</strong> ";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Registration</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/auth_style.css" rel="stylesheet">
</head>
<body>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6 form-box">
      <h3 class="text-center mb-4">Register (Customer / Rider)</h3>

      <?php if ($message): ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
      <?php endif; ?>

      <form method="POST" action="">
        <div class="mb-3">
          <label>Name</label>
          <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
          <label>Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
          <label>Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
          <label>Mobile Number</label>
          <input type="text" name="mobile" class="form-control" required>
        </div>

        <div class="mb-3">
          <label>Address</label>
          <textarea name="address" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
          <label>User Type</label>
          <select name="user_type" class="form-select" required>
            <option value="">-- Select --</option>
            <option value="customer">Customer</option>
            <option value="rider">Rider</option>
          </select>
        </div>

        <button type="submit" class="btn btn-custom w-100">Register</button>
        <p class="mt-3 text-center">
          Go back to <a href="login.php">Login Here</a>
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
