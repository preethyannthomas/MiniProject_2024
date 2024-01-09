<?php
// Include the database connection file
include("../connection.php");

// Fetch seller's products from tbl_product
session_start();
if (!isset($_SESSION['user_id'])) {
    header('location:./');
    exit();
}

?>
<?php
// Include the database connection file
include("../connection.php");

// Function to fetch data from the database and return it as an associative array
function fetchData($conn, $query) {
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

// Fetch data for Product Sales Analysis by Category
$categoryQuery = "SELECT c.category_name, SUM(od.quantity) AS total_sold
                 FROM tbl_category c
                 LEFT JOIN tbl_subcategory s ON c.category_id = s.category_id
                 LEFT JOIN tbl_product p ON s.subcategory_id = p.subcategory_id
                 LEFT JOIN tbl_orderdetail od ON p.product_id = od.product_id
                 GROUP BY c.category_name";
$categoryData = fetchData($conn, $categoryQuery);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Sales Analysis</title>
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
                                <h3 class="widget-title">Total Purchases</h3>
                            </header><!-- .widget-header -->
                            <hr class="widget-separator">
                            <div class="widget-body">
                                <div class="row">
    <div class="container">
        <!-- Product Sales Analysis Pie Chart -->
        <div class="chart-container">
        <canvas id="categorySalesChart"></canvas>
        </div>
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
        // Create a function to generate a chart
        function createChart(canvasId, chartType, data) {
            var ctx = document.getElementById(canvasId).getContext('2d');
            var myChart = new Chart(ctx, {
                type: chartType,
                data: data
            });
        }

        // Data for Product Sales Analysis by Category Pie Chart
        var categoryData = {
            labels: <?php echo json_encode(array_column($categoryData, 'category_name')); ?>,
            datasets: [{
                data: <?php echo json_encode(array_column($categoryData, 'total_sold')); ?>,
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

        // Create Product Sales Analysis by Category Pie Chart
        createChart("categorySalesChart", "pie", categoryData);
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
