<!-- PHP Code -->
<?php
// Include the database connection file
include("../connection.php");

session_start();
if (!isset($_SESSION['user_id'])) {
    header('location:./');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user information from tbl_user
$userQuery = "SELECT email FROM tbl_user WHERE user_id = $user_id";
$userResult = $conn->query($userQuery);

if ($userResult->num_rows == 1) {
    $userRow = $userResult->fetch_assoc();
}

// Fetch company information from tbl_admin
$companyQuery = "SELECT * FROM tbl_admin WHERE user_id = $user_id";
$companyResult = $conn->query($companyQuery);

if ($companyResult->num_rows == 1) {
    $companyRow = $companyResult->fetch_assoc();
}

// Fetch address details from tbl_address
$addressQuery = "SELECT * FROM tbl_address WHERE user_id = $user_id";
$addressResult = $conn->query($addressQuery);

if ($addressResult->num_rows == 1) {
    $addressRow = $addressResult->fetch_assoc();
}else {
    // Address not present, set default values
    $addressRow = [
        'address' => '',
        'area' => '',
        'city' => '',
        'state' => '',
        'pincode' => '',
        'mobile_number' => '',
    ];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Customer Analysis</title>
    <link rel="stylesheet" href="../libs/bower/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="../libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.css">
  <!-- build:css assets/css/app.min.css -->
  <link rel="stylesheet" href="../libs/bower/animate.css/animate.min.css">
  <link rel="stylesheet" href="../libs/bower/fullcalendar/dist/fullcalendar.min.css">
  <link rel="stylesheet" href="../libs/bower/perfect-scrollbar/css/perfect-scrollbar.css">
  <link rel="stylesheet" href="../assets/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/css/core.css">
  <link rel="stylesheet" href="../assets/css/app.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
</head>
<body class="menubar-left menubar-unfold menubar-light theme-primary">
<!--============= start main area -->

<?php include_once('header.php');?>

<?php include_once('sidebar.php');?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6">
                <!-- Monthly Analysis Chart -->
                <h3>Monthly Analysis</h3>
                <canvas id="monthlyAnalysisChart"></canvas>
            </div>
            <div class="col-md-6">
                <!-- Quarterly Analysis Line Chart -->
                <h3>Quarterly Analysis (Line Chart)</h3>
                <canvas id="quarterlyAnalysisChart" width="400" height="200"></canvas>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <!-- Yearly Analysis Chart -->
                <h3>Yearly Analysis</h3>
                <canvas id="yearlyAnalysisChart"></canvas>
            </div>
            <div class="col-md-6">
                <!-- Product Analysis (Pie Chart) -->
                <h3>Product Analysis</h3>
                <canvas id="productAnalysisChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        // Sample data for Monthly Analysis
        const monthlyData = {
            labels: ["January", "February", "March", "April", "May"],
            datasets: [{
                label: "Number of Customers",
                backgroundColor: "rgba(75, 192, 192, 0.2)",
                borderColor: "rgba(75, 192, 192, 1)",
                borderWidth: 1,
                data: [150, 200, 180, 220, 250],
            }],
        };

        // Sample data for Quarterly Analysis (Line Chart)
        const quarterlyData = {
            labels: ["Q1", "Q2", "Q3", "Q4"],
            datasets: [{
                label: "Number of Customers",
                borderColor: "rgba(255, 99, 132, 1)",
                borderWidth: 2,
                fill: false,
                data: [300, 450, 400, 350],
            }],
        };

        // Sample data for Yearly Analysis
        const yearlyData = {
            labels: ["2021", "2022", "2023"],
            datasets: [{
                label: "Number of Customers",
                backgroundColor: "rgba(54, 162, 235, 0.2)",
                borderColor: "rgba(54, 162, 235, 1)",
                borderWidth: 1,
                data: [1500, 1800, 2100],
            }],
        };

        // Sample data for Product Analysis (Pie Chart)
        const productData = {
            labels: ["Product A", "Product B", "Product C"],
            datasets: [{
                data: [30, 45, 25],
                backgroundColor: ["#FF5733", "#33FF57", "#3357FF"],
            }],
        };

        // Function to create a chart
        function createChart(canvasId, chartType, chartData) {
            const ctx = document.getElementById(canvasId).getContext("2d");
            return new Chart(ctx, {
                type: chartType,
                data: chartData,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                        },
                    },
                },
            });
        }

        // Create all four charts
        createChart("monthlyAnalysisChart", "bar", monthlyData);
        createChart("quarterlyAnalysisChart", "line", quarterlyData);
        createChart("yearlyAnalysisChart", "bar", yearlyData);
        createChart("productAnalysisChart", "pie", productData);
    </script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
