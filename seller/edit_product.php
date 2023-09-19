<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <link rel="stylesheet" href="../libs/bower/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.css">
    <link rel="stylesheet" href="../libs/bower/animate.css/animate.min.css">
    <link rel="stylesheet" href="../libs/bower/fullcalendar/dist/fullcalendar.min.css">
    <link rel="stylesheet" href="../libs/bower/perfect-scrollbar/css/perfect-scrollbar.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/core.css">
    <link rel="stylesheet" href="../assets/css/app.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">
    <script src="../libs/bower/breakpoints.js/dist/breakpoints.min.js"></script>
    <script>
        Breakpoints();
    </script>
    <style>
      #img2{
        height: 200px;
      }
    </style>
</head>
<body class="menubar-left menubar-unfold menubar-light theme-primary" style="background-color: white">

<?php
include("../connection.php");

// Start the PHP session
session_start();
include_once('header.php');
include_once('sidebar.php');
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['product_id'])) {
    // Get product_id from the GET request
    $product_id = $_GET['product_id'];

    // Retrieve product details from tbl_product and tbl_productdescription
    $productQuery = "SELECT p.*, pd.colour, pd.usage_description, pd.weight, pd.care_instruction, pd.material, pd.dimension
                     FROM tbl_product p
                     INNER JOIN tbl_productdescription pd ON p.product_id = pd.product_id
                     WHERE p.product_id = '$product_id'";
    $productResult = $conn->query($productQuery);

    if ($productResult->num_rows == 1) {
        $productRow = $productResult->fetch_assoc();
        $name = $productRow["product_name"];
        $category_id = $productRow["subcategory_id"];  // Assuming subcategory_id is stored as category_id here
        $price = $productRow["price"];
        $is_available = $productRow["is_available"];
        $colour = $productRow["colour"];
        $usageDescription = $productRow["usage_description"];
        $weight = $productRow["weight"];
        $careInstruction = $productRow["care_instruction"];
        $material = $productRow["material"];
        $dimension = $productRow["dimension"];

        // Retrieve category_name and subcategory_name based on category_id
        $categoryQuery = "SELECT c.category_name, s.subcategory_name
                          FROM tbl_category c
                          INNER JOIN tbl_subcategory s ON c.category_id = s.category_id
                          WHERE s.subcategory_id = '$category_id'";
        $categoryResult = $conn->query($categoryQuery);

        if ($categoryResult->num_rows == 1) {
            $categoryRow = $categoryResult->fetch_assoc();
            $category_name = $categoryRow["category_name"];
            $subcategory_name = $categoryRow["subcategory_name"];

            // Display the product information in a form for editing
            echo ' <main id="app-main" class="app-main">
            <div class="wrap">
                <section class="app-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="widget">
                                <header class="widget-header">
                                    <h3 class="widget-title">Update Product</h3>
                                </header>
                                <hr class="widget-separator">
                                <div class="widget-body">
                                    <div class="row">
                                    
                                    <div class="container mt-4">
                    <br><br><br><br>
                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <form method="post" action="update_product.php"> <!-- Create update_product.php for handling form submission -->
                                <input type="hidden" name="product_id" value="' . $product_id . '">
                                <div class="form-group">
                                    <label for="name">Product Name:</label>
                                    <input type="text" class="form-control" id="name" name="name" value="' . $name . '">
                                </div>
                                <div class="form-group">
                                    <label for="category">Category:</label>
                                    <input type="text" class="form-control" id="category" name="category" value="' . $category_name . '" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="subcategory">Subcategory:</label>
                                    <input type="text" class="form-control" id="subcategory" name="subcategory" value="' . $subcategory_name . '" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="material">Material:</label>
                                    <input type="text" class="form-control" id="material" name="material" value="' . $material . '">
                                </div>
                                <div class="form-group">
                                    <label for="dimension">Dimension:</label>
                                    <input type="text" class="form-control" id="dimension" name="dimension" value="' . $dimension . '">
                                </div>
                                <div class="form-group">
                                    <label for="weight">Weight:</label>
                                    <input type="text" class="form-control" id="weight" name="weight" value="' . $weight . '">
                                </div>
                                <div class="form-group">
                                    <label for="usageDescription">Usage Description:</label>
                                    <textarea class="form-control" id="usageDescription" name="usageDescription">' . $usageDescription . '</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="careInstruction">Care Instruction:</label>
                                    <textarea class="form-control" id="careInstruction" name="careInstruction">' . $careInstruction . '</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="price">Price:</label>
                                    <input type="number" class="form-control" id="price" name="price" value="' . $price . '">
                                </div>
                                <div class="form-group">
                                    <label for="colour">Colour:</label>
                                    <input type="text" class="form-control" id="colour" name="colour" value="' . $colour . '">
                                </div>
                                <div class="form-group">
                                    <label for="isAvailable">Is Available:</label>
                                    <input type="checkbox" class="form-check-input" id="isAvailable" name="isAvailable" value="1" ' . ($is_available ? 'checked' : '') . '>
                                </div>
                                <button type="submit" class="btn btn-primary" name="submit">Update Product</button>
                            </form>
                        </div>
                    </div>
                </div> </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
include_once('footer.php');
</main>';
        } else {
            echo "Invalid category or subcategory.";
        }
    } else {
        echo "Invalid product ID.";
    }
} else {
    echo "Product ID not provided.";
}

// Close the database connection
$conn->close();
?>
<script src="../libs/bower/jquery/dist/jquery.js"></script>
    <script src="../libs/bower/jquery-ui/jquery-ui.min.js"></script>
    <script src="../libs/bower/jQuery-Storage-API/jquery.storageapi.min.js"></script>
    <script src="../libs/bower/bootstrap-sass/assets/javascripts/bootstrap.js"></script>
    <script src="../libs/bower/jquery-slimscroll/jquery.slimscroll.js"></script>
    <script src="../libs/bower/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
    <script src="../libs/bower/PACE/pace.min.js"></script>
    <script src="../assets/js/library.js"></script>
    <script src="../assets/js/plugins.js"></script>
    <script src="../assets/js/app.js"></script>
    <script src="../libs/bower/moment/moment.js"></script>
    <script src="../libs/bower/fullcalendar/dist/fullcalendar.min.js"></script>
    <script src="../assets/js/fullcalendar.js"></script>
</body>
</html>
