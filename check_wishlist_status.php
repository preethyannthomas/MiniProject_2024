<?php
include("connection.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page or handle this situation as needed
    echo 'notInWishlist';
    exit;
}

if (isset($_POST['product_id']) && isset($_POST['customer_id'])) {
    $product_id = $_POST['product_id'];
    $customer_id = $_POST['customer_id'];

    // Query the database to check if the product is in the wishlist
    $query = "SELECT * FROM tbl_wishlist WHERE product_id = '$product_id' AND customer_id = '$customer_id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        // The product is in the wishlist
        echo 'inWishlist';
    } else {
        // The product is not in the wishlist
        echo 'notInWishlist';
    }
} else {
    // Handle missing or invalid POST data
    echo 'error';
}
?>
