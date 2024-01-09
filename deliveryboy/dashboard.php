<?php
// Include the database connection file
include("../connection.php");

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
    <title>Dashboard</title>
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
</head>
<body class="menubar-left menubar-unfold menubar-light theme-primary" style="background-color: white;">
    <!-- Include header and sidebar -->
    <?php include_once('header.php');?>
    <?php include_once('sidebar.php');?>
    <!-- APP MAIN ==========-->
    <main id="app-main" class="app-main">
        <div class="wrap">
            <section class="app-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="widget">
                            <header class="widget-header">
                                <h3 class="widget-title">Your Products</h3>
                            </header><!-- .widget-header -->
                            <hr class="widget-separator">
                            <div class="widget-body">
                                <div class="row">
                                    <?php if ($productResult && $productResult->num_rows > 0) { 
                                        while ($product = $productResult->fetch_assoc()) { 
                                            echo '<div class="col-md-4">
                                                <div class="widget stats-widget">
                                                    <div class="widget-body clearfix">
                                                        <h5 class="widget-title text-dark">' . $product['product_name'] . '</h5><br>
                                                        <p class="card-text"><strong>Sizes:</strong> ' . implode(', ', array_unique(explode(',', $product['sizes']))) . '<br>
                                                        <strong>Colors:</strong> ' . implode(', ', array_unique(explode(',', $product['colours']))) . '<br>
                                                        <strong>Price:</strong> Rs ' . $product['price'] . '<br>
                                                        <strong>Availability:</strong> ' . ($product['is_available'] ? 'Available' : 'Not Available') . '</p>
                                                        <p class="card-text"><a href="edit_product.php?product_id=' . $product['product_id'] . '" class="btn text-primary">Edit</a></p>
                                                    </div>
                                                </div>
                                            </div>';
                                        } 
                                    } else {
                                        echo '<div class="col-md-12 text-center">
                                            <img src="no_product.png" alt="No Products" width="300px;">
                                            <p>No products available.</p>
                                        </div>';
                                    }
                                    ?>
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
    <!--========== END app main -->
    <!-- ... (your script includes) ... -->
</body>
</html>
