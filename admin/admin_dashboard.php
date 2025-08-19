<?php
session_start();
include("../dbconnection.php");

if (!isset($_SESSION['userid']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

/* ======= SMALL STATS (first row) ======= */
$restaurants = (int) mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM tblrestaurants_delivery WHERE type='restaurant'"))[0];
$foods       = (int) mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM tbl_foods"))[0];
$customers   = (int) mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM tblusers WHERE user_type='customer'"))[0];
$riders      = (int) mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM tblusers WHERE user_type='rider'"))[0];
$orders      = (int) mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM tbl_orders"))[0];
$menus       = (int) mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM tbl_menus"))[0];

/* ======= REPORT QUERIES (match your DB) ======= */

/* 1) Restaurants as per orders (join through foods.restaurant_id) */
$qRestaurants = mysqli_query($conn, "
  SELECT r.name AS label, COUNT(o.id) AS total_orders
  FROM tbl_orders o
  JOIN tbl_foods f ON f.id = o.food_id
  JOIN tblrestaurants_delivery r ON r.id = f.restaurant_id
  GROUP BY r.id
  ORDER BY total_orders DESC
  LIMIT 10
");
$restaurantsOrders = [];
while ($row = mysqli_fetch_assoc($qRestaurants)) $restaurantsOrders[] = $row;

/* 2) Foods as per orders (sales) -> LINE CHART */
$qFoods = mysqli_query($conn, "
  SELECT f.name AS label, COALESCE(SUM(o.quantity),0) AS total_sold
  FROM tbl_foods f
  LEFT JOIN tbl_orders o ON o.food_id = f.id
  GROUP BY f.id
  ORDER BY total_sold DESC, f.name ASC
  LIMIT 12
");
$foodsOrders = [];
while ($row = mysqli_fetch_assoc($qFoods)) $foodsOrders[] = $row;

/* 3) Riders as per orders
   NOTE: schema has no rider_id on orders. We estimate:
   - If a rider is APPROVED for a restaurant, all orders placed for that restaurant count to that rider.
   This is a proxy until you store rider_id on each order.
*/
$qRiders = mysqli_query($conn, "
  WITH orders_by_rest AS (
    SELECT f.restaurant_id, COUNT(o.id) AS order_count
    FROM tbl_orders o
    JOIN tbl_foods f ON f.id = o.food_id
    GROUP BY f.restaurant_id
  )
  SELECT u.name AS label, COALESCE(SUM(obr.order_count),0) AS total_orders
  FROM tblusers u
  JOIN tbl_rider_applications ra ON ra.rider_id = u.id AND ra.status='approved'
  LEFT JOIN orders_by_rest obr ON obr.restaurant_id = ra.restaurant_id
  WHERE u.user_type='rider'
  GROUP BY u.id
  ORDER BY total_orders DESC, u.name ASC
  LIMIT 10
");
$ridersOrders = [];
while ($row = mysqli_fetch_assoc($qRiders)) $ridersOrders[] = $row;

/* 4) Customers who get more orders -> BAR CHART */
$qCustomers = mysqli_query($conn, "
  SELECT u.name AS label, COUNT(o.id) AS total_orders
  FROM tbl_orders o
  JOIN tblusers u ON u.id = o.customer_id
  WHERE u.user_type='customer'
  GROUP BY u.id
  ORDER BY total_orders DESC, u.name ASC
  LIMIT 10
");
$customersOrders = [];
while ($row = mysqli_fetch_assoc($qCustomers)) $customersOrders[] = $row;

/* Discounts -> PIE CHART */
$qDiscounts = mysqli_query($conn, "
  SELECT name AS label, discount AS value
  FROM tbl_foods
  WHERE discount > 0
  ORDER BY discount DESC, name ASC
  LIMIT 10
");
$discounts = [];
while ($row = mysqli_fetch_assoc($qDiscounts)) $discounts[] = $row;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard • FoodDelivery</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- CSS & libs -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1"></script>
  <style>
    :root{
      --brand:#0d6efd;
      --bg:#f4f6f9;
      --card:#ffffff;
    }
    body{background:var(--bg);}
    .app-wrapper{min-height:100vh;}
    /* Sidebar layout */
    .sidebar{
      background:#111827;
      color:#cbd5e1;
      min-height:100vh;
      position:sticky; top:0;
      padding:1rem 0.75rem;
    }
    .sidebar a{color:#cbd5e1; text-decoration:none; display:block; padding:.6rem .8rem; border-radius:.5rem; transition:.25s;}
    .sidebar a:hover{background:#1f2937; color:#fff; transform:translateX(4px);}
    .sidebar .logo{color:#fff; font-weight:700; letter-spacing:.5px; font-size:1.1rem; margin-bottom:1rem;}
    .sidebar .section-title{color:#9ca3af; font-size:.8rem; text-transform:uppercase; margin:.9rem .6rem .4rem;}
    /* Top header */
    .page-header{
      background:linear-gradient(90deg, var(--brand), #2563eb);
      color:#fff; border-radius:12px; padding:16px 20px; box-shadow:0 6px 18px rgba(0,0,0,.08);
      display:flex; align-items:center; justify-content:space-between;
    }
    .page-title{margin:0; font-weight:700;}
    /* Small stat cards (first row) */
    .mini-card{
      background:var(--card); border-radius:12px; padding:14px; text-align:center;
      box-shadow:0 6px 18px rgba(0,0,0,.06); transition:.25s; height:100%;
    }
    .mini-card:hover{transform:translateY(-6px); box-shadow:0 10px 26px rgba(0,0,0,.12);}
    .mini-label{font-size:.8rem; color:#6b7280; margin-bottom:4px;}
    .mini-value{font-size:1.4rem; font-weight:800; color:#0d6efd;}
    /* Report cards */
    .report-card{
      background:var(--card); border-radius:14px; padding:14px; height:100%;
      box-shadow:0 8px 24px rgba(0,0,0,.08); transition:.25s;
    }
    .report-card:hover{transform:translateY(-4px);}
    .report-title{text-align:center; font-weight:700; margin:4px 0 10px;}
    .chart-wrap{height:230px;}
    /* helper */
    .muted{color:#6b7280;}
    .tiny{font-size:.85rem;}
    .list-clean{list-style:none; padding-left:0; margin:0;}
  </style>
</head>
<body>
<div class="container-fluid">
  <div class="row g-0">
    <!-- Sidebar (INCLUDED as requested) -->
    <div class="col-12 col-md-3 col-lg-2">
      <?php include("sidebar.php"); ?>
    </div>

    <!-- Main content full width beside sidebar -->
    <div class="col-12 col-md-9 col-lg-10 p-3 p-md-4">
      <div class="page-header mb-3">
        <h4 class="page-title">Admin Dashboard Overview!</h4>
        <div class="tiny">Welcome, <strong><?php echo htmlspecialchars($_SESSION['name'] ?? 'Admin'); ?></strong></div>
      </div>

      <!-- FIRST ROW: small cards -->
      <div class="row g-3 mb-3">
        <div class="col-6 col-sm-4 col-lg-2"><div class="mini-card"><div class="mini-label">Restaurants</div><div class="mini-value"><?php echo $restaurants; ?></div></div></div>
        <div class="col-6 col-sm-4 col-lg-2"><div class="mini-card"><div class="mini-label">Menus</div><div class="mini-value"><?php echo $menus; ?></div></div></div>
        <div class="col-6 col-sm-4 col-lg-2"><div class="mini-card"><div class="mini-label">Foods</div><div class="mini-value"><?php echo $foods; ?></div></div></div>
        <div class="col-6 col-sm-4 col-lg-2"><div class="mini-card"><div class="mini-label">Customers</div><div class="mini-value"><?php echo $customers; ?></div></div></div>
        <div class="col-6 col-sm-4 col-lg-2"><div class="mini-card"><div class="mini-label">Riders</div><div class="mini-value"><?php echo $riders; ?></div></div></div>
        <div class="col-6 col-sm-4 col-lg-2"><div class="mini-card"><div class="mini-label">Orders</div><div class="mini-value"><?php echo $orders; ?></div></div></div>
      </div>

      <!-- REPORTS GRID: four reports on the first page (small size, clear centered headings) -->
      <div class="row g-3">
        <!-- 1) Restaurants per Orders (Bar) -->
        <div class="col-12 col-md-6 col-xxl-3">
          <div class="report-card">
            <h6 class="report-title">Restaurants by Orders</h6>
            <div class="chart-wrap"><canvas id="restaurantsChart"></canvas></div>
            <p class="tiny text-center mt-2 muted">Top restaurants based on total orders (derived from foods → restaurant).</p>
          </div>
        </div>

        <!-- 2) Foods Sales (Line) -->
        <div class="col-12 col-md-6 col-xxl-3">
          <div class="report-card">
            <h6 class="report-title">Food Sales (Line)</h6>
            <div class="chart-wrap"><canvas id="foodsLineChart"></canvas></div>
            <p class="tiny text-center mt-2 muted">Total quantities sold per food (higher is better).</p>
          </div>
        </div>

        <!-- 3) Discounts (Pie) -->
        <div class="col-12 col-md-6 col-xxl-3">
          <div class="report-card">
            <h6 class="report-title">Active Discounts (Pie)</h6>
            <div class="chart-wrap"><canvas id="discountsPieChart"></canvas></div>
            <p class="tiny text-center mt-2 muted">Relative size of discounts on discounted foods.</p>
          </div>
        </div>

        <!-- 4) Customers by Orders (Bar) -->
        <div class="col-12 col-md-6 col-xxl-3">
          <div class="report-card">
            <h6 class="report-title">Top Customers (Orders)</h6>
            <div class="chart-wrap"><canvas id="customersBarChart"></canvas></div>
            <p class="tiny text-center mt-2 muted">Customers ranked by number of orders.</p>
          </div>
        </div>
      </div>

      <!-- RIDERS SECTION (text + small chart) -->
      <div class="row g-3 mt-3">
        <div class="col-12 col-lg-6">
          <div class="report-card">
            <h6 class="report-title">Riders (Estimated Orders)</h6>
            <div class="chart-wrap"><canvas id="ridersBarChart"></canvas></div>
            <ul class="list-clean tiny mt-2">
              <?php if (count($ridersOrders) === 0): ?>
                <li class="muted text-center">No rider approvals or orders yet.</li>
              <?php else: foreach ($ridersOrders as $r): ?>
                <li class="text-center"><?php echo htmlspecialchars($r['label']); ?> took ~ <strong><?php echo (int)$r['total_orders']; ?></strong> orders</li>
              <?php endforeach; endif; ?>
            </ul>
            <p class="tiny text-center mt-2 muted">
              Note: Your schema doesn’t store a rider on each order. This estimate counts orders from restaurants the rider is <em>approved</em> for.
              To get exact numbers, add a <code>rider_id</code> column in <code>tbl_orders</code>.
            </p>
          </div>
        </div>

        <!-- OPTIONAL: Sales summary (sum of total_price) -->
        <div class="col-12 col-lg-6">
          <div class="report-card">
            <h6 class="report-title">Discounted vs Non-discounted Sales (Donut)</h6>
            <div class="chart-wrap"><canvas id="salesDonut"></canvas></div>
            <?php
              // quick server-side calc for donut
              $row = mysqli_fetch_assoc(mysqli_query($conn, "
                SELECT
                  SUM(CASE WHEN f.discount>0 THEN o.total_price ELSE 0 END) AS discounted_sales,
                  SUM(CASE WHEN f.discount=0 THEN o.total_price ELSE 0 END) AS nondiscount_sales
                FROM tbl_orders o
                JOIN tbl_foods f ON f.id=o.food_id
              "));
              $discountedSales = (float)($row['discounted_sales'] ?? 0);
              $nondiscountSales = (float)($row['nondiscount_sales'] ?? 0);
            ?>
            <p class="tiny text-center mt-2 muted">
              Shows revenue share from discounted vs non-discounted items.
            </p>
          </div>
        </div>
      </div>

    </div><!-- /main -->
  </div>
</div>

<script>
/* ======= Data from PHP ======= */
const restaurantsOrders = <?php echo json_encode($restaurantsOrders); ?>;
const foodsOrders       = <?php echo json_encode($foodsOrders); ?>;
const customersOrders   = <?php echo json_encode($customersOrders); ?>;
const discountsData     = <?php echo json_encode($discounts); ?>;
const ridersOrders      = <?php echo json_encode($ridersOrders); ?>;
const discountedSales   = <?php echo json_encode($discountedSales); ?>;
const nondiscountSales  = <?php echo json_encode($nondiscountSales); ?>;

/* ======= Chart helpers (simple default style; Chart.js picks colors itself) ======= */
function makeBar(ctx, labels, data, label){
  return new Chart(ctx, {
    type: 'bar',
    data: { labels, datasets: [{ label, data }] },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      scales: { y: { beginAtZero: true, ticks: { precision:0 } } }
    }
  });
}
function makeLine(ctx, labels, data, label){
  return new Chart(ctx, {
    type: 'line',
    data: { labels, datasets: [{ label, data, fill:false, tension:.3 }] },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      scales: { y: { beginAtZero: true, ticks: { precision:0 } } }
    }
  });
}
function makePie(ctx, labels, data, type='pie'){
  return new Chart(ctx, {
    type,
    data: { labels, datasets: [{ data }] },
    options: { responsive: true, maintainAspectRatio: false }
  });
}

/* ======= Build charts ======= */
// 1) Restaurants by Orders (Bar)
makeBar(
  document.getElementById('restaurantsChart'),
  restaurantsOrders.map(x => x.label),
  restaurantsOrders.map(x => Number(x.total_orders)),
  'Orders'
);

// 2) Foods Sales (Line)
makeLine(
  document.getElementById('foodsLineChart'),
  foodsOrders.map(x => x.label),
  foodsOrders.map(x => Number(x.total_sold)),
  'Qty Sold'
);

// 3) Discounts (Pie)
makePie(
  document.getElementById('discountsPieChart'),
  discountsData.map(x => x.label),
  discountsData.map(x => Number(x.value)),
  'pie'
);

// 4) Customers by Orders (Bar)
makeBar(
  document.getElementById('customersBarChart'),
  customersOrders.map(x => x.label),
  customersOrders.map(x => Number(x.total_orders)),
  'Orders'
);

// Riders (Bar) + text list already printed
makeBar(
  document.getElementById('ridersBarChart'),
  ridersOrders.map(x => x.label),
  ridersOrders.map(x => Number(x.total_orders)),
  'Estimated Orders'
);

// Sales donut (discounted vs non-discounted)
makePie(
  document.getElementById('salesDonut'),
  ['Discounted Sales','Non-discounted Sales'],
  [Number(discountedSales||0), Number(nondiscountSales||0)],
  'doughnut'
);
</script>
</body>
</html>
