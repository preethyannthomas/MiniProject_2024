<?php
// Include the database connection file
include("../connection.php");
session_start();
if (!isset($_SESSION['user_id'])) {
    header('location:./');
    exit();
}

// Function to fetch seller data from the database
function fetchSeller($conn, $sellerId) {
    $query = "SELECT s.seller_id, s.seller_name, s.contact_no, u.email, a.address, a.area, a.city, a.state, a.pincode
    FROM tbl_seller s
    INNER JOIN tbl_user u ON s.user_id = u.user_id
    LEFT JOIN tbl_address a ON s.user_id = a.user_id
    WHERE s.seller_id = $sellerId";

    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row;
    } else {
        echo "Seller not found.";
        return null;
    }
}

// Function to fetch products added by the seller and the number of items sold
function fetchSellerProducts($conn, $sellerId) {
    $query = "SELECT p.product_id, p.product_name, p.price, IFNULL(SUM(od.quantity), 0) AS items_sold
    FROM tbl_product p
    LEFT JOIN tbl_orderdetail od ON p.product_id = od.product_id
    WHERE p.seller_id = $sellerId
    GROUP BY p.product_id";

    $result = $conn->query($query);

    $sellerProducts = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $sellerProducts[] = $row;
        }
    }

    return $sellerProducts;
}

// Get the seller ID from the URL or any other source
$sellerId = isset($_GET['id']) ? intval($_GET['id']) : null;

if (!$sellerId) {
    echo "Invalid seller ID.";
    exit();
}

// Fetch seller data
$seller = fetchSeller($conn, $sellerId);

if (!$seller) {
    exit();
}

// Fetch products added by the seller and the number of items sold
$sellerProducts = fetchSellerProducts($conn, $sellerId);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Seller</title>
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
    <style>
        .product-row {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .table th, .table td {
            vertical-align: middle;
        }
    </style>
</head>
<body class="menubar-left menubar-unfold menubar-light theme-primary">
<!-- Start main area -->

<?php include_once('header.php');?>

<?php include_once('sidebar.php');?>
<main id="app-main" class="app-main">
    <div class="wrap">
        <section class="app-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="widget">
                        <header class="widget-header">
                            <h3 class="widget-title"><?php echo $seller['seller_name']; ?></h3>
                        </header>
                        <hr class="widget-separator">
                        <div class="widget-body">
                            <div class="container">
                                <p><strong>Contact No:&emsp;&emsp;&emsp;</strong> <?php echo $seller['contact_no']; ?></p>
                                <p><strong>Email:&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</strong> <?php echo $seller['email']; ?></p>
                                <p><strong>Address:&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;</strong> <?php echo $seller['address']; ?></p>
                                <p>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;<?php echo $seller['area']; ?></p>
                                <p>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;<?php echo $seller['city'] . ', ' . $seller['state']; ?></p>
                                <p>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;<?php echo $seller['pincode']; ?></p>
                                <br>
                                <strong>Sales History</strong><br><br>
                                <?php if (!empty($sellerProducts)): ?>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>SI No</th>
                                                <th>Product Name</th>
                                                <th>Price</th>
                                                <th>Number of Items Sold</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $siNo = 1; ?>
                                            <?php foreach ($sellerProducts as $product): ?>
                                                <tr>
                                                    <td><?php echo $siNo; ?></td>
                                                    <td><?php echo $product['product_name']; ?></td>
                                                    <td><?php echo $product['price']; ?></td>
                                                    <td><?php echo $product['items_sold']; ?></td>
                                                </tr>
                                                <?php $siNo++; ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php else: ?>
                                    <p>No products added by this seller.</p>
                                <?php endif; ?>
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
