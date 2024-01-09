<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        img {
            height: 390px;
        }
    </style>
</head>
<body>
    <?php
    include("connection.php");
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    ?>
    <?php include('customer_header.php')?>
    <section>
        <br><br><br><br>
        <div class="container mt-4">
            <div class="row">
                <?php
                include("connection.php");
                if (!isset($_SESSION['user_id'])) {
                    header('location:./');
                }
                $user_id = $_SESSION['user_id'];

                // Fetch the customer_id from tbl_customer based on the user_id
                $customer_query = "SELECT customer_id FROM tbl_customer WHERE user_id = '$user_id'";
                $customer_result = mysqli_query($conn, $customer_query);

                if ($customer_result && mysqli_num_rows($customer_result) > 0) {
                    $customer_row = mysqli_fetch_assoc($customer_result);
                    $customer_id = $customer_row['customer_id'];

                    $query = "SELECT w.*, p.product_name, p.price, p.image FROM tbl_wishlist w
                    INNER JOIN tbl_product p ON w.product_id = p.product_id
                    WHERE w.user_id = '$user_id' AND w.status = 1";
                    $result = mysqli_query($conn, $query);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $wishlist_id = $row['wishlist_id'];
                            $product_id = $row['product_id'];
                            $product_name = $row['product_name'];
                            $product_price = $row['price'];

                            // Fetch the size from tbl_productdetail based on the product_id
                            $size_query = "SELECT size FROM tbl_productdetail WHERE product_id = '$product_id'";
                            $size_result = mysqli_query($conn, $size_query);

                            if ($size_result && mysqli_num_rows($size_result) > 0) {
                                $size_row = mysqli_fetch_assoc($size_result);
                                $selected_size = $size_row['size'];
                            } else {
                                $selected_size = 'M'; // Set a default value if needed
                            }

                            $description_query = "SELECT description_id FROM tbl_productdescription WHERE product_id = '$product_id'";
                            $description_result = mysqli_query($conn, $description_query);

                            if ($description_result && mysqli_num_rows($description_result) > 0) {
                                $description_row = mysqli_fetch_assoc($description_result);
                                $description_id = $description_row['description_id'];
                            } else {
                                $description_id = 1; // Set a default value if needed
                            }
                            echo '<div class="col-md-4 mb-4">';
                            echo '<div class="card">';
                            echo '<img src="data:image/jpeg;base64,' . base64_encode($row['image']) . '" class="card-img-top" alt="' . $product_name . '">';
                            echo '<div class="card-body">';
                            echo '<h5 class="card-title">' . $product_name . '</h5>';
                            echo '<p class="card-text">Rs ' . $product_price . '</p><br>';
                            echo '<a href="javascript:void(0);" class="btn btn-secondary" onclick="addToCart(' . $product_id . ', ' . $customer_id . ', ' . $description_id . ', \'' . $selected_size . '\', 1)">Add to Cart</a>';
                            echo '<button class="btn btn-danger float-right removeBtn" data-wishlist-id="' . $wishlist_id . '">Remove</button>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<div class="col-md-12 text-center">';
                        echo '<img src="images/contact.gif" alt="Empty Wishlist">';
                        echo '<p>Your wishlist is empty.</p>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>Error: User not found.</p>';
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
        function addToCart(product_id, customer_id, description_id, size, quantity) {
            $.ajax({
                type: "GET",
                url: "adding_to_cart.php",
                data: {
                    product_id: product_id,
                    customer_id: customer_id,
                    description_id: description_id,
                    size: size,
                    quantity: quantity
                },
                success: function (response) {
                    if (response === 'success') {
                        alert("Product added to cart!");
                    } else if (response === 'duplicate') {
                        alert("Product is already in the cart.");
                    } else {
                        alert("Error adding product to cart.");
                    }
                }
            });
        }
        $(document).ready(function () {
            $(".removeBtn").click(function () {
                var wishlist_id = $(this).data("wishlist-id");

                $.ajax({
                    type: "POST",
                    url: "remove_from_wishlist.php",
                    data: {wishlist_id: wishlist_id},
                    success: function (response) {
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
