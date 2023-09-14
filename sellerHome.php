<?php
// Include the database connection file
include("connection.php");

// Fetch seller's products from tbl_product
session_start();
if (!isset($_SESSION['user_id'])) {
    header('location:./');
    exit();
}

$user_id = $_SESSION['user_id'];

$productQuery = "SELECT p.product_id, p.product_name, p.price, p.is_available, GROUP_CONCAT(pd.colour) AS colours, GROUP_CONCAT(pd.size) AS sizes
                FROM tbl_product AS p
                LEFT JOIN tbl_productdetail AS pd ON p.product_id = pd.product_id
                WHERE p.seller_id = (SELECT seller_id FROM tbl_seller WHERE user_id = $user_id)
                GROUP BY p.product_id";
$productResult = $conn->query($productQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard</title>
    <link rel="stylesheet" href="libs/bower/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.css">
	<!-- build:css assets/css/app.min.css -->
	<link rel="stylesheet" href="libs/bower/animate.css/animate.min.css">
	<link rel="stylesheet" href="libs/bower/fullcalendar/dist/fullcalendar.min.css">
	<link rel="stylesheet" href="libs/bower/perfect-scrollbar/css/perfect-scrollbar.css">
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/core.css">
	<link rel="stylesheet" href="assets/css/app.css">
	<!-- endbuild -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">
	<script src="libs/bower/breakpoints.js/dist/breakpoints.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Custom CSS for the fixed header */
        .fixed-top-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background-color: #fff;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
            z-index: 1030; /* Make sure it's above the sidebar */
        }

        /* Custom CSS for the sidebar */
        #sidebar {
            height: 100vh;
            width: 250px; /* Increase width */
            position: fixed;
            top: 70px; /* Adjust this to match the header height */
            left: -250px;
            transition: all 0.3s;
            z-index: 1029; /* Below the fixed header */
            border-right: 1px solid #ccc; /* Add a border to separate sidebar from content */
            background-color: #fff; /* Background color */
            color: #000; /* Text color */
            padding-left: 15px;
        }

        #sidebar.active {
            left: 0;
        }

        #sidebar ul {
            list-style: none;
            padding: 0;
        }

        #sidebar ul li {
            padding: 4px;
        }

        /* Custom CSS for the navigation icon */
        #sidebarCollapse {
            position: fixed;
            left: 43px; /* Adjust the left position as needed */
            top: 15px;
            cursor: pointer;
            z-index: 1031; /* Above everything */
            background-color: transparent; /* Background color */
            color: #000 !important; /* Icon color */
            border: none; /* Remove border */
            outline: none ; /* Remove outline */
            padding: 0;
        }

        /* Remove button outline */
        #sidebarCollapse:active,
        #sidebarCollapse:focus {
            outline: none ;
        }

        /* Custom CSS for the content area */
        #content {
            margin-left: 0;
            transition: all 0.3s;
            padding-left: 270px; /* Adjust padding to match sidebar width */
        }

        /* Highlight active link */
        #sidebar ul li.active a {
            color: blue; /* Active link text color */
        }

        #sidebar ul li a {
            color: #000; /* Link text color */
            text-decoration: none;
        }
    </style>
</head>
<body>
    <header class="fixed-top-header">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand" href="#">
                &emsp;&emsp;&emsp;&emsp;
                <img src="images/logo.png" alt="Logo" width="200">
            </a>
        </nav>
    </header>
    <?php include_once('sidebar.php');?>
    <div id="content">
        <button id="sidebarCollapse" class="btn">
            <i class="fas fa-bars"></i>
        </button>
        <main class="p-4"><br><br><br>

            <div class="row">
                <!-- Card for adding a new product -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <a href="sellerAddProduct.php" class="btn text-primary"><img src="images/addCloth.png" alt="" style = "height: 218px; width:330px;"></a>
                        </div>
                    </div>
                </div>

                <!-- Loop through and display seller's products -->
                <?php while ($product = $productResult->fetch_assoc()) { ?>
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $product['product_name']; ?></h5>
                                <!-- Display product-specific content here -->

                                <!-- Sizes -->
                                <p class="card-text"><strong>Sizes:</strong> <?php echo implode(', ', array_unique(explode(',', $product['sizes']))); ?></p>

                                <!-- Colors -->
                                <p class="card-text"><strong>Colors:</strong> <?php echo implode(', ', array_unique(explode(',', $product['colours']))); ?></p>

                                <!-- Additional product information -->
                                <p class="card-text"><strong>Price:</strong> Rs <?php echo $product['price']; ?></p>
                                <p class="card-text"><strong>Availability:</strong> <?php echo ($product['is_available'] ? 'Available' : 'Not Available'); ?></p>

                                <!-- Add an edit button to edit this product -->
                                <a href="edit_product.php?product_id=<?php echo $product['product_id']; ?>" class="btn text-primary">Edit</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

        </main>
    </div>

    <!-- Include Bootstrap and jQuery JavaScript -->
    <script src="libs/bower/jquery/dist/jquery.js"></script>
	<script src="libs/bower/jquery-ui/jquery-ui.min.js"></script>
	<script src="libs/bower/jQuery-Storage-API/jquery.storageapi.min.js"></script>
	<script src="libs/bower/bootstrap-sass/assets/javascripts/bootstrap.js"></script>
	<script src="libs/bower/jquery-slimscroll/jquery.slimscroll.js"></script>
	<script src="libs/bower/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
	<script src="libs/bower/PACE/pace.min.js"></script>
	<!-- endbuild -->

	<!-- build:js assets/js/app.min.js -->
	<script src="assets/js/library.js"></script>
	<script src="assets/js/plugins.js"></script>
	<script src="assets/js/app.js"></script>
	<!-- endbuild -->
	<script src="libs/bower/moment/moment.js"></script>
	<script src="libs/bower/fullcalendar/dist/fullcalendar.min.js"></script>
	<script src="assets/js/fullcalendar.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Font Awesome for the navigation icon -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

    <script>
        $(document).ready(function() {
            // Show/hide sidebar on button click
            $("#sidebarCollapse").click(function() {
                $("#sidebar").toggleClass("active");
                $("#content").toggleClass("active");
            });
        });
    </script>
</body>
</html>
