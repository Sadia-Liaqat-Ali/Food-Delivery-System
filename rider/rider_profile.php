<?php
session_start();
include("../dbconnection.php");

if (!isset($_SESSION['userid']) || $_SESSION['user_type'] !== 'rider') {
    header("Location: login.php");
    exit;
}

$userid = $_SESSION['userid'];
$message = "";

$q = mysqli_query($conn, "SELECT * FROM tblusers WHERE id='$userid'");
$user = mysqli_fetch_assoc($q);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name    = mysqli_real_escape_string($conn, $_POST['name']);
    $email   = mysqli_real_escape_string($conn, $_POST['email']);
    $mobile  = mysqli_real_escape_string($conn, $_POST['mobile']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $password = $_POST['password'];

    if (!empty($password)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $update = mysqli_query($conn, "UPDATE tblusers 
            SET name='$name', email='$email', mobile='$mobile', address='$address', password='$password_hash' 
            WHERE id='$userid'");
    } else {
        $update = mysqli_query($conn, "UPDATE tblusers 
            SET name='$name', email='$email', mobile='$mobile', address='$address' 
            WHERE id='$userid'");
    }

    $message = $update ? "Profile updated successfully." : "Update failed: " . mysqli_error($conn);
    $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tblusers WHERE id='$userid'"));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Rider Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f8f9fa; }
    .profile-card { max-width: 700px; margin: 40px auto; border: 2px solid #007bff; }
    .form-control:focus { box-shadow: none; border-color: #007bff; }
    .btn-update { background-color: #28a745; border: none; }
    .btn-update:hover { background-color: #218838; }
  </style>
</head>
<body>
<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-3 col-lg-2 p-0">
      <?php include 'sidebar.php'; ?>
    </div>

    <!-- Profile Form -->
    <div class="col-md-9 col-lg-10">
      <div class="profile-card card shadow-sm p-4">
        <h3 class="card-title mb-4 text-center text-primary">Rider Profile</h3>

        <?php if ($message): ?>
          <div class="alert alert-info text-center"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="POST" class="needs-validation" novalidate>
          <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Mobile</label>
            <input type="text" name="mobile" value="<?php echo htmlspecialchars($user['mobile']); ?>" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea name="address" class="form-control" rows="3" required><?php echo htmlspecialchars($user['address']); ?></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Password <small class="text-muted">(Leave empty to keep unchanged)</small></label>
            <input type="password" name="password" class="form-control">
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-primary btn-lg btn-update">Update Profile</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  // Bootstrap form validation
  (function () {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms).forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }
        form.classList.add('was-validated')
      }, false)
    })
  })()
</script>
</body>
</html>
