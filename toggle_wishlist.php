<?php
include("connection.php");
session_start();
if (!isset($_SESSION['user_id'])) {
    header('location:./');
}

if (isset($_POST['product_id']) && isset($_POST['customer_id'])) {
    $product_id = $_POST['product_id'];
    $customer_id = $_POST['customer_id'];

    // Check if the product is already in the wishlist
    if (isProductInWishlist($product_id, $customer_id)) {
        // If it's in the wishlist, toggle its status
        toggleWishlistStatus($product_id, $customer_id);
        echo 'toggled';
    } else {
        // If it's not in the wishlist, add it
        addProductToWishlist($product_id, $customer_id);
        echo 'added';
    }
} else {
    echo 'failed';
}

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

function toggleWishlistStatus($productId, $customerId)
{
    global $conn;

    $query = "SELECT * FROM tbl_wishlist WHERE product_id = '$productId' AND customer_id = '$customerId'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $status = $row['status'];

        // Toggle status: 1 to 0 or 0 to 1
        $newStatus = ($status == 1) ? 0 : 1;

        $updateQuery = "UPDATE tbl_wishlist SET status = '$newStatus' WHERE product_id = '$productId' AND customer_id = '$customerId'";
        $updateResult = mysqli_query($conn, $updateQuery);
    }
}

function addProductToWishlist($productId, $customerId)
{
    global $conn;

    $query = "INSERT INTO tbl_wishlist (product_id, customer_id, status) VALUES ('$productId', '$customerId', 1)";
    $result = mysqli_query($conn, $query);
}
?>
