<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact Us - FoodDelivery By Armina</title>
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
    
    .contact-info {
      background-color: var(--light-bg);
      border-radius: 10px;
      padding: 30px;
      margin-bottom: 30px;
      height: 100%;
    }
    
    .contact-info .icon {
      font-size: 2rem;
      color: var(--primary-color);
      margin-bottom: 15px;
    }
    
    .contact-form {
      background-color: white;
      border-radius: 10px;
      padding: 30px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    
    .form-control, .form-select {
      border-radius: 5px;
      border: 1px solid #ddd;
      padding: 12px 15px;
    }
    
    .form-control:focus, .form-select:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 0.25rem rgba(255, 87, 34, 0.25);
    }
    
    .btn-primary {
      background-color: var(--primary-color);
      border-color: var(--primary-color);
      padding: 12px 30px;
      font-weight: 600;
      border-radius: 5px;
    }
    
    .btn-primary:hover {
      background-color: var(--primary-dark);
      border-color: var(--primary-dark);
    }
    
    .map-container {
      height: 400px;
      border-radius: 10px;
      overflow: hidden;
      margin-bottom: 30px;
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
    
    .social-links a {
      display: inline-block;
      width: 40px;
      height: 40px;
      line-height: 40px;
      text-align: center;
      border-radius: 50%;
      background-color: var(--primary-color);
      color: white;
      margin-right: 10px;
      transition: all 0.3s ease;
    }
    
    .social-links a:hover {
      background-color: var(--primary-dark);
      transform: translateY(-3px);
    }
  </style>
</head>
<body>
<?php include("header.html"); ?>

<!-- Page Header -->
<div class="page-header">
  <div class="container">
    <h1>Contact Us</h1>
    <p class="lead">We'd love to hear from you</p>
  </div>
</div>

<!-- Contact Section -->
<section class="py-5">
  <div class="container">
    <div class="row">
      <div class="col-lg-5 mb-4">
        <h2 class="section-title">Get In Touch</h2>
        
        <div class="contact-info mb-4">
          <div class="d-flex align-items-start mb-4">
            <div class="icon me-3">
              <i class="fas fa-map-marker-alt"></i>
            </div>
            <div>
              <h5>Our Location</h5>
              <p>123 Food Street, Lahore, Pakistan</p>
            </div>
          </div>
          
          <div class="d-flex align-items-start mb-4">
            <div class="icon me-3">
              <i class="fas fa-phone-alt"></i>
            </div>
            <div>
              <h5>Phone Number</h5>
              <p>+92 300 1234567</p>
              <p>+92 42 12345678</p>
            </div>
          </div>
          
          <div class="d-flex align-items-start mb-4">
            <div class="icon me-3">
              <i class="fas fa-envelope"></i>
            </div>
            <div>
              <h5>Email Address</h5>
              <p>info@fooddelivery.com</p>
              <p>support@fooddelivery.com</p>
            </div>
          </div>
          
          <div class="d-flex align-items-start">
            <div class="icon me-3">
              <i class="fas fa-clock"></i>
            </div>
            <div>
              <h5>Working Hours</h5>
              <p>Monday - Friday: 9:00 AM - 8:00 PM</p>
              <p>Saturday - Sunday: 10:00 AM - 6:00 PM</p>
            </div>
          </div>
        </div>
        
      </div>
      
      <div class="col-lg-7 mb-4">
        <h2 class="section-title">Send Us a Message</h2>
        
        <div class="contact-form">
          <form onsubmit="return showMessage();">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="name" class="form-label">Your Name</label>
                <input type="text" class="form-control" id="name" placeholder="Enter your name" required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="email" class="form-label">Your Email</label>
                <input type="email" class="form-control" id="email" placeholder="Enter your email" required>
              </div>
            </div>
            
            <div class="mb-3">
              <label for="subject" class="form-label">Subject</label>
              <input type="text" class="form-control" id="subject" placeholder="Enter subject" required>
            </div>
            
            <div class="mb-3">
              <label for="category" class="form-label">Category</label>
              <select class="form-select" id="category" required>
                <option value="" selected disabled>Select a category</option>
                <option value="general">General Inquiry</option>
                <option value="support">Technical Support</option>
                <option value="partnership">Partnership</option>
                <option value="feedback">Feedback</option>
                <option value="complaint">Complaint</option>
              </select>
            </div>
            
            <div class="mb-3">
              <label for="message" class="form-label">Your Message</label>
              <textarea class="form-control" id="message" rows="5" placeholder="Type your message here..." required></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Send Message</button>
          </form>
        </div>
      </div>
    </div>
    
    <br><br>
    <!-- FAQ Section -->
    <div class="row mt-5">
      <div class="col-12">
        <h2 class="section-title content-centre">Frequently Asked Questions</h2>
        
        <div class="accordion" id="faqAccordion">
          <div class="accordion-item mb-3">
            <h2 class="accordion-header" id="headingOne">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                How do I place an order?
              </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                To place an order, simply browse our restaurants, select your favorite dishes, add them to your cart, and proceed to checkout. You'll need to create an account or log in if you already have one.
              </div>
            </div>
          </div>
          
          <div class="accordion-item mb-3">
            <h2 class="accordion-header" id="headingTwo">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                What payment methods do you accept?
              </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                We accept various payment methods including credit/debit cards, online bank transfers, and cash on delivery. All transactions are secure and encrypted.
              </div>
            </div>
          </div>
          
          <div class="accordion-item mb-3">
            <h2 class="accordion-header" id="headingThree">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                How long does delivery take?
              </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                Delivery time varies depending on the restaurant's location and current demand. Typically, deliveries take between 30-60 minutes. You can track your order in real-time through our app.
              </div>
            </div>
          </div>
          
          <div class="accordion-item mb-3">
            <h2 class="accordion-header" id="headingFour">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                How can I become a partner restaurant?
              </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                If you're a restaurant owner interested in partnering with us, please fill out the partnership form on our website or contact our business development team at partnerships@fooddelivery.com.
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include("footer.html"); ?>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- JavaScript Alert -->
<script>
  function showMessage() {
    alert("Thank you! Your message has been received. We'll get back to you soon.");
    return false; // prevent actual form submission
  }
</script>
</body>
</html>