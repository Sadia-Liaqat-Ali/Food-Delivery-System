<?php
session_start();
include '../dbconnection.php';

if (!isset($_SESSION['restaurant_id'])) {
    header("Location: ../login.php");
    exit;
}

$rid = $_SESSION['restaurant_id'];
$msg = "";

// Delete item
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    mysqli_query($conn, "DELETE FROM tbl_foods WHERE id = '$id' AND restaurant_id = '$rid'");
    $msg = "Item deleted.";
}

// Update item
if (isset($_POST['update_item'])) {
    $item_id = $_POST['item_id'];
    $name = $_POST['item_name'];
    $price = $_POST['item_price'];
    mysqli_query($conn, "UPDATE tbl_foods SET name='$name', price='$price' WHERE id='$item_id' AND restaurant_id='$rid'");
    $msg = "Item updated.";
}

// Fetch all items
$items = mysqli_query($conn, "SELECT * FROM tbl_foods WHERE restaurant_id = '$rid'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Items</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

      <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
          <h5 class="mb-0">🍽 Manage Your Menu Items</h5>
        </div>
        <div class="card-body">

          <?php if ($msg): ?>
            <div class="alert alert-info"><?php echo $msg; ?></div>
          <?php endif; ?>

          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead class="table-primary">
                <tr>
                  <th>#</th>
                  <th>Image</th>
                  <th>Name</th>
                  <th>Price</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i = 1;
                while ($item = mysqli_fetch_assoc($items)) {
                  echo "
                  <tr>
                    <td>{$i}</td>
                    <td><img src='{$item['image']}' class='rounded' style='width:60px;height:60px;object-fit:cover;'></td>
                    <td>
                      <form method='POST' class='d-flex gap-2'>
                        <input type='hidden' name='item_id' value='{$item['id']}'>
                        <input type='text' name='item_name' value='{$item['name']}' class='form-control form-control-sm' required>
                    </td>
                    <td>
                        <input type='number' name='item_price' value='{$item['price']}' class='form-control form-control-sm' required>
                    </td>
                    <td class='d-flex gap-2'>
                        <button class='btn btn-sm btn-warning' name='update_item'>
                          <i class='bi bi-pencil-square'></i> Update
                        </button>
                        <a href='?delete_id={$item['id']}' onclick=\"return confirm('Delete this item?')\" class='btn btn-sm btn-danger'>
                          <i class='bi bi-trash'></i> Delete
                        </a>
                      </form>
                    </td>
                  </tr>";
                  $i++;
                }
                ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>

    </div>
  </div>
</div>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

</body>
</html>
