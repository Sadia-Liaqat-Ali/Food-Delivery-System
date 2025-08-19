<?php
session_start();
include("../dbconnection.php");

if (!isset($_SESSION['userid']) || $_SESSION['user_type'] !== 'rider') {
    header("Location: ../login.php");
    exit;
}

$rider_id = $_SESSION['userid'];
$name = $_SESSION['name'];
$email = $_SESSION['email'];
$restaurant_id = $_GET['rest_id'] ?? 0;

// Check if already applied
$check = mysqli_query($conn, "SELECT * FROM tbl_rider_applications WHERE rider_id = '$rider_id' AND restaurant_id = '$restaurant_id'");
if (mysqli_num_rows($check) > 0) {
    echo "<script>alert('You have already applied to this restaurant.'); window.location.href='rider_dashboard.php';</script>";
    exit;
}

// Insert application
$insert = mysqli_query($conn, "INSERT INTO tbl_rider_applications (rider_id, restaurant_id, name, email) 
VALUES ('$rider_id', '$restaurant_id', '$name', '$email')");

if ($insert) {
    echo "<script>alert('Application sent successfully!'); window.location.href='rider_dashboard.php';</script>";
} else {
    echo "<script>alert('Something went wrong.'); window.location.href='rider_dashboard.php';</script>";
}
?>
