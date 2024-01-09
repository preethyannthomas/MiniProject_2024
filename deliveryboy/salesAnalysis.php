<?php
// Include the database connection file
include("../connection.php");
// Fetch seller's products from tbl_product
session_start();
if (!isset($_SESSION['user_id'])) {
    header('location:./');
    exit();
}

// Fetch seller's sales data from tbl_product
$query = "SELECT s.seller_name, COUNT(p.product_id) AS product_count
          FROM tbl_product p
          INNER JOIN tbl_seller s ON p.seller_id = s.seller_id
          GROUP BY s.seller_name
          ORDER BY product_count DESC";

$result = $conn->query($query);

// Initialize arrays to store seller names and product counts
$sellerNames = [];
$productCounts = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $sellerNames[] = $row['seller_name'];
        $productCounts[] = $row['product_count'];
    }
} else {
    echo "Error executing query: " . $conn->error;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Seller Sales Comparison (Pie Chart)</title>
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
    <style>
        /* Style the container to control chart size */
        .chart-container {
            width: 500px; /* Adjust width as needed */
            height: 5; /* Adjust height as needed */
            margin: 0 auto; /* Center the chart within the container */
        }
    </style>
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
                                <h3 class="widget-title">Total Sales</h3>
                            </header><!-- .widget-header -->
                            <hr class="widget-separator">
                            <div class="widget-body">
                                <div class="row">
    <div class="container">
        <!-- Seller Sales Comparison Pie Chart -->
        <div class="chart-container">
            <canvas id="sellerSalesComparisonPieChart"></canvas>
        </div>
    </div>
    </div><!-- .widget-body -->
                        </div><!-- .widget -->
                    </div><!-- END column -->
                </div><!-- .row -->
            </section><!-- #dash-content -->
        </div><!-- .wrap -->
        <!-- APP FOOTER -->
        <?php include_once('footer.php');?>
        <!-- /#app-footer -->
    </main>
    <script>
        // Data for Seller Sales Comparison Pie Chart
        var sellerData = {
            labels: <?php echo json_encode($sellerNames); ?>,
            datasets: [{
                data: <?php echo json_encode($productCounts); ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        };

        // Create Seller Sales Comparison Pie Chart
        var ctx = document.getElementById('sellerSalesComparisonPieChart').getContext('2d');
        var sellerSalesComparisonPieChart = new Chart(ctx, {
            type: 'pie',
            data: sellerData,
            options: {
                legend: {
                    position: 'right',
                }
            }
        });
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
