<?php
include("../connection.php");
// Check if category_id is set and not empty
if (isset($_POST['category_id']) && !empty($_POST['category_id'])) {
    $category_id = $_POST['category_id'];

    // Connect to your database

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch subcategories based on the selected category_id
    $query = "SELECT id, subcategory_name FROM tbl_subcategory WHERE category_id = $category_id";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Generate the subcategory options
    $options = "<option value='' disabled selected>Select Subcategory</option>";
    while ($row = $result->fetch_assoc()) {
        $options .= "<option value='" . $row['id'] . "'>" . $row['subcategory_name'] . "</option>";
    }

    $stmt->close();
    $conn->close();

    echo $options;
} else {
    // Handle the case where category_id is not set or empty
    echo "<option value='' disabled selected>Select Subcategory</option>";
}
?>
