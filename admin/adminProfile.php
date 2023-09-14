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

<!-- APP MAIN ==========-->
<main id="app-main" class="app-main">
  <div class="wrap">
    <section class="app-content">
      <div class="row">
        <div class="col-md-12">
          <div class="widget">
            <header class="widget-header">
              <h3 class="widget-title">My Profile</h3>
            </header><!-- .widget-header -->
            <hr class="widget-separator">
            <div class="widget-body">
              <div class="row">
              <div class="col-md-6">
                  <div class="widget">
                    <header class="widget-header">
                      <h3 class="widget-title">Company Details</h3>
                    </header><!-- .widget-header -->
                    <div class="widget-body">
                    <div class="row">
        <div class="col-md-6">
            <p><strong>Name:</strong></p>
            <p><strong>Email:</strong></p><br><br>
        </div>
        <div class="col-md-6">
            <p><?php echo $companyRow['admin_name']; ?></p>
            <p><?php echo $userRow['email']; ?></p>
        </div>
</div><br><br>
                      <!-- Add more company details here -->
                    </div><!-- .widget-body -->
                </div><!-- .widget -->
                </div><!-- END column -->


                <div class="col-md-6">
                  <div class="widget">
                    <header class="widget-header">
                      <h3 class="widget-title">Communication Details</h3>
                    </header><!-- .widget-header -->
                    <div class="widget-body">
                    <div class="row">
        <div class="col-md-6">
            <p><strong>Address:</strong></p>
            <br> <br>
            <p><strong>Mobile Number:</strong></p>
        </div>
        <div class="col-md-6">
            <p><?php echo $addressRow['address']; ?></p>
            <p><?php echo $addressRow['area']; ?></p>
            <p><?php echo $addressRow['pincode']; ?> , <?php echo $addressRow['state']; ?></p>
            <p><?php echo $addressRow['mobile_number']; ?></p>
        </div>
</div>
                    <p><strong></strong> </p>
                    <p><strong></strong> </p>
                      <!-- Add more personal details here -->
                      <a href="edit_communication_details.php" class="btn text-primary">Edit </a>
                    </div><!-- .widget-body -->
                  </div><!-- .widget -->
                </div><!-- END column -->
              </div><!-- .row -->
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

<!--========== END app main -->

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
