<?php
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = './uploads/';
    $uploadFile = $uploadDir . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile);

    // Send the image to the Streamlit app
    $url = 'http://localhost:8501/'; // Adjust the URL and endpoint as needed
    $data = ['input' => new CurlFile($uploadFile)];
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Check the HTTP response code
    if ($httpCode !== 200) {
        echo "Error communicating with the Streamlit app.";
        exit;
    }

    // Process the response
    $result = json_decode($response, true);

    if (is_array($result) && isset($result['product']) && isset($result['gender']) && isset($result['colors']) && isset($result['caption'])) {
        // Display the results on the PHP page
        echo "<h2>Analysis Results:</h2>";
        echo "<p>Product: " . ucfirst($result['product']) . "</p>";
        echo "<p>Gender: " . $result['gender'] . "</p>";
        echo "<p>Clothing Colors: " . implode(", ", $result['colors']) . "</p>";
        echo "<p>Generated Caption: " . $result['caption'] . "</p>";
    } else {
        echo "Invalid response from the Streamlit app.";
    }
} else {
    echo "Error uploading the image.";
}
?>
