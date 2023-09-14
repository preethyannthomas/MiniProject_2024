<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .product-image {
            max-width: 100px;
        }
        .quantity-input {
            width: 50px;
        }
    </style>
</head>
<body>

<?php include('customer_header.php')?>

<section class="mt-5">
    <div class="container">
        <h2>Your Cart</h2>
        <?php
        include("connection.php");
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('location:./');
        }

        $customerId = $_SESSION['user_id'];

        $cartQuery = "SELECT c.*, p.product_name, p.image, pd.new_price, pd.stock, pd.colour
                      FROM tbl_cart c
                      JOIN tbl_product p ON c.product_id = p.product_id
                      JOIN tbl_productdetail pd ON c.product_id = pd.product_id AND c.size = pd.size
                      WHERE c.user_id = '$customerId' and status =1";
        $cartResult = mysqli_query($conn, $cartQuery);

        if ($cartResult && mysqli_num_rows($cartResult) > 0) {
            $cartItems = array();
            while ($row = mysqli_fetch_assoc($cartResult)) {
                $cartItems[] = $row;
            }
        } else {
            echo '<br><br><div class="col-md-12 text-center">';
            echo '<img src="images/empty_cart.gif" alt="Empty Wishlist">';
            echo '</div>';
        }
        ?>

        <?php if (!empty($cartItems)) { ?><br>
            <div class="table-responsive"><br>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Stocks Left</th>
                            <th>Quantity</th>
                            <th>Price Per Unit</th>
                            <th>Total Price</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cartItems as $item) { ?>
                            <tr>
                                <td><img src="data:image/jpeg;base64,<?php echo base64_encode($item['image']); ?>" alt="<?php echo $item['product_name']; ?>" class="product-image"></td>
                                <td><?php echo $item['product_name']; ?></td>
                                <td><?php echo $item['stock']; ?></td>
                                <td><input type="number" class="quantity-input" value="<?php echo $item['quantity']; ?>" min="1" max="<?php echo $item['stock']; ?>"></td>
                                <td>Rs <?php echo $item['new_price']; ?></td>
                                <td>Rs <span class="total-price"><?php echo $item['quantity'] * $item['new_price']; ?></span></td>
                                <td><td><button class="btn btn-danger remove-btn" data-cart-id="<?php echo $item['cart_id']; ?>">Remove</button></td></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="text-right">
                <h4>Total Amount: Rs <span id="totalAmount"></span></h4>
                <a href = "orderConfirm.php"><button class="btn btn-primary mt-3">Buy Now</button></a>
            </div>
        <?php } ?>
    </div>
</section>

<?php include('customer_footer.php')?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        updateTotalAmount();

        $(".quantity-input").on("input", function() {
            var quantity = parseInt($(this).val());
            var price = parseFloat($(this).closest("tr").find("td:eq(4)").text().split(" ")[1]);
            var totalPrice = quantity * price;
            $(this).closest("tr").find(".total-price").text(totalPrice);
            updateTotalAmount();
        });

  
        $(".remove-btn").on("click", function() {
            $(this).closest("tr").remove();
            updateTotalAmount();
            var cart_id = $(this).data("cart-id");
    
    $.ajax({
        type: "POST",
        url: "remove_cart.php", 
        data: { cart_id: cart_id },
        success: function(response) {
            if (response === 'success') {
                alert("Product removed from cart.");
                $(this).closest("tr").remove(); 
                updateTotalAmount();
            } else {
                alert("Error removing product from cart.");
            }
        },
        error: function() {
            alert("An error occurred while processing your request.");
        }
    });
        });

        function updateTotalAmount() {
            var total = 0;
            $(".total-price").each(function() {
                total += parseFloat($(this).text());
            });
            $("#totalAmount").text(total.toFixed(2));
        }
    });
</script>

</body>
</html>
