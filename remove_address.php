<?php
require 'connection.php'; 
if (!isset($_SESSION['user_id'])) {
    header('location:./');
}
if (isset($_GET['address_id'])) {
    $addressId = $_GET['address_id'];
    $deleteQuery = "DELETE FROM tbl_address WHERE address_id = '$addressId' and is_Default!=1";
    
    if (mysqli_query($conn, $deleteQuery)) {
        header("Location: profile.php"); 
        exit();
    } else {
        echo "<script>alert('Default address cannot be deleted.')</script>";
    }
}

mysqli_close($conn); 
?>
