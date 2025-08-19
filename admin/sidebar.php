<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<div class="bg-dark text-white d-flex flex-column p-3" style="min-height: 100vh; width: 250px;">
  <h4 class="text-center mb-3 welcome-text">👋WELLCOME! <br> SYSTEM ADMIN</h4>
  <hr class="text-secondary">

  <ul class="nav flex-column gap-1">
    <li class="nav-item">
      <a class="nav-link text-white d-flex align-items-center gap-2 sidebar-link" href="admin_dashboard.php">
        <i class="bi bi-speedometer2"></i> Dashboard
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link text-white d-flex align-items-center gap-2 sidebar-link" href="add-resturant.php">
        <i class="bi bi-shop"></i> Add Restaurants
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link text-white d-flex align-items-center gap-2 sidebar-link" href="manage_riders.php">
        <i class="bi bi-person-bounding-box"></i> Add Delivery Men
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link text-white d-flex align-items-center gap-2 sidebar-link" href="manage_promotions.php">
        <i class="bi bi-megaphone"></i> Manage Promotions
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link text-white d-flex align-items-center gap-2 sidebar-link" href="manage_customers.php">
        <i class="bi bi-people"></i> View Customer Profiles
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

  /* Icon adjustment */
  .sidebar-link i {
    font-size: 1.2rem;
  }

  hr.text-secondary {
    border-top: 1px solid rgba(255, 255, 255, 0.3);
  }

  /* Welcome text animation */
  .welcome-text {
    font-size: 1.1rem;
    font-weight: bold;
    color: white;
    animation: fadeInZoom 2s ease-in-out infinite alternate;
  }

  @keyframes fadeInZoom {
    0% {
      opacity: 0.5;
      transform: scale(0.95);
    }
    100% {
      opacity: 1;
      transform: scale(1.05);
    }
  }
</style>
