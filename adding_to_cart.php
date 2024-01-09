<?php
include("connection.php");
session_start();

if (isset($_GET['product_id']) && isset($_GET['customer_id']) && isset($_GET['description_id']) && isset($_GET['size']) && isset($_GET['quantity'])) {
    $product_id = $_GET['product_id'];
    $customer_id = $_SESSION['user_id'];
    $description_id = $_GET['description_id'];
    $selected_size = $_GET['size'];
    $selected_quantity = $_GET['quantity'];

    $checkQuery = "SELECT * FROM tbl_cart WHERE product_id = '$product_id' AND user_id = '$customer_id' AND size = '$selected_size' AND status = 1";
    $checkResult = mysqli_query($conn, $checkQuery);

    if ($checkResult && mysqli_num_rows($checkResult) > 0) {
        echo 'duplicate';
    } else {
        $insertQuery = "INSERT INTO tbl_cart (user_id, product_id, description_id, size, quantity) VALUES ('$customer_id', '$product_id', '$description_id', '$selected_size', '$selected_quantity')";
        $insertResult = mysqli_query($conn, $insertQuery);

        if ($insertResult) {
            // Update the tbl_wishlist to set status = 0
            $updateWishlistQuery = "UPDATE tbl_wishlist SET status = 0 WHERE product_id = '$product_id' AND user_id = '$customer_id'";
            $updateWishlistResult = mysqli_query($conn, $updateWishlistQuery);

            if ($updateWishlistResult) {
                echo 'success';
            } else {
                echo 'error';
            }
        } else {
            echo 'error';
        }
    }
} else {
    echo 'error';
}
?>
