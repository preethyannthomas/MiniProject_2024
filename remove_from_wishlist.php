<?php
include("connection.php"); 
if (isset($_POST['wishlist_id'])) {
    $wishlist_id = $_POST['wishlist_id'];
    
    $update_query = "UPDATE tbl_wishlist SET status = 0 WHERE wishlist_id = '$wishlist_id'";
    
    if (mysqli_query($conn, $update_query)) {
        echo 'success';
    } else {
        echo 'error';
    }
} else {
    echo 'invalid';
}
$conn->close();
?>
