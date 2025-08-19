<?php
session_start();
if (!isset($_SESSION['userid']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
include("../dbconnection.php");

// Success message
$update_msg = "";

// Handle restaurant update
if (isset($_POST['update_restaurant'])) {
    $id = $_POST['id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    $query = "UPDATE tblrestaurants_delivery SET name='$name', contact='$contact', address='$address' WHERE id='$id'";
    if (mysqli_query($conn, $query)) {
        $update_msg = "Restaurant updated successfully!";
    }
}

// Handle approve/reject actions
if (isset($_GET['approve_id'])) {
    $id = $_GET['approve_id'];
    mysqli_query($conn, "UPDATE tbl_rider_applications SET status = 'approved' WHERE id = '$id'");
}
if (isset($_GET['reject_id'])) {
    $id = $_GET['reject_id'];
    mysqli_query($conn, "UPDATE tbl_rider_applications SET status = 'rejected' WHERE id = '$id'");
}

// Fetch all restaurants
$restaurants = mysqli_query($conn, "SELECT * FROM tblrestaurants_delivery");

// Fetch all rider applications
$applications = mysqli_query($conn, "SELECT * FROM tbl_rider_applications ORDER BY applied_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Manage Riders & Restaurants</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      background-color: #f8f9fa;
    }
    .wrapper {
      display: flex;
    }
    .main-container {
      padding: 30px;
      width: 100%;
    }
  </style>
</head>
<body>

<div class="wrapper">
  <!-- Sidebar -->
  <div class="sidebar">
    <?php include("sidebar.php"); ?>
  </div>

  <!-- Main Content -->
  <div class="main-container">
    <h4 class="mb-4">All Restaurants</h4>

    <?php if ($update_msg): ?>
      <div class="alert alert-success"><?php echo $update_msg; ?></div>
    <?php endif; ?>

    <?php if (mysqli_num_rows($restaurants) > 0): ?>
    <table class="table table-bordered bg-white">
      <thead class="table-primary">
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Contact</th>
          <th>Address</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i = 1;
        while ($res = mysqli_fetch_assoc($restaurants)) {
            echo "<tr>
                    <form method='post'>
                      <td>{$i}</td>
                      <td><input type='text' name='name' value='{$res['name']}' class='form-control'></td>
                      <td><input type='text' name='contact' value='{$res['contact']}' class='form-control'></td>
                      <td><input type='text' name='address' value='{$res['address']}' class='form-control'></td>
                      <td>
                        <input type='hidden' name='id' value='{$res['id']}'>
                        <button type='submit' name='update_restaurant' class='btn btn-sm btn-primary'>Update</button>
                      </td>
                    </form>
                  </tr>";
            $i++;
        }
        ?>
      </tbody>
    </table>
    <?php else: ?>
      <div class="alert alert-warning">No restaurants found.</div>
    <?php endif; ?>

    <hr class="my-5">

    <h4 class="mb-4">Rider Applications</h4>
    <?php if (mysqli_num_rows($applications) > 0): ?>
    <table class="table table-bordered bg-white">
      <thead class="table-primary">
        <tr>
          <th>#</th>
          <th>Rider Name</th>
          <th>Email</th>
          <th>Restaurant</th>
          <th>Status</th>
          <th>Applied At</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $j = 1;
        while ($app = mysqli_fetch_assoc($applications)) {
            $rest_id = $app['restaurant_id'];
            $res_query = mysqli_query($conn, "SELECT name FROM tblrestaurants_delivery WHERE id = '$rest_id'");
            $res = $res_query ? mysqli_fetch_assoc($res_query) : ['name' => 'Unknown'];

            echo "<tr>
                    <td>{$j}</td>
                    <td>{$app['name']}</td>
                    <td>{$app['email']}</td>
                    <td>{$res['name']}</td>
                    <td>{$app['status']}</td>
                    <td>{$app['applied_at']}</td>
                    <td>";
            if ($app['status'] == 'pending') {
                echo "<a href='?approve_id={$app['id']}' class='btn btn-sm btn-success me-2'>Approve</a>
                      <a href='?reject_id={$app['id']}' class='btn btn-sm btn-danger'>Reject</a>";
            } else {
                echo "<em>No action</em>";
            }
            echo "</td></tr>";
            $j++;
        }
        ?>
      </tbody>
    </table>
    <?php else: ?>
      <div class="alert alert-warning">No rider applications found.</div>
    <?php endif; ?>
  </div>
</div>

</body>
</html>
