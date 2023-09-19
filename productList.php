<!DOCTYPE html>
<html>
<head>
    <title>Product List</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap"
        rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <title>SwapZone</title>
    <link rel="icon" href="images/logo.png">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.css">
    <link rel="stylesheet" href="css/templatemo-hexashop.css">
    <link rel="stylesheet" href="css/owl-carousel.css">
    <link rel="stylesheet" href="css/lightbox.css">
    <style>
        img{
           height:390px;
        }
    </style>
</head>
<body>
<?php
session_start();
include('connection.php');
include('customer_header.php');
?>

<div class="container mt-4">
    <br><br><br><br>
    <div class="row">
        <?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('location:./');
        }
        include("connection.php"); 
        
        
        if (isset($_GET['category_id'])) {
            $category_id = $_GET['category_id'];
            if($category_id==1){
                $sql = "SELECT * FROM tbl_product p
                INNER JOIN tbl_subcategory s ON p.subcategory_id = s.subcategory_id
                INNER JOIN tbl_category c ON s.category_id = c.category_id
                WHERE c.category_id = 1";
                $result = $conn->query($sql);
        
            } else if($category_id==2){
                $sql = "SELECT * FROM tbl_product p
                INNER JOIN tbl_subcategory s ON p.subcategory_id = s.subcategory_id
                INNER JOIN tbl_category c ON s.category_id = c.category_id
                WHERE c.category_id=2";
                $result = $conn->query($sql);
        
            } else if($category_id==3){
                $sql = "SELECT * FROM tbl_product p
                INNER JOIN tbl_subcategory s ON p.subcategory_id = s.subcategory_id
                INNER JOIN tbl_category c ON s.category_id = c.category_id
                WHERE c.category_id=3";
                $result = $conn->query($sql);
        
            } else {
                $sql= 'SELECT * FROM tbl_product';
                $result = $conn->query($sql);
        
            }
          
            
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
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
                
            }
        } else {
           
        }

  
        $result = $conn->query($sql);

 
        $conn->close();
        ?>
    </div>
</div>
<?php include('customer_footer.php')?>

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

</body>
</html>
