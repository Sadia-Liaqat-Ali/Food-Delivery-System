<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>About Us - FoodDelivery By Armina</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  
  <!-- Custom Styles -->
  <style>
    :root {
      --primary-color: #ff5722;
      --primary-dark: #e64a19;
      --secondary-color: #212529;
      --light-bg: #f8f9fa;
    }
    
    body { 
      font-family: 'Segoe UI', sans-serif;
      color: #333;
    }
    
    .page-header {
      background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('img/banner.jpg') no-repeat center center;
      background-size: cover;
      color: white;
      padding: 80px 0;
      text-align: center;
    }
    
    .page-header h1 {
      font-size: 3rem;
      font-weight: 700;
    }
    
    .section-title {
      font-weight: bold;
      margin-bottom: 40px;
      position: relative;
      padding-bottom: 15px;
    }
    
    .section-title:after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 70px;
      height: 3px;
      background-color: var(--primary-color);
    }
    
    .timeline {
      position: relative;
      padding: 20px 0;
    }
    
    .timeline:before {
      content: '';
      position: absolute;
      top: 0;
      left: 15px;
      height: 100%;
      width: 2px;
      background: var(--primary-color);
    }
    
    .timeline-item {
      margin-bottom: 30px;
      margin-left: 40px;
      position: relative;
    }
    
    .timeline-item:before {
      content: '';
      position: absolute;
      top: 5px;
      left: -40px;
      width: 20px;
      height: 20px;
      border-radius: 50%;
      background: var(--primary-color);
      border: 4px solid white;
      box-shadow: 0 0 0 2px var(--primary-color);
    }
    
    .team-member {
      text-align: center;
      margin-bottom: 30px;
    }
    
    .team-member img {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      object-fit: cover;
      margin-bottom: 15px;
      border: 4px solid var(--primary-color);
    }
    
    .team-member h5 {
      font-weight: 600;
      margin-bottom: 5px;
    }
    
    .team-member .position {
      color: var(--primary-color);
      font-weight: 500;
    }
    
    .icon-box {
      text-align: center;
      padding: 30px 20px;
      border-radius: 10px;
      background-color: var(--light-bg);
      margin-bottom: 30px;
      transition: all 0.3s ease;
    }
    
    .icon-box:hover {
      transform: translateY(-10px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .icon-box .icon {
      font-size: 3rem;
      color: var(--primary-color);
      margin-bottom: 20px;
    }
    
    .footer {
      background-color: var(--secondary-color);
      color: #ccc;
      padding: 40px 0 20px;
    }
    
    .footer a {
      color: #ffc107;
      text-decoration: none;
      transition: all 0.3s ease;
    }
    
    .footer a:hover { 
      text-decoration: underline;
      color: white;
    }
  </style>
</head>
<body>
<?php include("header.html"); ?>

<!-- Page Header -->
<div class="page-header">
  <div class="container">
    <h1>About Us</h1>
    <p class="lead">Learn more about our food delivery service</p>
  </div>
</div>

<!-- About Section -->
<section class="py-5">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 mb-4">
        <h2 class="section-title">Our Story</h2>
        <p>FoodDelivery By Armina was founded with a simple mission: to connect people with their favorite food. We started as a small project by Virtual University students and have grown into a comprehensive food delivery platform serving multiple cities.</p>
        <p>Our platform allows users to register as customers, riders, or administrators. Customers can browse menus, place orders, and receive food at their doorstep. Riders manage deliveries, and restaurants update order statuses.</p>
        <p>We're committed to providing a seamless food ordering experience with features like promotions, discounts, SMS alerts, and customer feedback to ensure service quality.</p>
      </div>
      <div class="col-lg-6 mb-4">
        <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" class="img-fluid rounded" alt="Our Story">
      </div>
    </div>
  </div>
</section>

<!-- Mission & Vision Section -->
<section class="py-5 bg-light">
  <div class="container">
    <div class="row">
      <div class="col-md-6 mb-4">
        <div class="icon-box">
          <div class="icon"><i class="fas fa-bullseye"></i></div>
          <h3>Our Mission</h3>
          <p>To make food ordering convenient and accessible for everyone, connecting customers with their favorite restaurants through a reliable and efficient delivery service.</p>
        </div>
      </div>
      <div class="col-md-6 mb-4">
        <div class="icon-box">
          <div class="icon"><i class="fas fa-eye"></i></div>
          <h3>Our Vision</h3>
          <p>To become the leading food delivery platform in Pakistan, known for exceptional service, wide restaurant selection, and innovative technology solutions.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Our History Timeline -->
<section class="py-5">
  <div class="container">
    <h2 class="section-title">Our Journey</h2>
    <div class="timeline">
      <div class="timeline-item">
        <h4>2024 - The Idea</h4>
        <p>Conceptualized as a final year project by Virtual University students to address the growing need for reliable food delivery services.</p>
      </div>
      <div class="timeline-item">
        <h4>2024 - Development Begins</h4>
        <p>Started building the platform with focus on user experience, restaurant management, and delivery tracking systems.</p>
      </div>
      <div class="timeline-item">
        <h4>2025 - Launch</h4>
        <p>Officially launched with partnerships with local restaurants in Lahore, starting with a select group of eateries.</p>
      </div>
      <div class="timeline-item">
        <h4>2025 - Expansion</h4>
        <p>Expanded to multiple cities including Islamabad, Rawalpindi, and Multan, with plans to cover all major cities in Pakistan.</p>
      </div>
    </div>
  </div>
</section>


<!-- Values Section -->
<section class="py-5">
  <div class="container">
    <h2 class="section-title text-center">Our Values</h2>
    <div class="row">
      <div class="col-md-4 mb-4">
        <div class="card h-100 border-0 shadow-sm">
          <div class="card-body text-center">
            <div class="icon mb-3" style="color: var(--primary-color); font-size: 2.5rem;">
              <i class="fas fa-heart"></i>
            </div>
            <h4>Customer First</h4>
            <p>We prioritize our customers' needs and strive to provide the best food delivery experience possible.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card h-100 border-0 shadow-sm">
          <div class="card-body text-center">
            <div class="icon mb-3" style="color: var(--primary-color); font-size: 2.5rem;">
              <i class="fas fa-handshake"></i>
            </div>
            <h4>Partnership</h4>
            <p>We build strong relationships with our restaurant partners to ensure quality and variety for our customers.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card h-100 border-0 shadow-sm">
          <div class="card-body text-center">
            <div class="icon mb-3" style="color: var(--primary-color); font-size: 2.5rem;">
              <i class="fas fa-rocket"></i>
            </div>
            <h4>Innovation</h4>
            <p>We continuously improve our platform with new features and technologies to enhance the user experience.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php include("footer.html"); ?>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>