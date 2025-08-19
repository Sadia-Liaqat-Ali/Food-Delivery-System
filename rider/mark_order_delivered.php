<?php
session_start();
include("../dbconnection.php");

if (!isset($_SESSION['userid']) || $_SESSION['user_type'] !== 'rider') {
    header("Location: ../login.php");
    exit;
}

$order_id = $_GET['order_id'] ?? 0;

// Fetch order details
$order_sql = "
    SELECT o.*, f.name AS food_name, f.restaurant_id 
    FROM tbl_orders o
    JOIN tbl_foods f ON o.food_id = f.id
    WHERE o.id = '$order_id'
";
$order = mysqli_fetch_assoc(mysqli_query($conn, $order_sql));

if (!$order) {
    echo "<script>alert('Order not found.'); window.location.href='rider_dashboard.php';</script>";
    exit;
}

if ($order['status'] === 'Delivered') {
    echo "<script>alert('Order already marked as delivered.'); window.location.href='rider_dashboard.php';</script>";
    exit;
}

// Update order status
mysqli_query($conn, "UPDATE tbl_orders SET status='Delivered' WHERE id='$order_id'");

// Calculate total amount
$total_amount = $order['total_price'] + $order['delivery_charges'];

// Create promotion message
$promo_msg = "💸 Payment received for Order #{$order['id']} - {$order['food_name']} (Qty: {$order['quantity']}) | Total Rs. {$total_amount}.";

// Insert promo into tbl_promotions
mysqli_query($conn, "INSERT INTO tbl_promotions (restaurant_id, message) VALUES ('{$order['restaurant_id']}', '$promo_msg')");

echo "<script>alert('Order marked as delivered. Restaurant notified of payment.'); window.location.href='rider_dashboard.php';</script>";
?>
