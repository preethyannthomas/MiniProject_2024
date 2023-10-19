<?php
session_start(); // Start the session if not already started

if (isset($_POST['index']) && isset($_POST['images'])) {
    $index = $_POST['index'];
    $productImages = json_decode($_POST['images'], true);

    // Check if the user is logged in
    if (isset($_SESSION['user_id'])) {
        // Retrieve the image data based on the provided index
        if (isset($productImages[$index])) {
            $selectedImage = base64_encode($productImages[$index]);

            // Return the image data with the appropriate data URI format
            echo "data:image/jpeg;base64," . $selectedImage;
            exit; // Make sure to exit after sending the image data
        } else {
            // Handle the case where the image is not found
            echo "Image not found";
        }
    } else {
        // Handle the case where the user is not logged in
        echo "User not logged in";
    }
} else {
    // Handle the case where the index or productImages data is not provided
    echo "Index or productImages data not provided";
}
?>
