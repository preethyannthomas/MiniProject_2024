<?php
// Include your database connection file
include("connection.php");

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the required data is present in the POST request
    if (isset($_POST['review_id']) && isset($_POST['review_text'])) {
        // Sanitize and store the data from the POST request
        $review_id = mysqli_real_escape_string($conn, $_POST['review_id']);
        $review_text = mysqli_real_escape_string($conn, $_POST['review_text']);
        
        // Retrieve the user ID from the session (optional)
        session_start();
        $user_id = $_SESSION['user_id'];
        
        // Check if the review belongs to the logged-in user (optional)
        $checkReviewOwnershipQuery = "SELECT * FROM tbl_review WHERE review_id = '$review_id' AND customer_id = '$user_id'";
        $checkReviewOwnershipResult = mysqli_query($conn, $checkReviewOwnershipQuery);
        
        if (mysqli_num_rows($checkReviewOwnershipResult) > 0) {
            // Update the review in the database
            $updateReviewQuery = "UPDATE tbl_review SET review_text = '$review_text' WHERE review_id = '$review_id'";
            
            if (mysqli_query($conn, $updateReviewQuery)) {
                // Review edited successfully
                echo 'success';
            } else {
                // Error occurred while editing the review
                echo 'error';
            }
        } else {
            // User doesn't have permission to edit this review
            echo 'permission_denied';
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
