<?php
session_start();
require 'connection.php';

if (isset($_GET['address_id'])) {
    $addressId = $_GET['address_id'];
    $user_id = $_SESSION['user_id'];
    $updateNonDefaultQuery = "UPDATE tbl_address SET is_default = 0 WHERE user_id = '$user_id'";
    mysqli_query($conn, $updateNonDefaultQuery);
    $updateDefaultQuery = "UPDATE tbl_address SET is_default = 1 WHERE user_id = '$user_id' AND address_id = '$addressId'";
    mysqli_query($conn, $updateDefaultQuery);
    mysqli_close($conn); 
    header("Location: profile.php");
    exit();
}
?>
