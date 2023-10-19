<?php
include("connection.php");

if (isset($_POST['image_id'])) {
    $imageId = $_POST['image_id'];

    // Create a prepared statement to fetch image data
    $stmt = $conn->prepare("SELECT image FROM tbl_image WHERE image_id = ?");
    $stmt->bind_param("i", $imageId);
    $stmt->execute();
    $stmt->bind_result($imageData);
    $stmt->fetch();
    $stmt->close();

    if (!empty($imageData)) {
        $imageData = base64_encode($imageData);
        $response = array('imageData' => $imageData);
        echo json_encode($response);
    } else {
        $response = array('error' => 'Image not found');
        echo json_encode($response);
    }
} else {
    $response = array('error' => 'Invalid request');
    echo json_encode($response);
}
?>
