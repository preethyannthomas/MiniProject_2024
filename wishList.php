<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<?php include('customer_header.php')?>
<section>
    <br><br><br><br>
    <div class="container mt-4">
    <div class="row">
        <?php
        include("connection.php"); 
        session_start();
            if (!isset($_SESSION['user_id'])) {
                header('location:./');
            }
            $user_id = $_SESSION['user_id'];
        $query = "SELECT w.*, p.product_name, p.price, p.image FROM tbl_wishlist w
        INNER JOIN tbl_product p ON w.product_id = p.product_id
        WHERE w.user_id = '$user_id' and status=1"; 
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $wishlist_id = $row['wishlist_id'];
            $product_id = $row['product_id'];
            $product_name = $row['product_name'];
            $product_price = $row['price'];
               
            echo '<div class="col-md-4 mb-4">';
            echo '<div class="card">';
            echo '<img src="data:image/jpeg;base64,' . base64_encode($row['image']) . '" class="card-img-top" alt="' . $product_name . '">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $product_name . '</h5>';
            echo '<p class="card-text">Rs ' . $product_price . '</p><br>';
            echo '<a href="add_to_cart.php" class="btn btn-secondary">Add to Cart</a>';
            echo '<button class="btn btn-danger float-right removeBtn" data-wishlist-id="' . $wishlist_id . '">Remove</button>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }} else {
            echo '<div class="col-md-12 text-center">';
            echo '<img src="images/contact.gif" alt="Empty Wishlist">';
            echo '<p>Your wishlist is empty.</p>';
            echo '</div>';
        }
        ?>
    </div>
</div>
   
</section>

<?php include('customer_footer.php')?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $(".removeBtn").click(function() {
            var wishlist_id = $(this).data("wishlist-id");

            $.ajax({
                type: "POST",
                url: "remove_from_wishlist.php", 
                data: { wishlist_id: wishlist_id },
                success: function(response) {
                    if (response === 'success') {
                        alert("Product removed from wishlist!");
                        location.reload(); 
                    } else {
                        alert("Error removing product from wishlist.");
                    }
                }
            });
        });
    });
</script>
</body>
</html>
