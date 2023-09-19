<?php
include("connection.php");
session_start();
if (!isset($_SESSION['user_id'])) {
    header('location:./');
}

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
 
    $productQuery = "SELECT * FROM tbl_product WHERE product_id = '$product_id'";
    $productResult = mysqli_query($conn, $productQuery);

    if ($productResult && mysqli_num_rows($productResult) > 0) {
        $product1 = mysqli_fetch_assoc($productResult);
        $descriptionQuery = "SELECT * FROM tbl_productdescription WHERE product_id = '$product_id'";
        $descriptionResult = mysqli_query($conn, $descriptionQuery);
        if ($descriptionResult && mysqli_num_rows($descriptionResult) > 0) {
            $productDescription = mysqli_fetch_assoc($descriptionResult);
        } 
        $detailQuery = "SELECT * FROM tbl_productdetail WHERE product_id = '$product_id'";
        $detailResult = mysqli_query($conn, $detailQuery);
        if ($detailResult && mysqli_num_rows($detailResult) > 0) {
            $productDetails = array();
            while ($row = mysqli_fetch_assoc($detailResult)) {
                $productDetails[] = $row;
            }
        } 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        button{
            color: black;
            background-color: white;
            border-radius: 15px;
            width:170px;
            height: 50px;
        }
        button:hover{
            color: white;
            background-color: black;
            border-radius: 15px;
            width:170px;
            height: 50px;
        }
    </style>
</head>
<body>

<?php include('customer_header.php')?>

<section>
    <br><br><br><br><br>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img src="data:image/jpeg;base64,<?php echo base64_encode($product1['image']); ?>" alt="<?php echo $product1['product_name']; ?>" style="height:500px; width: 480px;">
            </div><br>
            <div class="col-md-6">
                <h2><?php echo $product1['product_name']; ?></h2><br>
                <p>Colour: <?php echo $productDetails[0]['colour']; ?></p>
                <p><?php echo 'Material: '.$productDescription['material']; ?></p>
                <p><?php echo 'Usage: '.$productDescription['usage_description']; ?></p>
                <p><?php echo 'Weight: '.$productDescription['weight'].'g'; ?></p>
                <p><?php echo 'Care Instructions: '.$productDescription['care_instruction']; ?></p>
                <p><?php echo 'Dimension: '.$productDescription['dimension']; ?></p>
                <label for="sizeSelect">Choose Size:</label>
                <select id="sizeSelect">
                    <?php foreach ($productDetails as $detail) { ?>
                        <option value="<?php echo $detail['size']; ?>"><?php echo $detail['size']; ?></option>
                    <?php } ?>
                </select>
                <p id="priceDisplay">Price: Rs <?php echo $productDetails[0]['new_price']; ?></p>
                
                <label for="quantityInput">Choose Quantity:</label>
                <input type="number" id="quantityInput" min="1" max="<?php echo $productDetails[0]['stock']; ?>">
                <br><br>
                <button onclick="addToCart(<?php echo $product1['product_id']; ?>, <?php echo $_SESSION['user_id']; ?>, <?php echo $productDescription['description_id']; ?>, $('#sizeSelect').val(), $('#quantityInput').val())">Add to Cart</button>


&nbsp;&nbsp;
                <button onclick="addToWishlist(<?php echo $product1['product_id']; ?>, <?php echo $_SESSION['user_id']; ?>)">Add to Wishlist</button>&nbsp;&nbsp;
                <button>Buy Now</button>
            </div>
        </div>
    </div>
</section>

<?php include('customer_footer.php')?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
    $(document).ready(function() {
      
        $("#sizeSelect").change(function() {
            var selectedSize = $(this).val();
            var selectedSizeData = <?php echo json_encode($productDetails); ?>;
            
            for (var i = 0; i < selectedSizeData.length; i++) {
                if (selectedSizeData[i]['size'] === selectedSize) {
                    $("#priceDisplay").text("Price: Rs " + selectedSizeData[i]['new_price']);
                    $("#quantityInput").attr("max", selectedSizeData[i]['stock']);
                    break;
                }
            }
        });
    });

    function addToCart(productId, customerId, descriptionId, selectedSize, selectedQuantity) {
    $.ajax({
        url: 'add_to_cart.php',
        type: 'POST',
        data: { product_id: productId, customer_id: customerId, description_id: descriptionId, size: selectedSize, quantity: selectedQuantity },
        success: function(response) {
            if (response === 'success') {
                console.log(response);
                alert('Product added to cart.');
            } else if (response === 'duplicate') {
                alert('Product is already in your cart.');
            } else {
                alert('Failed to add product to cart.');
            }
        },
        error: function() {
            alert('An error occurred while processing your request.');
        }
    });
}



    function addToWishlist(productId, customerId) {
        var selectedSize = $("#sizeSelect").val();
        var selectedQuantity = $("#quantityInput").val();

        $.ajax({
            url: 'add_to_wishlist.php',
            type: 'POST',
            data: { product_id: productId, customer_id: customerId },
            success: function(response) {
                if (response === 'success') {
                    console.log(response);
                    alert('Product added to wishlist.');
                } else if (response === 'duplicate') {
                    alert('Product is already in your wishlist.');
                } else {
                    alert('Failed to add product to wishlist.');
                }
            },
            error: function() {
                alert('An error occurred while processing your request.');
            }
        });
    }
</script>

</body>
</html>