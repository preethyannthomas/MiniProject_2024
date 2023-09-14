<head>
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
	<script>
		Breakpoints();
	</script>
</head>
<body>
 <?php
// Include the database connection file
include("connection.php");

// Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Handle the case when the user is not logged in
    echo "User is not logged in.";
} else {
    // Get the user ID from the session
    $user_id = $_SESSION['user_id'];

    // SQL query to fetch admin name based on user ID
    $query = "SELECT customer_name FROM tbl_customer WHERE user_id = $user_id";

    // Execute the query
    $result = $conn->query($query);

    // Check if the query was successful
    if ($result) {
        // Fetch the admin name
        $row = $result->fetch_assoc();
        $adminName = $row['customer_name'];

        // Display the admin name
        
    } else {
        // Handle the case when the query fails
        
    }
}
?>
<style>
  .black-avatar {
    filter: grayscale(100%);
            -webkit-filter: grayscale(100%);
}

</style>
<aside id="menubar" class="menubar light">
  <div class="app-user">
    <div class="media">
    <a href="javascript:void(0)">
    <img class="img-responsive black-avatar" src="assets/images/images.png" alt="avatar" style="padding-left: 10px; width: 150px;"/>
</a>

      </div>
      
      <br>         
          <h5><a href="javascript:void(0)" class="username" style = "text-align:center;"><?php echo $adminName ; ?></a></h5>
          
        
      </div><!-- .media-body -->
    </div><!-- .media -->
  </div><!-- .app-user -->

  <div class="menubar-scroll">
    <div class="menubar-scroll-inner">
      <ul class="app-menu">
        <li class="has-submenu">
          <a href="">
            <i class="menu-icon zmdi zmdi-view-dashboard zmdi-hc-lg"></i>
            <span class="menu-text">Dashboard</span>
            
          </a>
       
        </li>
       <li class="has-submenu">
          <a href="javascript:void(0)" class="submenu-toggle">
            <i class="menu-icon zmdi zmdi-pages zmdi-hc-lg"></i>
            <span class="menu-text">Analysis</span>
            <i class="menu-caret zmdi zmdi-hc-sm zmdi-chevron-right"></i>
          </a>
          <ul class="submenu">
            <li><a href="adminAddProduct.php"><span class="menu-text">Sales Analysis</span></a></li>
            <li><a href="customerAnalysis.php"><span class="menu-text">Customer Analysis</span></a></li>
          </ul>
        </li>       

        <li class="has-submenu">
          <a href="change-password.php">
            <i class="menu-icon zmdi zmdi-view-dashboard zmdi-hc-lg"></i>
            <span class="menu-text">Orders</span>
          </a>
        </li>
        
        <li class="has-submenu">
          <a href="">
            <i class="menu-icon zmdi fa fa-bank zmdi-hc-lg"></i>
            <span class="menu-text">Banking</span>
          </a>
        </li>
      </ul><!-- .app-menu -->
    </div><!-- .menubar-scroll-inner -->
  </div><!-- .menubar-scroll -->
</aside> 
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
</body>
