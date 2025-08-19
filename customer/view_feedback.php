<?php
session_start();
include("../dbconnection.php");

if (!isset($_SESSION['userid']) || $_SESSION['user_type'] != 'customer') {
    header("Location: ../login.php");
    exit;
}

$food_id = $_GET['food_id'] ?? null;
$customer_id = $_SESSION['userid'];
$customer_name = $_SESSION['name'] ?? 'Anonymous';

if (!$food_id) {
    echo "<script>alert('Invalid food item'); window.history.back();</script>";
    exit;
}

// Handle feedback submission
if (isset($_POST['submit_feedback'])) {
    $rating = intval($_POST['rating']);
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);

    mysqli_query($conn, "INSERT INTO tbl_feedback (food_id, customer_id, customer_name, rating, comment) 
        VALUES ('$food_id', '$customer_id', '$customer_name', '$rating', '$comment')");
    echo "<script>alert('Thank you for your feedback'); window.location.href=window.location.href;</script>";
    exit;
}

// Get food item details with restaurant info
$food = mysqli_fetch_assoc(mysqli_query($conn, "SELECT f.*, r.name AS restaurant_name 
    FROM tbl_foods f 
    JOIN tblrestaurants_delivery r ON f.restaurant_id = r.id 
    WHERE f.id = '$food_id'"));

// Get all feedbacks
$feedbacks = mysqli_query($conn, "SELECT * FROM tbl_feedback WHERE food_id = '$food_id' ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Feedback for <?php echo htmlspecialchars($food['name'] ?? 'Food Item'); ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f8f9fa; }
    .card { margin-bottom: 20px; }
    .rating-star { color: #ffc107; }
    .btn-submit { background-color: #0d6efd; border: none; }
    .btn-submit:hover { background-color: #0b5ed7; }
  </style>
</head>
<body>
<div class="container-fluid">
  <div class="row">

    <!-- Sidebar -->
 <div class="col-md-3 col-lg-2 p-0 bg-dark text-white" style="min-height: 100vh; overflow-y: auto;">
      <?php include 'sidebar.php'; ?>
    </div>

    <!-- Main Content -->
    <div class="col-md-9 col-lg-10 p-4">
      <h3 class="mb-4 text-center text-primary">Feedback for <?php echo htmlspecialchars($food['name'] ?? 'Food Item'); ?></h3>

      <?php if ($food): ?>
      <!-- Food Info -->
      <div class="card shadow-sm mb-4">
        <div class="row g-0">
          <div class="col-md-3">
            <img src="../uploads/<?php echo htmlspecialchars($food['image'] ?? 'noimage.png'); ?>" class="img-fluid rounded-start" alt="food">
          </div>
          <div class="col-md-9">
            <div class="card-body">
              <h5 class="card-title"><?php echo htmlspecialchars($food['name']); ?></h5>
              <p class="card-text mb-1"><strong>Restaurant:</strong> <?php echo htmlspecialchars($food['restaurant_name']); ?></p>
              <p class="card-text mb-1"><strong>Price:</strong> Rs. <?php echo number_format($food['price'], 2); ?></p>
              <p class="card-text text-muted"><?php echo htmlspecialchars($food['description'] ?? 'No description available.'); ?></p>
            </div>
          </div>
        </div>
      </div>

      <!-- Feedback Section -->
      <div class="row">
        <!-- Feedback Form -->
        <div class="col-md-6">
          <div class="card shadow-sm p-3 mb-4">
            <h5 class="mb-3">Submit Your Feedback</h5>
            <form method="POST" class="needs-validation" novalidate>
              <div class="mb-3">
                <label class="form-label">Rating</label>
                <select name="rating" class="form-select" required>
                  <option value="">Select Rating</option>
                  <?php for ($i = 1; $i <= 5; $i++): ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?> Star<?php echo $i > 1 ? 's' : ''; ?></option>
                  <?php endfor; ?>
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label">Comment</label>
                <textarea name="comment" class="form-control" rows="3" required></textarea>
              </div>
              <button type="submit" name="submit_feedback" class="btn btn-submit w-100">Submit Feedback</button>
            </form>
          </div>
        </div>

        <!-- Feedback List -->
        <div class="col-md-6">
          <div class="card shadow-sm p-3 mb-4">
            <h5 class="mb-3">All Feedback</h5>
            <?php if (mysqli_num_rows($feedbacks) > 0): ?>
              <ul class="list-group">
              <?php while ($fb = mysqli_fetch_assoc($feedbacks)): ?>
                <li class="list-group-item">
                  <strong><?php echo htmlspecialchars($fb['customer_name']); ?></strong> 
                  <span class="rating-star">
                    <?php echo str_repeat('★', intval($fb['rating'])); ?>
                    <?php echo str_repeat('☆', 5 - intval($fb['rating'])); ?>
                  </span><br>
                  <?php echo htmlspecialchars($fb['comment']); ?>
                </li>
              <?php endwhile; ?>
              </ul>
            <?php else: ?>
              <div class="alert alert-info">No feedback available for this item.</div>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <?php else: ?>
        <div class="alert alert-danger">Food item not found.</div>
      <?php endif; ?>
    </div>
  </div>
</div>

<script>
  // Bootstrap validation
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
