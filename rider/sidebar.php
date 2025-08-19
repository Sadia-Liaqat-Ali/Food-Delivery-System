<?php
// Assuming rider is logged in
$riderName  = $_SESSION['name'] ?? "Rider";
$riderEmail = $_SESSION['email'] ?? "rider@example.com";
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<div class="sidebar bg-dark text-white d-flex flex-column p-3">
  
  <!-- Rider Info Card -->
  <div class="text-center mb-4 animate-fade-in">
    <div class="profile-icon bg-success text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2">
      <i class="bi bi-bicycle" style="font-size: 2rem;"></i>
    </div>
    <h5 class="mb-0"><?php echo htmlspecialchars($riderName); ?></h5>
    <small class="text-secondary"><?php echo htmlspecialchars($riderEmail); ?></small>
  </div>

  <hr class="text-secondary">

  <!-- Sidebar Menu -->
  <ul class="nav flex-column gap-1">
    <li class="nav-item">
      <a class="nav-link text-white d-flex align-items-center gap-2 sidebar-link" href="rider_dashboard.php">
        <i class="bi bi-house-door"></i> Dashboard
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link text-white d-flex align-items-center gap-2 sidebar-link" href="rider_profile.php">
        <i class="bi bi-person-lines-fill"></i> Update Profile
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link text-white d-flex align-items-center gap-2 sidebar-link" href="manage_orders.php">
        <i class="bi bi-bell-fill"></i> Order Alerts
      </a>
    </li>

    <li class="nav-item mt-auto">
      <a class="nav-link text-danger d-flex align-items-center gap-2 sidebar-link" href="../logout.php">
        <i class="bi bi-box-arrow-right"></i> Logout
      </a>
    </li>
  </ul>
</div>

<style>
  /* Sidebar container */
  .sidebar {
    width: 250px;              /* Fixed width */
    min-height: 100vh;         /* Full viewport height */
    height: 100%;              /* Extend as long as page */
    position: fixed;           /* Stick to left */
    top: 0;
    left: 0;
    overflow-y: auto;          /* Scroll if content too long */
  }

  .sidebar-link {
    transition: all 0.3s ease;
    padding: 8px 12px;
    border-radius: 6px;
    font-weight: 500;
  }

  .sidebar-link:hover {
    background-color: #495057;
    padding-left: 18px;
    text-decoration: none;
  }

  .sidebar-link.active {
    background-color: #0d6efd;
    color: white !important;
  }

  .sidebar-link i {
    font-size: 1.2rem;
  }

  hr.text-secondary {
    border-top: 1px solid rgba(255, 255, 255, 0.3);
  }

  /* Profile Icon */
  .profile-icon {
    width: 60px;
    height: 60px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.3);
    animation: bounce-in 0.6s ease;
  }

  /* Fade-in animation */
  .animate-fade-in {
    animation: fade-in 1s ease;
  }

  @keyframes fade-in {
    from { opacity: 0; transform: translateY(-10px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  @keyframes bounce-in {
    0%   { transform: scale(0.5); opacity: 0; }
    60%  { transform: scale(1.1); opacity: 1; }
    100% { transform: scale(1); }
  }
</style>
