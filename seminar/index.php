<!DOCTYPE html>
<html>
<head>
    <title>Fashion Product Description Generator</title>
</head>
<body>
    <h1>Fashion Product Description Generator</h1>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="image" accept=".jpg, .jpeg, .png">
        <input type="submit" value="Upload and Generate Description">
    </form>

    <?php

if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = './uploads/';
    $uploadFile = $uploadDir . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile);

    // Send the image to the Streamlit app
    $url = 'http://localhost:8501/'; // Adjust the URL and endpoint as needed
    $data = ['image' => new CURLFile($uploadFile)];
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $responseData = json_decode($response, true);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$response = curl_exec($ch);
$curlError = curl_error($ch);
curl_close($ch);

echo "HTTP Code: " . $httpCode . "<br>";
echo "CURL Error: " . $curlError . "<br>";

if ($httpCode === 200) {
    // Process the response data
    // ...
} else {
    echo "Invalid response from the Streamlit app.";
}

    if ($responseData === null) {
        echo "Invalid response from the Streamlit app.";
        exit;
    }

    // Display the results
    if (isset($responseData['product_category']) && isset($responseData['gender']) && isset($responseData['clothing_colors']) && isset($responseData['caption'])) {
        // Display results
        echo "<h2>Analysis Results:</h2>";
        echo "<p>Product: " . ucfirst($responseData['product_category']) . "</p>";
        echo "<p>Gender: " . $responseData['gender'] . "</p>";
        echo "<p>Clothing Colors: " . implode(", ", $responseData['clothing_colors']) . "</p>";
        echo "<p>Generated Caption: " . $responseData['caption'] . "</p>";
    } else {
        echo "Incomplete or invalid response from the Streamlit app.";
    }

} else {
    echo "Error uploading the image.";
}

    ?>
</body>
</html>
