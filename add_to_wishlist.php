<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('location:./');
}
include("connection.php");

if (isset($_POST['product_id']) && isset($_POST['customer_id'])) {
    $product_id = $_POST['product_id'];
    $customer_id = $_POST['customer_id'];
    $check_query = "SELECT * FROM tbl_wishlist WHERE user_id = '$customer_id' AND product_id = '$product_id'";
    $check_result = mysqli_query($conn, $check_query);

    if ($check_result && mysqli_num_rows($check_result) > 0) {
        $row = mysqli_fetch_assoc($check_result);
        $status = $row['status'];
        if ($status == 0) {
            $update_query = "UPDATE tbl_wishlist SET status = 1 WHERE user_id = '$customer_id' AND product_id = '$product_id'";
            if (mysqli_query($conn, $update_query)) {
                echo 'success';
            } else {
                echo 'error';
            }
        } else {
            echo 'duplicate'; 
        }
    } else {
        $insert_query = "INSERT INTO tbl_wishlist (user_id, product_id) VALUES ('$customer_id', '$product_id')";
        if (mysqli_query($conn, $insert_query)) {
            echo 'success';
        } else {
            echo 'error';
        }
    }
} else {
    echo 'invalid';
}
?>
