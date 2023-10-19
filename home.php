<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("connection.php");

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM tbl_customer WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $userDetails = mysqli_fetch_assoc($result);
        $name = $userDetails['customer_name'];
    }
    

    $query = "SELECT * FROM tbl_user WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $userDetails = mysqli_fetch_assoc($result);
        $email = $userDetails['email'];
      
    } 
 
} else {
 
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap"
        rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

    <title>SwapZone Home</title>
    <link rel="icon" href="images/logo.png">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.css">
    <link rel="stylesheet" href="css/templatemo-hexashop.css">
    <link rel="stylesheet" href="css/owl-carousel.css">
    <link rel="stylesheet" href="css/lightbox.css">
</head>
<style>
    body{
        background-image:url('images/backgroundAddress.jpg');
    }
</style>

<body>

<header class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <a href="index.html" class="logo">
                            <img src="images/logo.png">
                        </a>
                       
                        <ul class="nav">
                            <li class="scroll-to-section"><a href="productList.php?category_id=4">Home</a></li>
                            <li class="scroll-to-section"><a href="productList.php?category_id=1">Men</a></li>
                            <li class="scroll-to-section"><a href="productList.php?category_id=2">Women</a></li>
                            <li class="scroll-to-section"><a href="productList.php?category_id=3">Kids</a></li>
                            <li>
                                <form method="GET" class="form-inline ml-3">
                                    <div class="input-group">
                                        <input type="text" placeholder="Search for products" id = "search" name="search_query">
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary" id = "searchbutton" type="submit"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                                
                            </li>

                            <li class="submenu" id="#updateProfile" onclick="updateProfile()">
                                <a href="#paymentCycle"><i class="fas fa-user"></i></a>
                                <ul>
                                    <li><a href="profile.php">Your Profile</a></li>
                                    <li><a href="cart_display.php">Cart</a></li>
                                    <li><a href="wishList.php">Wishlist</a></li>
                                    <li><a href="#fees">Orders</a></li>
                                    <li><a href="logout.php">Log Out</a></li>
                                </ul>
                            </li>
                        </ul>
                        <a class='menu-trigger'>
                            <span>Menu</span>
                        </a>
                        <!-- ***** Menu End ***** -->
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- Rest of your HTML content -->
    <div id="product-list"></div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Handle form submission via AJAX
            $("form").submit(function(e) {
                e.preventDefault(); // Prevent the form from submitting in the traditional way
                var searchQuery = $("input[name='search_query']").val(); // Get the search query
                $.ajax({
                    type: "GET",
                    url: "search_products.php", // Create a new PHP file for handling the search logic
                    data: { search_query: searchQuery }, // Pass the search query to the server
                    success: function(response) {
                        // Check if the response contains search results
                        if (response.trim() === "") {
                            // If no results, replace the entire body content with an image
                            $("section").html('<img src="../images/no_product.gif" alt="No Products" width="700px" height="700px">');
                        } else {
                            // Replace the product list with the search results
                            $("#product-list").html(response);
                        }
                    }
                });
            });
        });
    </script>
    <section id  = "updateProfile">
    <?php 
    $_GET['category_id'] = 4; 
    include('productList.php'); 
    ?>
    </section>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <script src="js/jquery-2.1.0.min.js"></script>

 
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>


    <script src="js/owl-carousel.js"></script>
    <script src="js/accordions.js"></script>
    <script src="js/datepicker.js"></script>
    <script src="js/scrollreveal.min.js"></script>
    <script src="js/waypoints.min.js"></script>
    <script src="js/jquery.counterup.min.js"></script>
    <script src="js/imgfix.min.js"></script>
    <script src="js/slick.js"></script>
    <script src="js/lightbox.js"></script>
    <script src="js/isotope.js"></script>

    <script src="js/custom.js"></script>

    <script>

        $(function () {
            var selectedClass = "";
            $("p").click(function () {
                selectedClass = $(this).attr("data-rel");
                $("#portfolio").fadeTo(50, 0.1);
                $("#portfolio div").not("." + selectedClass).fadeOut();
                setTimeout(function () {
                    $("." + selectedClass).fadeIn();
                    $("#portfolio").fadeTo(50, 1);
                }, 500);

            });
        });

    </script>
    <script>
    $(document).ready(function() {
        $(".category-button").on("click", function() {
            var category = $(this).data("category");
            window.location.href = "product_list.php?category=" + category;
        });
    });
</script>


</body>

</html>