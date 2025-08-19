<?php
session_start();
include '../dbconnection.php';

$rid = $_SESSION['restaurant_id'];
$msg = "";

// Handle general promotion
if (isset($_POST['add_promo'])) {
    $text = $_POST['promo_text'];
    mysqli_query($conn, "INSERT INTO tbl_promotions (restaurant_id, message) VALUES ('$rid', '$text')");
    $msg = "Promotion message saved.";
}

// Handle item discount
if (isset($_POST['apply_discount'])) {
    $item_id = $_POST['food_id'];
    $discount = $_POST['discount'];
    $item = mysqli_fetch_assoc(mysqli_query($conn, "SELECT name FROM tbl_foods WHERE id='$item_id'"));

    mysqli_query($conn, "UPDATE tbl_foods SET discount='$discount' WHERE id='$item_id'");
    $promo_msg = "Special Offer 🎉: $discount% OFF on " . $item['name'];
    mysqli_query($conn, "INSERT INTO tbl_promotions (restaurant_id, message) VALUES ('$rid', '$promo_msg')");

    $msg = "Discount applied and promotion added.";
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Discounts & Promotions</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f8f9fa; }
    .card-custom { border-radius: 12px; transition: all 0.3s ease; }
    .card-custom:hover { transform: translateY(-3px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
    .section-title { font-weight: 600; color: #333; }
    textarea, input { border-radius: 8px !important; }
  </style>
</head>
<body>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-3 col-lg-2 p-0">
      <?php include("sidebar.php"); ?>
    </div>

    <!-- Main Content -->
    <div class="col-md-9 col-lg-10 p-4">
      <h3 class="mb-4 text-primary">✨ Discounts & Promotions</h3>

      <?php if ($msg): ?>
        <div class="alert alert-success shadow-sm"><?php echo $msg; ?></div>
      <?php endif; ?>

      <div class="row">
        <!-- General Promotion Form -->
        <div class="col-md-6">
          <div class="card card-custom p-3 mb-4 shadow-sm">
            <h5 class="section-title mb-3">📢 Create General Promotion</h5>
            <form method="POST">
              <div class="mb-3">
                <label class="form-label">Promotion Message</label>
                <textarea name="promo_text" class="form-control" rows="3" required></textarea>
              </div>
              <button class="btn btn-success btn-sm px-3" name="add_promo">💾 Save Promotion</button>
            </form>
          </div>
        </div>

        <!-- Discount Form -->
        <div class="col-md-6">
          <div class="card card-custom p-3 mb-4 shadow-sm">
            <h5 class="section-title mb-3">💲 Apply Discount to Items</h5>
            <?php
            $foods = mysqli_query($conn, "SELECT * FROM tbl_foods WHERE restaurant_id='$rid'");
            while ($food = mysqli_fetch_assoc($foods)) {
            ?>
              <form method="POST" class="mb-3 pb-2 border-bottom">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                  <div>
                    <strong><?php echo $food['name']; ?></strong> 
                    <small class="text-muted">(Rs. <?php echo $food['price']; ?>)</small>
                    <?php if ($food['discount'] > 0): ?>
                      <span class="badge bg-warning text-dark ms-2">Current: <?php echo $food['discount']; ?>%</span>
                    <?php endif; ?>
                  </div>
                  <input type="hidden" name="food_id" value="<?php echo $food['id']; ?>">
                  <input type="number" name="discount" placeholder="Discount %" class="form-control form-control-sm" style="width: 100px;" required>
                  <button class="btn btn-primary btn-sm" name="apply_discount">Apply</button>
                </div>
              </form>
            <?php } ?>
          </div>
        </div>
      </div>

      <!-- Promotions List -->
      <div class="card card-custom p-3 shadow-sm">
        <h5 class="section-title mb-3">📋 All Promotions</h5>
        <?php
        $promotions = mysqli_query($conn, "SELECT * FROM tbl_promotions WHERE restaurant_id='$rid' ORDER BY created_at DESC");
        if (mysqli_num_rows($promotions) > 0):
        ?>
        <ul class="list-group list-group-flush">
          <?php while ($promo = mysqli_fetch_assoc($promotions)): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <?php echo $promo['message']; ?>
              <span class="badge bg-secondary"><?php echo date("d-M-Y h:i A", strtotime($promo['created_at'])); ?></span>
            </li>
          <?php endwhile; ?>
        </ul>
        <?php else: ?>
          <div class="alert alert-info">No promotions found.</div>
        <?php endif; ?>
      </div>

    </div>
  </div>
</div>

</body>
</html>
