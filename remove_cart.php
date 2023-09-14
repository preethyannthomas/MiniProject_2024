<?php
include("connection.php");

if (isset($_POST['cart_id'])) {
    $cart_id = $_POST['cart_id'];
    
    $updateQuery = "UPDATE tbl_cart SET status = 0 WHERE cart_id = '$cart_id'";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>
