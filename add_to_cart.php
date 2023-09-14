<?php
include("connection.php");
session_start();

if (isset($_POST['product_id']) && isset($_POST['customer_id']) && isset($_POST['description_id']) && isset($_POST['size']) && isset($_POST['quantity'])) {
    $product_id = $_POST['product_id'];
    $customer_id = $_POST['customer_id'];
    $description_id = $_POST['description_id'];
    $selected_size = $_POST['size'];
    $selected_quantity = $_POST['quantity'];

    $checkQuery = "SELECT * FROM tbl_cart WHERE product_id = '$product_id' AND user_id = '$customer_id' AND size = '$selected_size' and status = 1";
    $checkResult = mysqli_query($conn, $checkQuery);

    if ($checkResult && mysqli_num_rows($checkResult) > 0) {
        echo 'duplicate';
    } else {
        $insertQuery = "INSERT INTO tbl_cart (user_id, product_id, description_id, size, quantity) VALUES ('$customer_id', '$product_id', '$description_id', '$selected_size', '$selected_quantity')";
        $insertResult = mysqli_query($conn, $insertQuery);

        if ($insertResult) {
            echo 'success';
        } else {
            echo 'error';
        }
    }
} else {
    echo 'error';
}
?>
