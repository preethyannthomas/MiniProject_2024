<?php
include("../connection.php");

if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];

    // Prepare the SQL statement
    $subcategoryQuery = "SELECT subcategory_id, subcategory_name FROM tbl_subcategory WHERE category_id = ?";
    
    // Initialize an empty array for subcategories
    $subcategories = array();

    // Use a prepared statement to fetch subcategories
    if ($stmt = $conn->prepare($subcategoryQuery)) {
        // Bind the category_id parameter
        $stmt->bind_param("i", $category_id);

        // Execute the query
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        // Fetch subcategories and add them to the array
        while ($row = $result->fetch_assoc()) {
            $subcategory_id = $row["subcategory_id"];
            $subcategory_name = $row["subcategory_name"];

            // Create an associative array for subcategories
            $subcategory = array(
                "subcategory_id" => $subcategory_id,
                "subcategory_name" => $subcategory_name
            );

            // Push the subcategory to the array
            array_push($subcategories, $subcategory);
        }

        // Close the statement
        $stmt->close();
    }

    // Send the subcategories as JSON response
    header("Content-Type: application/json");
    echo json_encode($subcategories);
} else {
    // Handle the case where category_id is not provided in the request
    echo "Invalid request.";
}

// Close the database connection
$conn->close();
?>
