<?php
// Include your database connection file
include("connection.php");

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the required data is present in the POST request
    if (isset($_POST['product_id'])) {
        // Sanitize and store the data from the POST request
        $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
        
        // Query to fetch reviews for the specified product
        $fetchReviewsQuery = "SELECT * FROM tbl_review WHERE product_id = '$product_id'";
        
        $reviewHTML = ''; // Initialize an empty variable to store the HTML
        
        // Execute the query to fetch reviews
        $result = mysqli_query($conn, $fetchReviewsQuery);
        
        if ($result && mysqli_num_rows($result) > 0) {
            // Loop through the fetched reviews and create HTML for each review
            while ($row = mysqli_fetch_assoc($result)) {
                $reviewHTML .= '<p>' . $row['review_text'] . '</p>';
            }
        } else {
            $reviewHTML .= '<p>No reviews available for this product.</p>';
        }
        
        // Send the generated HTML back to the client
        echo $reviewHTML;
    } else {
        // Required data is missing
        echo 'missing_data';
    }
} else {
    // Invalid request method (not a POST request)
    echo 'invalid_request';
}
?>
