<?php
// Include the database connection file
include("../connection.php");
session_start();
if (!isset($_SESSION['user_id'])) {
    header('location:./');
    exit();
}

// Function to fetch customer data from the database
function fetchCustomer($conn, $customerId) {
    $query = "SELECT c.customer_id, c.customer_name, c.contact_no, u.email
    FROM tbl_customer c
    INNER JOIN tbl_user u ON c.user_id = u.user_id
    WHERE c.customer_id = $customerId";

    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row;
    } else {
        echo "Customer not found.";
        return null;
    }
}

// Function to fetch customer's address
function fetchAddresses($conn, $customerId) {
    $query = "SELECT * FROM tbl_address WHERE user_id = $customerId";
    $result = $conn->query($query);

    $addresses = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $addresses[] = $row;
        }
    }

    return $addresses;
}

// Function to fetch customer's order history
function fetchOrderHistory($conn, $customerId) {
    $query = "SELECT o.order_id, o.order_date, p.product_name, o.total_amount, o.status
    FROM tbl_order o
    INNER JOIN tbl_orderdetail od ON o.order_id = od.order_id
    INNER JOIN tbl_product p ON od.product_id = p.product_id
    WHERE o.customer_id = $customerId";

    $result = $conn->query($query);

    $orderHistory = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $orderHistory[] = $row;
        }
    }

    return $orderHistory;
}

// Get the customer ID from the URL or any other source
$customerId = isset($_GET['id']) ? intval($_GET['id']) : null;

if (!$customerId) {
    echo "Invalid customer ID.";
    exit();
}

// Fetch customer data
$customer = fetchCustomer($conn, $customerId);

if (!$customer) {
    exit();
}

// Fetch customer's addresses
$addresses = fetchAddresses($conn, $customerId);

// Fetch customer's order history
$orderHistory = fetchOrderHistory($conn, $customerId);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Customer</title>
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
                            <h3 class="widget-title"><?php echo $customer['customer_name']; ?></h3>
                        </header>
                        <hr class="widget-separator">
                        <div class="widget-body">
                            <div class="container">
                                <p><strong>Contact No:&emsp;&emsp;&emsp;</strong> <?php echo $customer['contact_no']; ?></p>
                                <p><strong>Email:&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</strong> <?php echo $customer['email']; ?></p>
                                <?php if (!empty($addresses)): ?>
                                    <?php foreach ($addresses as $address): ?>
                                        <p><strong>Address:&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;</strong> <?php echo $address['address']; ?></p>
                                        <p>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;<?php echo $address['area']; ?></p>
                                        <p>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;<?php echo $address['city'] . ', ' . $address['state']; ?></p>
                                        <p>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;<?php echo $address['pincode']; ?></p>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p>No addresses available.</p>
                                <?php endif; ?>
                                    <br>
                                <strong>Order History</strong><br><br>
                                <?php if (!empty($orderHistory)): ?>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Product Name</th>
                                                <th>Order Date</th>
                                                <th>Total Amount</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($orderHistory as $order): 
                                                 $statusClass = 'status-pending'; // Default status class
                                                 if ($order['status'] === 'Shipped') {
                                                     $statusClass = 'status-shipped';
                                                 } elseif ($order['status'] === 'Delivered') {
                                                     $statusClass = 'status-delivered';
                                                 }
                                            ?>
                                                <tr>
                                                    <td><?php echo $order['order_id']; ?></td>
                                                    <td><?php echo $order['product_name']; ?></td>
                                                    <td><?php echo $order['order_date']; ?></td>
                                                    <td><?php echo $order['total_amount']; ?></td>
                                                    <td>
                                                    <button class="status-button <?php echo $statusClass; ?>">
                    <?php echo ucfirst($order['status']); ?>
                </button>        
                                                </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php else: ?>
                                    <p>No order history available.</p>
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
