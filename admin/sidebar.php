<?php
// Include the database connection file
include("../connection.php");

// Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Handle the case when the user is not logged in
    echo "User is not logged in.";
} else {
    // Get the user ID from the session
    $user_id = $_SESSION['user_id'];

    // SQL query to fetch admin name based on user ID
    $query = "SELECT admin_name FROM tbl_admin WHERE user_id = $user_id";

    // Execute the query
    $result = $conn->query($query);

    // Check if the query was successful
    if ($result) {
        // Fetch the admin name
        $row = $result->fetch_assoc();
        $adminName = $row['admin_name'];

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
    <img class="img-responsive black-avatar" src="../assets/images/images.png" alt="avatar" style="padding-left: 10px; width: 150px;"/>
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
          <a href="adminProfile.php">
            <i class="menu-icon zmdi zmdi-view-dashboard zmdi-hc-lg"></i>
            <span class="menu-text">Dashboard</span>
            
          </a>
       
        </li>
        <li class="has-submenu">
          <a href="javascript:void(0)" class="submenu-toggle">
            <i class="menu-icon zmdi zmdi-pages zmdi-hc-lg"></i>
            <span class="menu-text">User Profile</span>
            <i class="menu-caret zmdi zmdi-hc-sm zmdi-chevron-right"></i>
          </a>
          <ul class="submenu">
            <li><a href="sellerProfile.php"><span class="menu-text">Seller</span></a></li>
            <li><a href="customerProfile.php"><span class="menu-text">Customer</span></a></li>
          </ul>
        </li>  
       <li class="has-submenu">
          <a href="javascript:void(0)" class="submenu-toggle">
            <i class="menu-icon zmdi zmdi-pages zmdi-hc-lg"></i>
            <span class="menu-text">Analysis</span>
            <i class="menu-caret zmdi zmdi-hc-sm zmdi-chevron-right"></i>
          </a>
          <ul class="submenu">
            <li><a href="salesAnalysis.php"><span class="menu-text">Sales Analysis</span></a></li>
            <li><a href="customerAnalysis.php"><span class="menu-text">Product Analysis</span></a></li>
          </ul>
        </li>       

        <li class="has-submenu">
          <a href="order.php">
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