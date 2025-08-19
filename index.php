<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "foodsystemdb");
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>FoodDelivery - Order Food Online</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  
  <!-- Custom Styles -->
  <link href="assets/css/style.css" rel="stylesheet">
  
  <style>
    /* Additional styles for the new components */
    .hero-section {
      background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') center/cover no-repeat;
      color: white;
      padding: 100px 0;
    }
    
    .restaurant-search {
      position: relative;
      max-width: 700px;
      margin: -30px auto 0;
      z-index: 10;
    }
    
    .restaurant-search input {
      padding-right: 50px;
      border-radius: 50px;
      border: none;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .restaurant-search button {
      position: absolute;
      right: 5px;
      top: 50%;
      transform: translateY(-50%);
      background: #dc3545;
      color: white;
      border: none;
      border-radius: 50%;
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    
    .section-title {
      position: relative;
      margin-bottom: 40px;
      padding-bottom: 15px;
    }
    
    .section-title:after {
      content: "";
      position: absolute;
      bottom: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 80px;
      height: 3px;
      background: #dc3545;
    }
    
    .restaurant-card {
      border: none;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }
    
    .restaurant-card:hover {
      transform: translateY(-10px);
    }
    
    .restaurant-card .badge {
      position: absolute;
      top: 10px;
      right: 10px;
      background: #dc3545;
      padding: 5px 10px;
    }
    
    .menu-item {
      font-size: 0.9rem;
      padding: 5px 0;
      border-bottom: 1px dashed #eee;
    }
    
    .menu-item:last-child {
      border-bottom: none;
    }
    
    .card .badge {
      position: absolute;
      top: 10px;
      right: 10px;
      background: #dc3545;
      padding: 5px 10px;
    }
    
    .price {
      font-weight: bold;
      color: #dc3545;
    }
    
    .original-price {
      text-decoration: line-through;
      color: #6c757d;
      font-size: 0.9rem;
      margin-left: 5px;
    }
    
    .rating {
      color: #ffc107;
    }
    
    .testimonial-card {
      background: white;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
      height: 100%;
    }
    
    /* How It Works - Step Style */
    .step-card {
      position: relative;
      text-align: center;
    }
    
    .step-card:not(:last-child):after {
      content: "";
      position: absolute;
      top: 40px;
      right: -15%;
      width: 30%;
      height: 2px;
      background: blue;
      z-index: 0;
    }
    
    .step-number {
      width: 80px;
      height: 80px;
      background: blue;
      color: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 20px;
      font-size: 24px;
      font-weight: bold;
      position: relative;
      z-index: 1;
    }
    
    /* System Panels - Cute Circles */
    .system {
      background-color: #f8f9fa;
    }
    
    .panel-circle {
      width: 120px;
      height: 120px;
      background: #dc3545;
      color: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 20px;
      font-size: 40px;
      transition: all 0.3s ease;
    }
    
    .panel-circle:hover {
      transform: scale(1.1);
      box-shadow: 0 10px 20px rgba(220, 53, 69, 0.3);
    }
    
    .panel-card {
      border-radius: 15px;
      transition: all 0.3s ease;
      height: 100%;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .panel-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }
    
    /* Fix for Popular Dishes Section */
    .food-card {
      border: none;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
      height: 100%;
    }
    
    .food-card:hover {
      transform: translateY(-5px);
    }
    
    .food-card .card-img-top {
      height: 180px;
      object-fit: cover;
    }
    
    .food-card .card-body {
      padding: 15px;
    }
    
    .food-card .card-title {
      font-size: 1rem;
      margin-bottom: 5px;
    }
    
    .food-card .card-text {
      font-size: 0.85rem;
      color: #6c757d;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>

<?php include("header.html"); ?>
<!-- Hero -->
<section class="hero-section text-center">
  <div class="container">
    <h1>Delicious Food Delivered To Your Door</h1>
    <p class="lead">Order from your favorite restaurants and get food delivered fast & fresh</p>
    
    <div class="mt-4">
      <a href="register.php" class="btn btn-lg btn-danger text-white px-4 me-2">Get Started</a>
      <a href="#restaurants" class="btn btn-lg btn-outline-light px-4">Browse Restaurants</a>
    </div>
  </div>
</section>

<!-- Restaurant Search Section -->
<section class="search-section">
  <div class="container">
    <div class="restaurant-search">
      <input type="text" class="form-control form-control-lg" id="restaurantSearch" placeholder="Search for restaurants by name...">
      <button class="btn" type="button"><i class="fas fa-search"></i></button>
    </div>
  </div>
</section>

<!-- Restaurants Section -->
<section class="py-5" id="restaurants">
  <div class="container">
    <h2 class="section-title text-center">Featured Restaurants</h2>
    
    <div class="row">
      <?php
        // Fetch restaurants
        $sql = "SELECT * FROM tblrestaurants_delivery WHERE type = 'restaurant'";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            while($restaurant = mysqli_fetch_assoc($result)) {
                // Fetch menus for this restaurant
                $restaurant_id = $restaurant['id'];
                $menu_sql = "SELECT * FROM tbl_menus WHERE restaurant_id = $restaurant_id";
                $menu_result = mysqli_query($conn, $menu_sql);
                
                echo '<div class="col-md-4 mb-4 restaurant-card-container">
                        <div class="card restaurant-card">
                            <div class="position-relative">
                                <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" class="card-img-top" alt="Restaurant">
                                <span class="badge">' . $restaurant['status'] . '</span>
                            </div>
                            <div class="card-body">
                                <h3 class="card-title text-danger">' . $restaurant['name'] . '</h3>
                                <p class="card-text">' . $restaurant['address'] . '</p>
                                
                                <!-- Restaurant Menus -->
                                <div class="mb-3">
                                    <h5 class="text-primary">Available Menus:</h5>';
                                    
                                    if (mysqli_num_rows($menu_result) > 0) {
                                        while($menu = mysqli_fetch_assoc($menu_result)) {
                                            echo '<div class="menu-item">' . $menu['name'] . ' (' . $menu['type'] . ')</div>';
                                        }
                                    } else {
                                        echo '<p class="text-danger">No menus available</p>';
                                    }
                                    
                                echo '</div>
                                
                            </div>
                        </div>
                    </div>';
            }
        } else {
            echo '<div class="col-12 text-center">
                    <p>No restaurants available at the moment.</p>
                  </div>';
        }
      ?>
    </div>
    
  </div>
</section>

<!-- Popular Dishes Section -->
<section class="py-5 bg-light" id="menus">
  <div class="container">
    <h2 class="section-title text-center">Popular Dishes</h2>
    
    <ul class="nav nav-tabs justify-content-center mb-4" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab">All</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="fastfood-tab" data-bs-toggle="tab" data-bs-target="#fastfood" type="button" role="tab">Fast Food</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="desi-tab" data-bs-toggle="tab" data-bs-target="#desi" type="button" role="tab">Desi</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="desserts-tab" data-bs-toggle="tab" data-bs-target="#desserts" type="button" role="tab">Desserts</button>
      </li>
    </ul>
    
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="all" role="tabpanel">
        <div class="row">
          <?php
            // Fetch all food items
            $sql = "SELECT f.*, r.name as restaurant_name FROM tbl_foods f 
                    JOIN tblrestaurants_delivery r ON f.restaurant_id = r.id 
                    WHERE r.type = 'restaurant'";
            $result = mysqli_query($conn, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                while($food = mysqli_fetch_assoc($result)) {
                    $discount_price = $food['price'] - ($food['price'] * $food['discount'] / 100);
                    
                    echo '<div class="col-md-3 mb-4">
                            <div class="card food-card">
                                <div class="position-relative">';
                    
                    if ($food['discount'] > 0) {
                        echo '<span class="badge">' . $food['discount'] . '% OFF</span>';
                    }
                    
                    echo '      <img src="img/' . htmlspecialchars($food['image']) . '" class="card-img-top" alt="Food">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">' . htmlspecialchars($food['name']) . '</h5>
                                    <p class="card-text">' . htmlspecialchars($food['restaurant_name']) . '</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>';
                    
                    if ($food['discount'] > 0) {
                        echo '<span class="price">Rs. ' . number_format($discount_price, 0) . '</span>
                              <span class="original-price">Rs. ' . number_format($food['price'], 0) . '</span>';
                    } else {
                        echo '<span class="price">Rs. ' . number_format($food['price'], 0) . '</span>';
                    }
                    
                    echo '      </div>
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                        </div>
                                    </div>
                                    <button class="btn btn-sm btn-danger mt-2 w-100">Add to Cart</button>
                                </div>
                            </div>
                        </div>';
                }
            } else {
                echo '<div class="col-12 text-center">
                        <p>No food items available at the moment.</p>
                      </div>';
            }
          ?>
        </div>
      </div>
      
      <div class="tab-pane fade" id="fastfood" role="tabpanel">
        <div class="row">
          <?php
            // Fetch fast food items
            $sql = "SELECT f.*, r.name as restaurant_name FROM tbl_foods f 
                    JOIN tblrestaurants_delivery r ON f.restaurant_id = r.id 
                    WHERE r.type = 'restaurant' AND (f.name LIKE '%burger%' OR f.name LIKE '%pizza%' OR f.name LIKE '%sandwich%' OR f.name LIKE '%roll%')";
            $result = mysqli_query($conn, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                while($food = mysqli_fetch_assoc($result)) {
                    $discount_price = $food['price'] - ($food['price'] * $food['discount'] / 100);
                    
                    echo '<div class="col-md-3 mb-4">
                            <div class="card food-card">
                                <div class="position-relative">';
                    
                    if ($food['discount'] > 0) {
                        echo '<span class="badge">' . $food['discount'] . '% OFF</span>';
                    }
                    
                    echo '      <img src="img/' . htmlspecialchars($food['image']) . '" class="card-img-top" alt="Food">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">' . htmlspecialchars($food['name']) . '</h5>
                                    <p class="card-text">' . htmlspecialchars($food['restaurant_name']) . '</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>';
                    
                    if ($food['discount'] > 0) {
                        echo '<span class="price">Rs. ' . number_format($discount_price, 0) . '</span>
                              <span class="original-price">Rs. ' . number_format($food['price'], 0) . '</span>';
                    } else {
                        echo '<span class="price">Rs. ' . number_format($food['price'], 0) . '</span>';
                    }
                    
                    echo '      </div>
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                        </div>
                                    </div>
                                    <button class="btn btn-sm btn-danger mt-2 w-100">Add to Cart</button>
                                </div>
                            </div>
                        </div>';
                }
            } else {
                echo '<div class="col-12 text-center">
                        <p>No fast food items available at the moment.</p>
                      </div>';
            }
          ?>
        </div>
      </div>
      
      <div class="tab-pane fade" id="desi" role="tabpanel">
        <div class="row">
          <?php
            // Fetch desi food items
            $sql = "SELECT f.*, r.name as restaurant_name FROM tbl_foods f 
                    JOIN tblrestaurants_delivery r ON f.restaurant_id = r.id 
                    WHERE r.type = 'restaurant' AND (f.name LIKE '%biryani%' OR f.name LIKE '%karahi%' OR f.name LIKE '%korma%' OR f.name LIKE '%nihari%')";
            $result = mysqli_query($conn, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                while($food = mysqli_fetch_assoc($result)) {
                    $discount_price = $food['price'] - ($food['price'] * $food['discount'] / 100);
                    
                    echo '<div class="col-md-3 mb-4">
                            <div class="card food-card">
                                <div class="position-relative">';
                    
                    if ($food['discount'] > 0) {
                        echo '<span class="badge">' . $food['discount'] . '% OFF</span>';
                    }
                    
                    echo '      <img src="img/' . htmlspecialchars($food['image']) . '" class="card-img-top" alt="Food">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">' . htmlspecialchars($food['name']) . '</h5>
                                    <p class="card-text">' . htmlspecialchars($food['restaurant_name']) . '</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>';
                    
                    if ($food['discount'] > 0) {
                        echo '<span class="price">Rs. ' . number_format($discount_price, 0) . '</span>
                              <span class="original-price">Rs. ' . number_format($food['price'], 0) . '</span>';
                    } else {
                        echo '<span class="price">Rs. ' . number_format($food['price'], 0) . '</span>';
                    }
                    
                    echo '      </div>
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                        </div>
                                    </div>
                                    <button class="btn btn-sm btn-danger mt-2 w-100">Add to Cart</button>
                                </div>
                            </div>
                        </div>';
                }
            } else {
                echo '<div class="col-12 text-center">
                        <p>No desi food items available at the moment.</p>
                      </div>';
            }
          ?>
        </div>
      </div>
      
      <div class="tab-pane fade" id="desserts" role="tabpanel">
        <div class="row">
          <?php
            // Fetch dessert items
            $sql = "SELECT f.*, r.name as restaurant_name FROM tbl_foods f 
                    JOIN tblrestaurants_delivery r ON f.restaurant_id = r.id 
                    WHERE r.type = 'restaurant' AND (f.name LIKE '%cake%' OR f.name LIKE '%ice cream%' OR f.name LIKE '%kulfi%' OR f.name LIKE '%jalebi%')";
            $result = mysqli_query($conn, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                while($food = mysqli_fetch_assoc($result)) {
                    $discount_price = $food['price'] - ($food['price'] * $food['discount'] / 100);
                    
                    echo '<div class="col-md-3 mb-4">
                            <div class="card food-card">
                                <div class="position-relative">';
                    
                    if ($food['discount'] > 0) {
                        echo '<span class="badge">' . $food['discount'] . '% OFF</span>';
                    }
                    
                    echo '      <img src="img/' . htmlspecialchars($food['image']) . '" class="card-img-top" alt="Food">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">' . htmlspecialchars($food['name']) . '</h5>
                                    <p class="card-text">' . htmlspecialchars($food['restaurant_name']) . '</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>';
                    
                    if ($food['discount'] > 0) {
                        echo '<span class="price">Rs. ' . number_format($discount_price, 0) . '</span>
                              <span class="original-price">Rs. ' . number_format($food['price'], 0) . '</span>';
                    } else {
                        echo '<span class="price">Rs. ' . number_format($food['price'], 0) . '</span>';
                    }
                    
                    echo '      </div>
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                        </div>
                                    </div>
                                    <button class="btn btn-sm btn-danger mt-2 w-100">Add to Cart</button>
                                </div>
                            </div>
                        </div>';
                }
            } else {
                echo '<div class="col-12 text-center">
                        <p>No dessert items available at the moment.</p>
                      </div>';
            }
          ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Special Offers Section -->
<section class="py-5" id="offers">
  <div class="container">
    <h2 class="section-title text-center">Special Offers</h2>
    
    <div class="row">
      <?php
        // Fetch promotions that contain the word "offer"
        $sql = "SELECT * FROM tbl_promotions WHERE message LIKE '%offer%' ORDER BY created_at DESC";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo '<div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="row g-0">
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">Special Promotion</h5>
                                        <p class="card-text">' . $row["message"] . '</p>
                                        <p class="card-text"><small class="text-muted">Posted on ' . date("F j, Y", strtotime($row["created_at"])) . '</small></p>
                                        <a href="#" class="btn btn-sm btn-danger">Order Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
            }
        } else {
            echo '<div class="col-12 text-center">
                    <p>No special offers available at the moment. Check back later!</p>
                  </div>';
        }
      ?>
    </div>
  </div>
</section>

<!-- Testimonials Section -->
<section class="py-5 bg-light">
  <div class="container">
    <h2 class="section-title text-center">What Our Customers Say</h2>
    
    <div class="row">
      <?php
        // Fetch feedback data
        $sql = "SELECT f.*, u.name as customer_name FROM tbl_feedback f 
                JOIN tblusers u ON f.customer_id = u.id 
                ORDER BY f.created_at DESC";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                // Generate star rating based on the rating value
                $stars = '';
                for ($i = 1; $i <= 5; $i++) {
                    if ($i <= $row["rating"]) {
                        $stars .= '<i class="fas fa-star"></i>';
                    } else {
                        $stars .= '<i class="far fa-star"></i>';
                    }
                }
                
                echo '<div class="col-md-4 mb-4">
                        <div class="testimonial-card">
                            <div class="d-flex mb-3">
                                <div class="rating me-2">
                                    ' . $stars . '
                                </div>
                                <span class="text-muted">' . $row["customer_name"] . '</span>
                            </div>
                            <p class="card-text">"' . $row["comment"] . '"</p>
                        </div>
                    </div>';
            }
        } else {
            echo '<div class="col-12 text-center">
                    <p>No customer reviews available yet.</p>
                  </div>';
        }
      ?>
    </div>
  </div>
</section>

<!-- How It Works Section -->
<section class="py-5">
  <div class="container">
    <h2 class="section-title text-center">How It Works</h2>
    
    <div class="row text-center">
      <div class="col-md-3 mb-4">
        <div class="step-card">
          <div class="step-number">1</div>
          <h5 class="text-danger">Find Restaurants</h5>
          <p>Browse through our list of top-rated restaurants in your area.</p>
        </div>
      </div>
      
      <div class="col-md-3 mb-4">
        <div class="step-card">
          <div class="step-number">2</div>
          <h5 class="text-danger">Choose Your Food</h5>
          <p>Select your favorite dishes from the menu and add them to cart.</p>
        </div>
      </div>
      
      <div class="col-md-3 mb-4">
        <div class="step-card">
          <div class="step-number">3</div>
          <h5 class="text-danger">Pay Securely</h5>
          <p>Complete your payment using our secure payment gateway.</p>
        </div>
      </div>
      
      <div class="col-md-3 mb-4">
        <div class="step-card">
          <div class="step-number">4</div>
          <h5 class="text-danger">Fast Delivery</h5>
          <p>Sit back and relax while we deliver your food to your doorstep.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- System Panels -->
<section class="py-5 system">
  <div class="container">
    <h2 class="section-title text-center">System Panels</h2>
    <div class="row text-center">
      <div class="col-md-3 mb-4">
        <div class="panel-card p-4 bg-white">
          <div class="panel-circle"><i class="fas fa-user-shield"></i></div>
          <h5>Administrator</h5>
          <p class="small">Manages users, restaurants, and promotions.</p>
        </div>
      </div>
      <div class="col-md-3 mb-4">
        <div class="panel-card p-4 bg-white">
          <div class="panel-circle"><i class="fas fa-user"></i></div>
          <h5>Customer</h5>
          <p class="small">Registers, orders food, and leaves feedback.</p>
        </div>
      </div>
      <div class="col-md-3 mb-4">
        <div class="panel-card p-4 bg-white">
          <div class="panel-circle"><i class="fas fa-motorcycle"></i></div>
          <h5>Rider</h5>
          <p class="small">Receives orders and delivers food to customers.</p>
        </div>
      </div>
      <div class="col-md-3 mb-4">
        <div class="panel-card p-4 bg-white">
          <div class="panel-circle"><i class="fas fa-store"></i></div>
          <h5>Restaurant</h5>
          <p class="small">Manages menu, order alerts, and availability.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include("footer.html"); ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JS for Restaurant Search -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Restaurant search functionality
    const restaurantSearch = document.getElementById('restaurantSearch');
    const restaurantCards = document.querySelectorAll('.restaurant-card-container');
    
    restaurantSearch.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        
        restaurantCards.forEach(card => {
            const restaurantName = card.querySelector('.card-title').textContent.toLowerCase();
            const restaurantAddress = card.querySelector('.card-text').textContent.toLowerCase();
            
            if (restaurantName.includes(searchTerm) || restaurantAddress.includes(searchTerm)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
});
</script>

<?php
// Close database connection
mysqli_close($conn);
?>
</body>
</html>