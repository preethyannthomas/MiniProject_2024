<?php
// Include your database connection file
include("connection.php");

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the required data is present in the POST request
    if (isset($_POST['product_id']) && isset($_POST['review_text'])) {
        // Sanitize and store the data from the POST request
        $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
        $review_text = mysqli_real_escape_string($conn, $_POST['review_text']);
        
        // Retrieve the user ID from the session
        session_start();
        $user_id = $_SESSION['user_id'];
        
        // Check if the user has already reviewed this product (optional)
        $userReviewQuery = "SELECT * FROM tbl_review WHERE product_id = '$product_id' AND customer_id = '$user_id'";
        $userReviewResult = mysqli_query($conn, $userReviewQuery);
        
        if (mysqli_num_rows($userReviewResult) > 0) {
            // The user has already reviewed this product
            echo 'duplicate';
        } else {
            // Insert the review into the database
            $insertReviewQuery = "INSERT INTO tbl_review (product_id, customer_id, review_text) VALUES ('$product_id', '$user_id', '$review_text')";
            
            if (mysqli_query($conn, $insertReviewQuery)) {
                // Review added successfully
                echo 'success';
            } else {
                // Error occurred while adding the review
                echo 'error';
            }
        }
    } else {
        // Required data is missing
        echo 'missing_data';
    }
} else {
    // Invalid request method (not a POST request)
    echo 'invalid_request';
}
?>
