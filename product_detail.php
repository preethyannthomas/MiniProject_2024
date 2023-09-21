<?php
include("connection.php");
session_start();
if (!isset($_SESSION['user_id'])) {
    header('location:./');
}

$productImages = array(); // Define $productImages as an empty array

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
            // Fetch detail_id from the first result (you may adjust this logic)
            $detailRow = mysqli_fetch_assoc($detailResult);
            $detail_id = $detailRow['detail_id'];

            $imageQuery = "SELECT image FROM tbl_image WHERE detail_id = '$detail_id'";
            $imageResult = mysqli_query($conn, $imageQuery);

            if ($imageResult && mysqli_num_rows($imageResult) > 0) {
                while ($row = mysqli_fetch_assoc($imageResult)) {
                    $imageData = base64_encode($row['image']); // Encode image data
                    $productImages[] = $imageData;
                }
            }

            $productDetails = array();
            mysqli_data_seek($detailResult, 0); // Reset result pointer
            while ($row = mysqli_fetch_assoc($detailResult)) {
                $productDetails[] = $row;
            }
        }
    }
}

// Check if the product is in the wishlist
$isInWishlist = isProductInWishlist($product1['product_id'], $_SESSION['user_id']);

function isProductInWishlist($productId, $customerId)
{
    global $conn;

    $query = "SELECT * FROM tbl_wishlist WHERE product_id = '$productId' AND customer_id = '$customerId'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <!-- Include xzoom CSS and JS -->
    <link rel="stylesheet" href="https://unpkg.com/xzoom/dist/xzoom.css">
    <script src="https://unpkg.com/xzoom/dist/xzoom.min.js"></script>

    <!-- Include fancybox CSS and JS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>

    <style>
        /* Add your CSS styles here */
        button {
            color: black;
            background-color: white;
            border-radius: 15px;
            width: 170px;
            height: 50px;
        }

        button:hover {
            color: white;
            background-color: black;
            border-radius: 15px;
            width: 170px;
            height: 50px;
        }

        #wish {
            all: initial;
        }

        #wish:hover {
            all: initial;
        }

        .image-preview {
            cursor: pointer;
            height: 85px; /* Adjust the height as needed */
            width: 73px;
            margin-bottom: 10px;
        }

        .image-preview img {
            height: 80px; /* Adjust the height as needed */
            width: 70px; /* Adjust the width as needed */
            margin-bottom: 10px;
        }

        .selected-image {
            border: 2px solid lightblue;
        }

        .image-preview-large img {
            height: 500px; /* Adjust the height as needed */
            width: 450px; /* Adjust the width as needed */
            margin-right: 10px;
        }

        .img-zoom-container {
            position: relative;
        }

        .img-zoom-lens {
            position: absolute;
            border: 1px solid #d4d4d4;
            width: 40px;
            height: 40px;
        }

        .img-zoom-result {
            border: 1px solid #d4d4d4;
            width: 300px;
            height: 300px;
            background-size: cover;
            background-repeat: no-repeat;
        }
    </style>

</head>

<body>

    <?php include('customer_header.php')?>

    <section>
        <br><br><br><br><br>
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <?php foreach ($productImages as $index => $imageData) { ?>
                        <div class="image-preview" data-index="<?php echo $index; ?>">
                            <img src="data:image/jpeg;base64,<?php echo $imageData; ?>" alt="<?php echo $product1['product_name']; ?>">
                        </div>
                    <?php } ?>
                </div>

                <div class="image-preview-large img-zoom-container">
            <!-- Use a common class for all zoomable images -->
            <a class="zoomable-image" href="data:image/jpeg;base64,<?php echo $productImages[0]; ?>" data-fancybox="images">
                <img id="zoomedImage" src="data:image/jpeg;base64,<?php echo $productImages[0]; ?>" alt="<?php echo $product1['product_name']; ?>">
            </a>
        </div>

                <div class="col-md-5">
                    <h2><?php echo $product1['product_name']; ?> &nbsp; &nbsp;&nbsp;
                        <button onclick="addToWishlist(<?php echo $product1['product_id']; ?>, <?php echo $_SESSION['user_id']; ?>)" id="wish">
                            <img id="wishlistIcon" src="<?php echo $isInWishlist ? 'images/inWishlist.png' : 'images/notWishlist.png'; ?>" style="height: 28px; margin-bottom: 5px;">
                        </button>
                    </h2> <br>
                    <p>Colour: <?php echo $productDetails[0]['colour']; ?></p>
                    <p><?php echo 'Material: ' . $productDescription['material']; ?></p>
                    <p><?php echo 'Usage: ' . $productDescription['usage_description']; ?></p>
                    <p><?php echo 'Weight: ' . $productDescription['weight'] . 'g'; ?></p>
                    <p><?php echo 'Care Instructions: ' . $productDescription['care_instruction']; ?></p>
                    <p><?php echo 'Dimension: ' . $productDescription['dimension']; ?></p>
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
                    <button>Buy Now</button>
                </div>
            </div>
        </div>
    </section>

    <?php include('customer_footer.php')?>

    <script>
        $(document).ready(function () {
            $(".image-preview").click(function () {
                var selectedImage = $(this).find("img").attr("src");

                // Update the zoomable image source and trigger zoom
                $(".zoomable-image").attr("href", selectedImage);
                $("#zoomedImage").attr("src", selectedImage);

                // Remove the outline from all images and add it to the clicked image
                $(".image-preview").removeClass("selected-image");
                $(this).addClass("selected-image");
            });

            $("#sizeSelect").change(function () {
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
                data: {
                    product_id: productId,
                    customer_id: customerId,
                    description_id: descriptionId,
                    size: selectedSize,
                    quantity: selectedQuantity
                },
                success: function (response) {
                    if (response === 'success') {
                        console.log(response);
                        alert('Product added to cart.');
                    } else if (response === 'duplicate') {
                        alert('Product is already in your cart.');
                    } else {
                        alert('Failed to add product to cart.');
                    }
                },
                error: function () {
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
                data: {
                    product_id: productId,
                    customer_id: customerId,
                    size: selectedSize,
                    quantity: selectedQuantity
                },
                success: function (response) {
                    if (response === 'success') {
                        console.log(response);
                        alert('Product added to wishlist.');

                        // After successfully adding to the wishlist, fetch the updated wishlist status
                        checkWishlistStatus(productId, customerId);
                    } else if (response === 'duplicate') {
                        alert('Product is already in your wishlist.');
                    } else {
                        alert('Failed to add product to wishlist.');
                    }
                },
                error: function () {
                    alert('An error occurred while processing your request.');
                }
            });
        }

        // Function to check and update the wishlist status
        function checkWishlistStatus(productId, customerId) {
            $.ajax({
                url: 'check_wishlist_status.php', // Replace with the correct server-side script to check the wishlist status
                type: 'POST',
                data: {
                    product_id: productId,
                    customer_id: customerId
                },
                success: function (response) {
                    if (response === 'inWishlist') {
                        $("#wishlistIcon").attr("src", "images/inWishlist.png");
                    } else {
                        $("#wishlistIcon").attr("src", "images/notWishlist.png");
                    }
                },
                error: function () {
                    alert('An error occurred while checking the wishlist status.');
                }
            });
        }
    </script>
</body>

</html>
