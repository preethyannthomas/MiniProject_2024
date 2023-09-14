include("../connection.php");

// Start the PHP session
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
    // Get user_id from the session
    $user_id = $_SESSION['user_id'];

    // Get data from the form
    $name = $_POST["name"];
    $category_name = $_POST["category"];
    $subcategory_name = $_POST["subcategory"];
    $material = $_POST["material"];
    $dimension = $_POST["dimension"];
    $weight = $_POST["weight"];
    $usageDescription = $_POST["usageDescription"];
    $careInstruction = $_POST["careInstruction"];

    // Retrieve category_id based on category_name
    $categoryQuery = "SELECT category_id FROM tbl_category WHERE category_name = '$category_name'";
    $categoryResult = $conn->query($categoryQuery);

    if ($categoryResult->num_rows == 1) {
        $categoryRow = $categoryResult->fetch_assoc();
        $category_id = $categoryRow["category_id"];

        // Retrieve subcategory_id based on subcategory_name and category_id
        $subcategoryQuery = "SELECT subcategory_id FROM tbl_subcategory WHERE subcategory_name = '$subcategory_name' AND category_id = '$category_id'";
        $subcategoryResult = $conn->query($subcategoryQuery);

        if ($subcategoryResult->num_rows == 1) {
            $subcategoryRow = $subcategoryResult->fetch_assoc();
            $subcategory_id = $subcategoryRow["subcategory_id"];

            // Insert data into tbl_product
            $insertProductQuery = "INSERT INTO tbl_product (seller_id, subcategory_id, product_name, price, is_available) VALUES ('$user_id', '$subcategory_id', '$name', 0.00, 1)";
            $conn->query($insertProductQuery);

            // Get the newly inserted product ID
            $productId = $conn->insert_id;

            // Insert data into tbl_productdescription
            $insertDescriptionQuery = "INSERT INTO tbl_productdescription (product_id, colour, usage_description, weight, care_instruction, material, dimension) VALUES ('$productId', '', '$usageDescription', '$weight', '$careInstruction', '$material', '$dimension')";
            $conn->query($insertDescriptionQuery);

            // Handle product details (size, color, stock, price, images) insertion here
            if (isset($_POST['size']) && isset($_POST['color']) && isset($_POST['numItems']) && isset($_POST['price'])) {
                $sizes = $_POST['size'];
                $colors = $_POST['color'];
                $numItems = $_POST['numItems'];
                $prices = $_POST['price'];

                // Loop through the arrays and insert data into tbl_productdetail
                for ($i = 0; $i < count($sizes); $i++) {
                    $size = $sizes[$i];
                    $color = $colors[$i];
                    $stock = $numItems[$i];
                    $price = $prices[$i];

                    $insertProductDetailQuery = "INSERT INTO tbl_productdetail (size, colour, stock, is_available, product_id, new_price) VALUES ('$size', '$color', '$stock', 1, '$productId', '$price')";
                    $conn->query($insertProductDetailQuery);
                }

                // Respond with a success message
                echo "Product added successfully.";
            } else {
                echo "Product details are missing.";
            }
        } else {
            echo "Invalid subcategory name.";
        }
    } else {
        echo "Invalid category name.";
    }

    // Close the database connection
    $conn->close();
} else {
    // Display the form
}