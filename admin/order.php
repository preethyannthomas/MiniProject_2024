<?php
// Include the database connection file
include("../connection.php");
session_start();
if (!isset($_SESSION['user_id'])) {
    header('location:./');
    exit();
}

// Function to fetch paginated order data from the database with status filter
function fetchOrders($conn, $limit, $offset, $status = null) {
    $query = "SELECT o.order_id, s.seller_name, c.customer_name, p.product_name, od.quantity, p.price, o.status
              FROM tbl_order o
              INNER JOIN tbl_customer c ON o.customer_id = c.customer_id
              INNER JOIN tbl_orderdetail od ON o.order_id = od.order_id
              INNER JOIN tbl_product p ON od.product_id = p.product_id
              INNER JOIN tbl_seller s ON p.seller_id = s.seller_id";
    
    if ($status) {
        $query .= " WHERE o.status = '$status'";
    }

    $query .= " LIMIT $limit OFFSET $offset";
    
    $result = $conn->query($query);
    $data = [];

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        echo "Error executing query: " . $conn->error;
    }

    return $data;
}

// Define the number of entries per page
$entriesPerPage = isset($_GET['entries']) ? intval($_GET['entries']) : 10;

// Get the selected status filter (pending, shipped, delivered)
$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';

// Calculate the total number of orders based on the selected status filter
$totalOrdersQuery = "SELECT COUNT(*) AS total FROM tbl_order";
if ($statusFilter) {
    $totalOrdersQuery .= " WHERE status = '$statusFilter'";
}
$totalOrdersResult = $conn->query($totalOrdersQuery);
$totalOrders = $totalOrdersResult->fetch_assoc()['total'];

// Calculate the total number of pages
$totalPages = ceil($totalOrders / $entriesPerPage);

// Get the current page number from the URL
$currentSlide = isset($_GET['slide']) ? max(1, min($totalPages, $_GET['slide'])) : 1;

// Calculate the offset
$offset = ($currentSlide - 1) * $entriesPerPage;

// Fetch orders for the current page with status filter
$orders = fetchOrders($conn, $entriesPerPage, $offset, $statusFilter);

// Function to generate the status filter URL
function getStatusFilterUrl($status) {
    global $entriesPerPage, $currentSlide;
    return "order.php?entries=$entriesPerPage&slide=$currentSlide&status=$status";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Listing</title>
    <!-- Include Chart.js library -->

     <link rel="stylesheet" href="../libs/bower/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="../libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.css">
  <!-- build:css assets/css/app.min.css -->
  <link rel="stylesheet" href="../libs/bower/animate.css/animate.min.css">
  <link rel="stylesheet" href="../libs/bower/fullcalendar/dist/fullcalendar.min.css">
  <link rel="stylesheet" href="../libs/bower/perfect-scrollbar/css/perfect-scrollbar.css">
  <link rel="stylesheet" href="../assets/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/css/core.css">
  <link rel="stylesheet" href="../assets/css/app.css">
  <!-- endbuild -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">
  <script src="../libs/bower/breakpoints.js/dist/breakpoints.min.js"></script>
  <script>
    Breakpoints();
  </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- ... (previous code) ... -->
<style>
    /* Style the container to control chart size */
    .chart-container {
        width: 500px; /* Adjust width as needed */
        height: 500px; /* Adjust height as needed */
        margin: 0 auto; /* Center the chart within the container */
    }
    
    /* Pagination styling */
    .pagination {
        display: inline-block;
        background-color: #fff;
        padding: 5px;
        border-radius: 5px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
    }

    .pagination a {
        color: black;
        float: left;
        padding: 8px 16px;
        text-decoration: none;
    }

    .pagination a.active {
        background-color: #333;
        color: white;
    }

    .pagination a:hover {
        background-color: #ddd;
    }
    
/* Updated Status button styling */
.status-button {
    padding: 5px 10px;
    color: white;
    border: none;
    border-radius: 30px;
    cursor: pointer;
    width: 100px; /* Adjust width as needed for uniformity */
    transition: background-color 0.3s ease-in-out;
    opacity: 0.8px;
}

.status-pending {
    background-color: #ff6347; /* Tomato Red */
}

.status-shipped {
    background-color: #0ac4f7; /* Sunflower Yellow */
}

.status-delivered {
    background-color: #2ecc71; /* Emerald Green */
}
</style>
<!-- ... (previous code) ... -->


</head>
<body class="menubar-left menubar-unfold menubar-light theme-primary">
    <!--============= start main area -->

    <?php include_once('header.php');?>

    <?php include_once('sidebar.php');?>
    <main id="app-main" class="app-main">
        <div class="wrap">
            <section class="app-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="widget">
                            <header class="widget-header">
                                <h3 class="widget-title">Order Listing</h3>
                            </header><!-- .widget-header -->
                            <hr class="widget-separator">
                            <div class="widget-body">
                                <div class="row">
                                    <div class="container">
                                        <!-- Entries per page dropdown -->
                                        <div class="form-group">
                                            <label for="entriesPerPage">Show:</label>
                                            <select id="entriesPerPage" name="entriesPerPage">
                                                <option value="10" <?php if ($entriesPerPage === 10) echo 'selected'; ?>>10</option>
                                                <option value="25" <?php if ($entriesPerPage === 25) echo 'selected'; ?>>25</option>
                                                <option value="50" <?php if ($entriesPerPage === 50) echo 'selected'; ?>>50</option>
                                            </select>
                                        
&emsp;
                                        <!-- Status filter -->
                                        
                                            <label for="statusFilter">Filter by Status:</label>
                                            <select id="statusFilter" name="statusFilter">
                                                <option value="">All</option>
                                                <option value="pending" <?php if ($statusFilter === 'pending') echo 'selected'; ?>>Pending</option>
                                                <option value="shipped" <?php if ($statusFilter === 'shipped') echo 'selected'; ?>>Shipped</option>
                                                <option value="delivered" <?php if ($statusFilter === 'delivered') echo 'selected'; ?>>Delivered</option>
                                            </select>
                                        </div>

                                        <!-- Order Table -->
 <!-- Order Table -->
 <table class="table">
    <thead>
        <tr>
            <th>S. No.</th>
            <th>Order ID</th>
            <th>Seller Name</th>
            <th>Customer Name</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Calculate the starting row number
        $startRow = ($currentSlide - 1) * $entriesPerPage + 1;

        foreach ($orders as $index => $order):
            // Define a CSS class based on the status
            $statusClass = 'status-pending'; // Default status class
            if ($order['status'] === 'Shipped') {
                $statusClass = 'status-shipped';
            } elseif ($order['status'] === 'Delivered') {
                $statusClass = 'status-delivered';
            }
        ?>
             <tr>
            <td><?php echo $startRow + $index; ?></td>
            <td><?php echo $order['order_id']; ?></td>
            <td><?php echo $order['seller_name']; ?></td>
            <td><?php echo $order['customer_name']; ?></td>
            <td><?php echo $order['product_name']; ?></td>
            <td><?php echo $order['quantity']; ?></td>
            <td><?php echo $order['price']; ?></td>
            <td>
                <button class="status-button <?php echo $statusClass; ?>">
                    <?php echo ucfirst($order['status']); ?>
                </button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>




                                        <!-- Pagination -->
                                        <div class="pagination">
                                            <?php if ($currentSlide > 1): ?>
                                                <a href="<?php echo "order.php?entries=$entriesPerPage&slide=1&status=$statusFilter"; ?>">First</a>
                                                <a href="<?php echo "order.php?entries=$entriesPerPage&slide=" . ($currentSlide - 1) . "&status=$statusFilter"; ?>">Previous</a>
                                            <?php endif; ?>
                                            
                                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                                <a class="<?php echo $i === $currentSlide ? 'active' : ''; ?>"
                                                   href="<?php echo "order.php?entries=$entriesPerPage&slide=$i&status=$statusFilter"; ?>">
                                                    <?php echo $i; ?>
                                                </a>
                                            <?php endfor; ?>
                                            
                                            <?php if ($currentSlide < $totalPages): ?>
                                                <a href="<?php echo "order.php?entries=$entriesPerPage&slide=" . ($currentSlide + 1) . "&status=$statusFilter"; ?>">Next</a>
                                                <a href="<?php echo "order.php?entries=$entriesPerPage&slide=$totalPages&status=$statusFilter"; ?>">Last</a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- APP FOOTER -->
        <?php include_once('footer.php');?>
    </main>
    <script>
        // Function to reload the page with updated entries per page value
        function updateEntriesPerPage() {
            var selectedValue = document.getElementById('entriesPerPage').value;
            window.location.href = 'order.php?entries=' + selectedValue;
        }

        // Function to reload the page with selected status filter
        function updateStatusFilter() {
            var selectedValue = document.getElementById('statusFilter').value;
            window.location.href = 'order.php?entries=<?php echo $entriesPerPage; ?>&slide=1&status=' + selectedValue;
        }

        // Listen for changes in the entries per page dropdown
        document.getElementById('entriesPerPage').addEventListener('change', updateEntriesPerPage);

        // Listen for changes in the status filter dropdown
        document.getElementById('statusFilter').addEventListener('change', updateStatusFilter);
    </script>
    <script src="../libs/bower/jquery/dist/jquery.js"></script>
    <script src="../libs/bower/jquery-ui/jquery-ui.min.js"></script>
    <script src="../libs/bower/jQuery-Storage-API/jquery.storageapi.min.js"></script>
    <script src="../libs/bower/bootstrap-sass/assets/javascripts/bootstrap.js"></script>
    <script src="../libs/bower/jquery-slimscroll/jquery.slimscroll.js"></script>
    <script src="../libs/bower/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
    <script src="../libs/bower/PACE/pace.min.js"></script>
    <!-- endbuild -->

    <!-- build:js assets/js/app.min.js -->
    <script src="../assets/js/library.js"></script>
    <script src="../assets/js/plugins.js"></script>
    <script src="../assets/js/app.js"></script>
    <!-- endbuild -->
    <script src="../libs/bower/moment/moment.js"></script>
    <script src="../libs/bower/fullcalendar/dist/fullcalendar.min.js"></script>
    <script src="../assets/js/fullcalendar.js"></script>
</body>
</html>
