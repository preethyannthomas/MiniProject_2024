<!DOCTYPE html>
<html>
<head>
    <title>Product List</title>
    <!-- Include your CSS stylesheets and other head content here -->
</head>
<body>
<?php
session_start();
include('connection.php');
include('customer_header.php');
?>

<div class="container mt-4">
    <br><br><br><br>
    <div class="row" id="product-list">
        <?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('location:./');
        }
        include("connection.php"); 
        
        // Check if search query parameters are set
        if (isset($_GET['search_query'])) {
            $search_query = $_GET['search_query'];
            
            
            // Define the SQL query to search for products based on name and color
            $sql = "SELECT p.*, pd.colour
            FROM tbl_product p
            INNER JOIN tbl_productdescription pd ON p.product_id = pd.product_id
            WHERE (p.product_name LIKE '%$search_query%' OR pd.colour LIKE '%$search_query%')
            ORDER BY p.product_name";
        } else {
            // Default query if no search parameters are provided
            $sql = 'SELECT * FROM tbl_product';
        }
        
        $result = $conn->query($sql);
        
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                // Display product information here as before
                echo '<div class="col-md-4 ">
                        <div class="card mb-4 shadow-sm">
                        <img src="data:image/jpeg;base64,' . base64_encode($row['image']) . '" class="card-img-top" alt="' . $row['product_name'] . '">
                            <div class="card-body">
                                <h5 class="card-title">' . $row['product_name'] . '</h5>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a href="product_detail.php?product_id=' . $row['product_id'] . '" class="btn btn-sm btn-outline-secondary">View</a>
                                        <button type="button" class="btn btn-sm btn-outline-secondary addToWishlistBtn" data-product-id="' . $row['product_id'] . '">Add to Wishlist</button>
                                    </div>
                                    <b><small class="text-muted">Rs ' . $row['price'] . '</small><b>
                                </div>
                            </div>
                        </div>
                    </div>';
            }
        } else {
            // Handle case when no search results are found
            echo '<img src="images/no_product.gif" alt="No Products" width="800px" height="700px" style = "margin-left:100px">';
        }
        
        $conn->close();
        ?>
    </div>
</div>

<?php include('customer_footer.php'); ?>

<script>
    $(document).ready(function() {
        $(".addToWishlistBtn").click(function() {
            var product_id = $(this).data("product-id");
            var user_id = <?php echo $_SESSION['user_id']; ?>;

            $.ajax({
                type: "POST",
                url: "add_to_wishlist.php",
                data: { product_id: product_id, customer_id: user_id },
                success: function(response) {
                    if (response === 'success') {
                        alert("Product added to wishlist!");
                    } else if (response === 'duplicate') {
                        alert("Product is already in your wishlist.");
                    } else {
                        alert("Error adding product to wishlist.");
                    }
                }
            });
        });
    });
</script>

<!-- JavaScript to remove existing content outside product-list -->
<script>
    $(document).ready(function() {
        // Remove all elements outside the product-list
        $("body > *:not(#product-list)").remove();
    });
</script>

</body>
</html>
