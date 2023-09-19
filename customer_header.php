<!DOCTYPE html>
<html>
<head>
    <title>SwapZone</title>
    <link rel="icon" href="images/logo.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/font-awesome.css">
    <link rel="stylesheet" href="css/templatemo-hexashop.css">
    <link rel="stylesheet" href="css/owl-carousel.css">
    <link rel="stylesheet" href="css/lightbox.css">
</head>
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
                                        <input type="text" placeholder="Search for products" name="search_query">
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary" type="submit"><i class="fas fa-search"></i></button>
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
</body>
</html>
