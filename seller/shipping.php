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

?>
<?php
// Function to fetch shipped orders for sellers
function fetchShippedOrders($conn) {
    $query = "SELECT p.product_name, pd.colour, pdetail.size, pdetail.stock, c.customer_name, c.contact_no
              FROM tbl_product p
              INNER JOIN tbl_productdescription pd ON p.product_id = pd.product_id
              INNER JOIN tbl_productdetail pdetail ON p.product_id = pdetail.product_id
              INNER JOIN tbl_customer c ON p.seller_id = c.user_id
              WHERE pdetail.is_available = 1 AND pdetail.stock = 0";

    $result = $conn->query($query);

    if ($result) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        echo "Error executing query: " . $conn->error;
        return [];
    }
}

// Fetch shipped orders
$shippedOrders = fetchShippedOrders($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  
  <title>Change Password</title>
  
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
        .eye-catching-table {
            border-collapse: collapse;
            width: 100%;
        }
        .eye-catching-table th, .eye-catching-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        .eye-catching-table th {
            background-color: #f2f2f2;
        }
        .eye-catching-table tr:hover {
            background-color: #f5f5f5;
        }
    </style>
  <script type="text/javascript">
function checkpass()
{
if(document.changepassword.newpassword.value!=document.changepassword.confirmpassword.value)
{
alert('New Password and Confirm Password field does not match');
document.changepassword.confirmpassword.focus();
return false;
}
return true;
}   

</script>
</head>
  
<body class="menubar-left menubar-unfold menubar-light theme-primary">
<!--============= start main area -->

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
            <h3 class="widget-title">Shipped Products</h3>
          </header><!-- .widget-header -->
          <hr class="widget-separator">
          <div class="widget-body">
            
            <form class="form-horizontal">
            <div class="container mt-4">
    
        <table class="eye-catching-table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Color</th>
                    <th>Size</th>
                    <th>Stock</th>
                    <th>Customer Name</th>
                    <th>Contact No</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($shippedOrders as $order) : ?>
                    <tr>
                        <td><?php echo $order['product_name']; ?></td>
                        <td><?php echo $order['colour']; ?></td>
                        <td><?php echo $order['size']; ?></td>
                        <td><?php echo $order['stock']; ?></td>
                        <td><?php echo $order['customer_name']; ?></td>
                        <td><?php echo $order['contact_no']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
            </form>
          </div><!-- .widget-body -->
        </div><!-- .widget -->
      </div><!-- END column -->

    </div><!-- .row -->
  </section><!-- #dash-content -->
</div><!-- .wrap -->
  <!-- APP FOOTER -->
  <br><br><br><br>
  <?php include_once('footer.php');?>
  <!-- /#app-footer -->
</main>
  <!-- SIDE PANEL -->
 

  <!-- build:js assets/js/core.min.js -->
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
