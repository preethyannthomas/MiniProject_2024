include("../connection.php");

// Assuming you have a table named tbl_colour with columns colour_id and colour
$sql = "SELECT colour_id, colour FROM tbl_colour";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $colors = array();
    while ($row = $result->fetch_assoc()) {
        $colors[] = $row;
    }

    // Return the color data as JSON
    header('Content-Type: application/json');
    echo json_encode($colors);
} else {
    // No colors found
    echo json_encode(array());
}

// Close the database connection
$conn->close();