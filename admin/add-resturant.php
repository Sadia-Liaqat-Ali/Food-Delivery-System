<?php
session_start();
if (!isset($_SESSION['userid']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
include("../dbconnection.php");

$msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name     = $_POST['name'];
    $contact  = $_POST['contact'];
    $address  = $_POST['address'];
    $password = $_POST['password']; // new field

    $insert = "INSERT INTO tblrestaurants_delivery (name, type, contact, address, password) 
               VALUES ('$name', 'restaurant', '$contact', '$address', '$password')";

    if (mysqli_query($conn, $insert)) {
        $msg = "✅ Restaurant added successfully. Please note: This password will be used by the restaurant to log in.";
    } else {
        $msg = "❌ Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Add Restaurant</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container-fluid">
  <div class="row">

    <!-- Sidebar -->
    <div class="col-md-3 col-lg-2 p-0">
      <?php include("sidebar.php"); ?>
    </div>

    <!-- Main Content -->
    <div class="col-md-9 col-lg-10 p-4">

      <!-- Header -->
      <div class="bg-primary text-white p-3 rounded shadow-sm mb-4 d-flex justify-content-between align-items-center">
        <h4 class="mb-0"><i class="bi bi-shop me-2"></i> Add Restaurant</h4>
      </div>

      <!-- Message -->
      <?php if ($msg): ?>
        <div class="alert alert-info shadow-sm"><?php echo $msg; ?></div>
      <?php endif; ?>

      <!-- Form -->
      <div class="card shadow-sm border-0">
        <div class="card-body">
          <form method="POST" class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-bold">Name</label>
              <input type="text" name="name" class="form-control" placeholder="Enter restaurant name" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Contact</label>
              <input type="text" name="contact" class="form-control" placeholder="Enter contact number" required>
            </div>
            <div class="col-md-12">
              <label class="form-label fw-bold">Address</label>
              <textarea name="address" class="form-control" rows="3" placeholder="Enter restaurant address" required></textarea>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Password (for restaurant login)</label>
              <input type="text" name="password" class="form-control" placeholder="Set restaurant login password" required>
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-success px-4"><i class="bi bi-plus-circle me-1"></i> Add Restaurant</button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>

</body>
</html>
