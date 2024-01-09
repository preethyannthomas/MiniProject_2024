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
        $reviewQuery = "SELECT * FROM tbl_review WHERE product_id = '$product_id'";
        $reviewResult = mysqli_query($conn, $reviewQuery);

        $reviews = array();
        if ($reviewResult && mysqli_num_rows($reviewResult) > 0) {
            while ($row = mysqli_fetch_assoc($reviewResult)) {
                $reviews[] = $row;
            }
        }
         // Calculate average rating
         if (!empty($reviews)) {
            $totalRatings = count($reviews);
            $totalRatingValue = array_sum(array_column($reviews, 'rating'));
            $averageRating = $totalRatingValue / $totalRatings;
        }
    }
}
// Function to generate star rating HTML
function generateStarRating($rating)
{
    $ratingHtml = '<div class="rating">';
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $rating) {
            $ratingHtml .= '<span class="star">&#9733;</span>'; // Gold star (★)
        } else {
            $ratingHtml .= '<span class="star">&#9734;</span>'; // Empty star (☆)
        }
    }
    $ratingHtml .= '</div>';
    return $ratingHtml;
}

// Function to generate individual star ratings and percentages
function generateIndividualStarRatings($reviews)
{
    $starRatingsHtml = '';
    $starCounts = array(0, 0, 0, 0, 0);
    $totalReviews = count($reviews);

    foreach ($reviews as $review) {
        $rating = $review['rating'];
        $starCounts[$rating - 1]++;
    }

    $maxPercentage = 100; // Maximum width for all bars

    for ($i = 5; $i >= 1; $i--) {
        $starPercentage = ($starCounts[$i - 1] / $totalReviews) * $maxPercentage;
        $starRatingsHtml .= '<div class="star-rating">';
        $starRatingsHtml .= '<div class="rating-star">' . $i . ' star</div>';
        $starRatingsHtml .= '<div class="rating-bar">';
        // Create the gold-filled bar
        $starRatingsHtml .= '<div class="rating-bar-inner" style="width: ' . $starPercentage . '%;"></div>';
        // Create the gray bar
        $starRatingsHtml .= '<div class="rating-bar-gray" style="width: ' . $maxPercentage . '%;"></div>';
        $starRatingsHtml .= '<div class="rating-bar-text">' . round($starPercentage, 1) . '%</div>';
        $starRatingsHtml .= '</div>';
        $starRatingsHtml .= '</div>';
    }

    return $starRatingsHtml;
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

    <!-- Include FancyBox CSS and JS -->
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
            background: rgba(0, 0, 0, 0.4);
            display: none;
        }

        .img-zoom-result {
            border: 1px solid #d4d4d4;
            width: 500px;
            height: 500px;
            background-size: cover;
            background-repeat: no-repeat;
            display: none;
            position: absolute;
        }
        /* CSS for star ratings */
        .rating {
            font-size: 24px; /* Adjust the font size as needed */
        }

        .star {
            color: gold; /* Gold color for filled stars */
            margin-right: 5px; /* Adjust the spacing between stars */
        }

        .star-rating {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }

        .rating-star {
            flex: 0 0 100px; /* Adjust the width of the star label as needed */
        }

        .rating-bar {
            flex: 1;
            display: flex;
            align-items: center;
        }

        .rating-bar-inner {
            border-radius: 2px;
            background-color: gold; /* Gold color for filled portion of the rating bar */
            height: 8px; /* Adjust the height of the rating bar as needed */
            transform-origin: left center; /* Set the transform origin to the left side */
        }

        /* New style for the gray bar */
        .rating-bar-gray {
            border-radius: 2px;
            background-color: lightgray; /* Light gray color for the unfilled portion of the rating bar */
            height: 8px; /* Adjust the height of the rating bar as needed */
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
                            <a class="zoomable-image" href="data:image/jpeg;base64,<?php echo $imageData; ?>" data-fancybox="images">
                                <img src="data:image/jpeg;base64,<?php echo $imageData; ?>" alt="<?php echo $product1['product_name']; ?>">
                            </a>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-md-5">
                    <div class="image-preview-large img-zoom-container">
                        <a class="zoomable-image" href="data:image/jpeg;base64,<?php echo $productImages[0]; ?>" data-fancybox="images">
                            <img class="second-column-image" src="data:image/jpeg;base64,<?php echo $productImages[0]; ?>" alt="<?php echo $product1['product_name']; ?>">
                        </a>
                        
                        <span class="img-zoom-lens"></span>
                    </div>
                </div>
                <div class="col-md-5"><div class="img-zoom-result"></div>
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
                    <br><br>
                    <p><strong>Reviews and Ratings</strong></p>
                    <?php if (count($reviews) > 0) { ?>
                        <div class="rating" style="font-size: 8px;">
                            <?php echo generateStarRating($averageRating); ?>
                        </div>
                        <p style="font-size: 16px;"><?php echo $averageRating; ?> out of 5 stars</p>
                        <p style="font-size: 14px;"><?php echo count($reviews); ?> global ratings</p>
                        <div class="star-ratings" style="font-size: 14px;">
                            <?php echo generateIndividualStarRatings($reviews); ?>
                        </div>
                    <?php } else { ?>
                        <p>No reviews yet. Be the first to add your review!</p>
                        <!-- You can add a button or a link to a review submission page here -->
                    <?php } ?>

                    <?php if (empty($reviews)) { ?>

<?php } else { ?>
    <?php
if (!empty($reviews)) {
    // Sort the reviews by review_date in descending order (latest first)
    usort($reviews, function ($a, $b) {
        return strtotime($b['review_date']) - strtotime($a['review_date']);
    });
?>
    <ul>
    <?php
if (count($reviews) > 0) {
    // Sort the reviews by review_date in descending order (latest first)
    usort($reviews, function ($a, $b) {
        return strtotime($b['review_date']) - strtotime($a['review_date']);
    });
?>

<ul id="reviewList">
    <?php
    $displayedReviews = min(count($reviews), 2); // Display at most 2 reviews initially
    for ($i = 0; $i < $displayedReviews; $i++) {
        $review = $reviews[$i];
        // Fetch the customer's name based on user_id
        $userId = $review['user_id'];
        $customerName = ''; // Initialize the variable

        // Query to fetch the customer's name from tbl_customer
        $customerQuery = "SELECT customer_name FROM tbl_customer WHERE user_id = $userId";

        // Execute the query and get the customer's name
        // You should use the appropriate database connection method here
        // Assuming you're using mysqli, here's an example:
        $customerResult = mysqli_query($conn, $customerQuery);

        if ($customerResult && mysqli_num_rows($customerResult) > 0) {
            $customerData = mysqli_fetch_assoc($customerResult);
            $customerName = $customerData['customer_name'];
        }
    ?>
        <li>
            <div style="display: flex; align-items: center;font-size:14px;">
                <strong><?php echo $customerName; ?> &nbsp;&nbsp;&nbsp;</strong>
                <div class="rating">
                    <?php
                    $rating = $review['rating'];
                    for ($j = 1; $j <= 5; $j++) {
                        if ($j <= $rating) {
                            echo '<span class="star">&#9733;</span>'; // Gold star (★)
                        } else {
                            echo '<span class="star">&#9734;</span>'; // Empty star (☆)
                        }
                    }
                    ?>
                </div>
            </div>
            <p style="font-size:14px;"><?php echo $review['review_text']; ?></p>
        </li>
    <?php } ?>
</ul>

<a href="#" id="showMoreBtn">Show More</a>
        <a href="#" id="showLessBtn" style="display: none;">Show Less</a>

    <?php } else { ?>
        <p>No reviews yet. Be the first to add your review!</p>
        <!-- You can add a button or a link to a review submission page here -->
    <?php } ?>
</div>
<?php } ?> <?php } ?>
                </div>
            </div>
        </div>
    </section>
    
    <script>
            const showMoreBtn = document.getElementById('showMoreBtn');
            const showLessBtn = document.getElementById('showLessBtn');
            const reviewList = document.getElementById('reviewList');
            let reviewsDisplayed = <?php echo $displayedReviews; ?>;


            function fetchCustomerName(query, li, review) {
                fetch(query)
                    .then(response => response.json())
                    .then(data => {
                        const customerName = data.customer_name;
                        li.innerHTML = `
                            <div style="display: flex; align-items: center;">
                                <strong>${customerName} &nbsp;&nbsp;&nbsp;</strong>
                                <div class="rating">
                                    ${getStarRating(review.rating)}
                                </div>
                            </div>
                            <p>${review.review_text}</p>
                        `;
                    })
                    .catch(error => console.error(error));
            }

            function getStarRating(rating) {
                let starRating = '';
                for (let i = 1; i <= 5; i++) {
                    if (i <= rating) {
                        starRating += '<span class="star">&#9733;</span>'; // Gold star (★)
                    } else {
                        starRating += '<span class="star">&#9734;</span>'; // Empty star (☆)
                    }
                }
                return starRating;
            }
        </script>
    
    <?php include('customer_footer.php')?>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".image-preview").hover(function () {
                var selectedImage = $(this).find("img").attr("src");

                // Update the zoomable image source
                $(".second-column-image").attr("src", selectedImage);

                // Remove the outline from all images and add it to the clicked image
                $(".image-preview").removeClass("selected-image");
                $(this).addClass("selected-image");
            });

            // Initialize FancyBox for the second column image
            $(".second-column-image").click(function () {
                var selectedImage = $(this).attr("src");
                $.fancybox.open({
                    src: selectedImage,
                    type: "image"
                });
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

        // Image zoom functionality
        var lens = document.querySelector('.img-zoom-lens');
        var result = document.querySelector('.img-zoom-result');
        var largeImage = document.querySelector('.second-column-image');

        largeImage.addEventListener('mousemove', moveLens);
        lens.addEventListener('mousemove', moveLens);

        largeImage.addEventListener('touchmove', moveLens);
        lens.addEventListener('touchmove', moveLens);

        largeImage.addEventListener('mouseout', hideLens);
        lens.addEventListener('mouseout', hideLens);

        function moveLens(e) {
            e.preventDefault();

            var bounds = largeImage.getBoundingClientRect();

            var x = e.pageX - bounds.left;
            var y = e.pageY - bounds.top;

            // Center the lens over the cursor
            lens.style.left = x - lens.offsetWidth / 2 + 'px';
            lens.style.top = y - lens.offsetHeight / 2 + 'px';

            var ratioX = x / largeImage.offsetWidth;
            var ratioY = y / largeImage.offsetHeight;

            result.style.backgroundImage = 'url("' + largeImage.src + '")';
            result.style.backgroundSize = largeImage.width * 2 + 'px ' + largeImage.height * 2 + 'px';
            result.style.backgroundPosition = '-' + ratioX * (largeImage.width * 2 - result.offsetWidth) + 'px -' + ratioY * (largeImage.height * 2 - result.offsetHeight) + 'px';

            lens.style.display = 'block';
            result.style.display = 'block';
        }

        function hideLens() {
            lens.style.display = 'none';
            result.style.display = 'none';
        }
    </script>
</body>

</html> 
