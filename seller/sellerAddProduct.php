<?php
session_start();
include("../connection.php"); // Include your database connection

if (!isset($_SESSION['user_id'])) {
    header('location: ./');
    exit();
}

// Fetch user_id from tbl_user
$userQuery = "SELECT user_id FROM tbl_user WHERE user_id = ?";
$userStmt = mysqli_prepare($conn, $userQuery);
mysqli_stmt_bind_param($userStmt, "i", $_SESSION['user_id']);

if (mysqli_stmt_execute($userStmt)) {
    $userResult = mysqli_stmt_get_result($userStmt);
    $userRow = mysqli_fetch_assoc($userResult);
    $userId = $userRow['user_id'];

    // Fetch seller_id from tbl_seller where user_id = user_id
    $sellerQuery = "SELECT seller_id FROM tbl_seller WHERE user_id = ?";
    $sellerStmt = mysqli_prepare($conn, $sellerQuery);
    mysqli_stmt_bind_param($sellerStmt, "i", $userId);

    if (mysqli_stmt_execute($sellerStmt)) {
        $sellerResult = mysqli_stmt_get_result($sellerStmt);
        $sellerRow = mysqli_fetch_assoc($sellerResult);
        $sellerId = $sellerRow['seller_id'];

        // Check if the form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
            // Retrieve data from the form
            $productName = $_POST['productName'];
            $category_id = $_POST['category'];
            $subcategory_id = $_POST['subcategory'];
            $material = $_POST['material'];
            $dimension = $_POST['dimension'];
            $weight = $_POST['weight'];
            $usageDescription = $_POST['usage'];
            $careInstruction = $_POST['description'];

            // Get the count of rows
            $count = count($_POST['size']);

            // Initialize variables for the first product and first product detail
            $firstProductId = null;
            $firstProductDetailId = null;

            // Loop through each row
            for ($i = 0; $i < $count; $i++) {
                // Retrieve data for the current row
                $size = $_POST['size'][$i];
                $color = $_POST['color'][$i];
                $stock = $_POST['stock'][$i];
                $price = $_POST['price'][$i];
                $imageData = file_get_contents($_FILES['image']['tmp_name'][$i]);

                // Insert data into tbl_product for the first row
                if ($i == 0) {
                    $insertProductQuery = "INSERT INTO tbl_product (seller_id, subcategory_id, product_name, price, is_available, image) VALUES (?, ?, ?, ?, 1, ?)";
                    $stmt = mysqli_prepare($conn, $insertProductQuery);
                    mysqli_stmt_bind_param($stmt, "iisds", $sellerId, $subcategory_id, $productName, $price, $imageData);

                    if (mysqli_stmt_execute($stmt)) {
                        $firstProductId = mysqli_insert_id($conn);

                        // Insert data into tbl_productdescription for the first row
                        $insertDescriptionQuery = "INSERT INTO tbl_productdescription (product_id, colour, usage_description, weight, care_instruction, material, dimension) VALUES (?, ?, ?, ?, ?, ?, ?)";
                        $stmt = mysqli_prepare($conn, $insertDescriptionQuery);
                        mysqli_stmt_bind_param($stmt, "issssss", $firstProductId, $color, $usageDescription, $weight, $careInstruction, $material, $dimension);

                        if (mysqli_stmt_execute($stmt)) {
                            $firstProductDetailId = mysqli_insert_id($conn);
                        } else {
                            echo '<script>alert("Error inserting product description for the first row: ' . mysqli_error($conn) . '")</script>';
                            exit;
                        }
                    } else {
                        echo '<script>alert("Error inserting product for the first row: ' . mysqli_error($conn) . '")</script>';
                        exit;
                    }
                }

                // Insert data into tbl_productdetail
                $insertDetailQuery = "INSERT INTO tbl_productdetail (size, colour, stock, is_available, product_id, new_price, image) VALUES (?, ?, ?, 1, ?, ?, ?)";
                $stmt = mysqli_prepare($conn, $insertDetailQuery);
                mysqli_stmt_bind_param($stmt, "ssissb", $size, $color, $stock, $firstProductId, $price, $imageData);

                if (mysqli_stmt_execute($stmt)) {
                    // Insert all images associated with the current row into tbl_image using detail_id
                    $productDetailId = mysqli_insert_id($conn);
                    $insertImageQuery = "INSERT INTO tbl_image (detail_id, image) VALUES (?, ?)";
                    $stmt = mysqli_prepare($conn, $insertImageQuery);
                    mysqli_stmt_bind_param($stmt, "is", $productDetailId, $imageData);

                    if (!mysqli_stmt_execute($stmt)) {
                        echo '<script>alert("Error inserting image for row ' . ($i + 1) . ': ' . mysqli_error($conn) . '")</script>';
                        exit;
                    }
                } else {
                    echo '<script>alert("Error inserting product detail for row ' . ($i + 1) . ': ' . mysqli_error($conn) . '")</script>';
                    exit;
                }
            }

            // Respond with a success message and redirect to dashboard.php
            echo '<script>alert("Product(s) added successfully.")</script>';
            header('location: dashboard.php');
            exit();
        }
    }
} else {
    echo '<script>alert("Error fetching seller_id: ' . mysqli_error($conn) . '")</script>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="../libs/bower/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.css">
    <!-- build:css assets/css/app.min.css -->
    <link rel="stylesheet" href="../libs/bower/animate.css/animate.min.css">
    <link rel="stylesheet" href="../libs/bower/fullcalendar/dist/fullcalendar.min.css">
    <link rel="stylesheet" href="../libs/bower/perfect-scrollbar/css/perfect-scrollbar.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/core.css">
    <link rel="stylesheet" href="../assets/css/app.css">
    <!-- endbuild -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="../libs/bower/breakpoints.js/dist/breakpoints.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        Breakpoints();
    </script>
    <style>
        /* Style for "Choose Files" button */
        .form-control {
            margin-top: 3px;
            margin-bottom: 3px;
        }

        .add-image {
            text-decoration: none;
            /* Remove underline for links */
            margin-right: 5px;
            margin-top: 1px;
            border: 1px solid black;
            /* Black border */
            color: black;
            background-color: transparent;
        }

        .add-image:hover {
            background-color: black;
            /* Black background on hover */
            color: white;
            /* White text color on hover */
        }

        .remove-image,
        .remove-row {
            text-decoration: none;
            /* Remove underline for links */
            margin-top: 3px;
            margin-right: 5px;
            margin-bottom: 5px;
            padding: 0.5rem 1rem;
            /* Optional padding for buttons */
            border: 1px solid red;
            /* Red border */
            color: red;
            /* Red text color */
            background-color: transparent;
            /* Transparent background */
        }

        .remove-image:hover,
        .remove-row:hover {
            background-color: red;
            /* Red background on hover */
            color: white;
            /* White text color on hover */
        }
    </style>
</head>
<body class="menubar-left menubar-unfold menubar-light theme-primary style='background-color: white'">

<!-- Rest of your HTML code remains the same -->
    <?php include_once('header.php');?>

    <?php include_once('sidebar.php');?>

    <!-- APP MAIN ==========-->
<main id="app-main" class="app-main">
    <div class="wrap">
        <section class="app-content">
            <div class="row">

                <div class="col-md-12">
                    <div class="widget">
                        <header class="widget-header">
                            <h3 class="widget-title">Add your Product</h3>
                        </header><!-- .widget-header -->
                        <hr class="widget-separator">
                        <div class="widget-body">
                            <form class="form-horizontal" name="addProduct" id="addProduct" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="productName" class="col-sm-3 control-label">Product Name:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="productName" id="productName" required="true">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="category" class="col-sm-3 control-label">Apparel Category:</label>
                                    <div class="col-sm-9">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <!-- Category Dropdown -->

                                                <select class="form-control" id="category" name="category" required onchange="loadSubcategories()">
                                                    <option value="" disabled selected>Select Category</option>
                                                    <?php
                                                    // Query to fetch categories from tbl_category
                                                    $categoryQuery = "SELECT category_id, category_name FROM tbl_category WHERE status = 1";
                                                    $categoryStmt = $conn->prepare($categoryQuery);
                                                    $categoryStmt->execute();
                                                    $categoryResult = $categoryStmt->get_result();

                                                    if ($categoryResult && $categoryResult->num_rows > 0) {
                                                        while ($categoryRow = $categoryResult->fetch_assoc()) {
                                                            $categoryId = $categoryRow["category_id"]; // Corrected variable name
                                                            $categoryName = $categoryRow["category_name"];
                                                            echo "<option value='$categoryId'>$categoryName</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                            <div id="subcategory-container" class="col-md-6">

                                                <!-- Subcategory Dropdown -->

                                                <select class="form-control" id="subcategory" name="subcategory" required>
                                                    <option value="" disabled selected>Select Subcategory</option>
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="material" class="col-sm-3 control-label">General Details:</label>
                                    <div class="col-sm-9">
                                        <div class="row">
                                            <div class="product-details-row col-md-4">
                                                <input type="text" class="form-control" placeholder="Material" name="material" id="material" required="true">
                                            </div>
                                            <div class="product-details-row col-md-4">
                                                <input type="text" class="form-control" placeholder="Dimension" name="dimension" id="dimension" required="true">
                                            </div>
                                            <div class="product-details-row col-md-4">
                                                <input type="text" class="form-control" placeholder="Weight" name="weight" id="weight" required="true">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="usage" class="col-sm-3 control-label">Instructions:</label>
                                    <div class="col-sm-9">
                                        <div class="product-details-row">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" placeholder="Usage Description" name="usage" id="usage" required="true">
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" placeholder="Additional Description" name="description" id="description" required="true">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
<!-- Product Details Section -->
<br>
<div class="form-group">
    <div id = "detailsContainer">
    <header class="widget-header">
                            <h3 class="widget-title">Product Details</h3>
                        </header><!-- .widget-header -->
                        <hr class="widget-separator">
                        <div class="widget-body">
                        <table id="productTable" class="table table-bordered">
        <tr>
            <th>Size</th>
            <th>Colour</th>
            <th>Stock</th>
            <th>Price</th>
            <th>Images</th>
        </tr>
        <tr>
            <td>
            <select class="form-control" name="size[]" required default="Free Size">
                    <option value="" disabled selected>Select Size</option>
                    <option value="S">S</option>
                    <option value="XS">XS</option>
                    <option value="X">X</option>
                    <option value="XXL">XXL</option>
                    <option value="L">L</option>
                    <option value="M">M</option>
                    <option value="Free Size">Free Size</option>
                </select>
            </td>
            <td><select class="form-control" id="color" name="color[]" required>
                    <option value="" disabled selected>Select Colour</option>
                    <?php
                    // Query to fetch colors from your database (adjust this query as needed)
                    $sql = "SELECT colour_id, colour FROM tbl_colour";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $colour_id = $row['colour_id'];
                            $colour_name = $row['colour'];
                            echo "<option value='$colour_name'>$colour_name</option>";
                        }
                    } else {
                        echo "<option value='' disabled>No colours available</option>";
                    }
                    ?>
                </select></td>
            <td><input type="number" min = 1 name="stock[]" class="form-control" required></td>
            <td><input type="number" min = 1 name="price[]" class="form-control" required></td>
            <td>
                <input type="file" accept="image/*" name="image[]" class="form-control" required>
                <button type="button" class="add-image btn btn-primary">Add Image</button>
            </td>
        </tr>
    </table>
    <button class="btn btn-link text-primary mt-3" type="button" id="addRow" style="text-decoration:none;">+ Add New Row</button>
    </div>
</div>
                                
                                <div class="form-group">
                                    <div class="col-sm-9 col-sm-offset-3">
                                        <button type="submit" class="btn btn-success" name="submit">Add Product</button>
                                    </div>
                                </div>  
                            </form>
                        </div><!-- .widget-body -->
                    </div><!-- .widget -->
                </div><!-- END column -->
            </div><!-- .row -->
        </section><!-- #dash-content -->
    </div><!-- .wrap -->

    <!-- APP FOOTER -->
    <?php include_once('footer.php');?>
    <!-- /#app-footer -->
</main>

    <!--========== END app main -->

        <!-- build:js assets/js/core.min.js -->
        <script src="../libs/bower/jquery/dist/jquery.js"></script>
        <script src="../libs/bower/jquery-ui/jquery-ui.min.js"></script>
        <script src="../libs/bower/jQuery-Storage-API/jquery.storageapi.min.js"></script>
        <script src="../libs/bower/bootstrap-sass/assets/javascripts/bootstrap.js"></script>
        <script src="../libs/bower/jquery-slimscroll/jquery.slimscroll.js"></script>
        <script src="../libs/bower/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
        <script src="../libs/bower/PACE/pace.min.js"></script>
        <!-- endbuild -->

        <!-- build:js assets/js/app.min.js -->
        <script src="../assets/js/library.js"></script>
        <script src="../assets/js/plugins.js"></script>
        <script src="../assets/js/app.js"></script>
        <!-- endbuild -->
        <script src="../libs/bower/moment/moment.js"></script>
        <script src="../libs/bower/fullcalendar/dist/fullcalendar.min.js"></script>
        <script src="../assets/js/fullcalendar.js"></script>
        <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    

<!-- Include jQuery -->
<!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> -->
<script>
document.getElementById("addRow").addEventListener("click", function () {
    var table = document.getElementById("productTable");
    var row = table.insertRow(-1);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    var cell5 = row.insertCell(4);

    cell1.innerHTML = `
        <select class="form-control" name="size[]" required default="Free Size">
            <option value="" disabled selected>Select Size</option>
            <option value="S">S</option>
            <option value="XS">XS</option>
            <option value="X">X</option>
            <option value="XXL">XXL</option>
            <option value="L">L</option>
            <option value="M">M</option>
            <option value="Free Size">Free Size</option>
        </select>`;
    cell2.innerHTML = `
        <select class="form-control" name="color[]" required>
            <option value="" disabled selected>Select Colour</option>
            <?php
            // Query to fetch colors from your database (adjust this query as needed)
            $sql = "SELECT colour_id, colour FROM tbl_colour";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $colour_id = $row['colour_id'];
                    $colour_name = $row['colour'];
                    echo "<option value='$colour_name'>$colour_name</option>";
                }
            } else {
                echo "<option value='' disabled>No colours available</option>";
            }
            ?>
        </select>`;
    cell3.innerHTML = '<input type="number" min="1" name="stock[]" required class="form-control">';
    cell4.innerHTML = '<input type="number" min="1" name="price[]" required class="form-control">';
    cell5.innerHTML = '<input type="file" accept="image/*" name="image[]" required class="form-control">' +
        '<button type="button" class="add-image btn btn-primary">Add Image</button> &nbsp;' +
        '<button type="button" class="remove-row btn btn-danger">Remove Row</button>';
});

document.getElementById("productTable").addEventListener("click", function (e) {
    if (e.target && e.target.className == "remove-row btn btn-danger") {
        var row = e.target.parentNode.parentNode;
        row.parentNode.removeChild(row);
    } else if (e.target && e.target.className == "add-image btn btn-primary") {
        var cell = e.target.parentNode;
        var inputFile = document.createElement("input");
        inputFile.type = "file";
        inputFile.name = "image[]";
        inputFile.className = "form-control";
        inputFile.accept = "image/*";
        var removeImageBtn = document.createElement("button");
        removeImageBtn.type = "button";
        removeImageBtn.className = "remove-image btn btn-danger";
        removeImageBtn.textContent = "Remove Image";
        removeImageBtn.addEventListener("click", function () {
            cell.removeChild(inputFile);
            cell.removeChild(removeImageBtn);
        });
        cell.insertBefore(inputFile, e.target);
        cell.insertBefore(removeImageBtn, e.target);
    } else if (e.target && e.target.className == "remove-image btn btn-danger") {
        var cell = e.target.parentNode;
        cell.removeChild(e.target); // Remove the "Remove Image" button
        cell.removeChild(cell.querySelector('input[type="file"]'));
    }
});
</script>
<script>

function loadSubcategories() {
    const selectedCategoryId = $("#category").val(); // Get the selected category ID
    const subcategoryDropdown = $("#subcategory");

    // Clear existing options
    subcategoryDropdown.empty();
    subcategoryDropdown.append('<option value="" disabled selected>Select Subcategory</option>');

    try {
        if (selectedCategoryId) {
            console.log(selectedCategoryId);

            // Send an AJAX request to fetch subcategories based on the selected category ID
            $.ajax({
                url: `fetch_subcategories.php?category_id=${selectedCategoryId}`, // Pass the selected category ID
                type: "GET",
                dataType: "json",
                success: function (data) {
                    // Populate the Subcategory dropdown with fetched data
                    if (data) {
                        $.each(data, function (key, value) {
                            subcategoryDropdown.append($('<option>', {
                                value: value.subcategory_id, // Use subcategory_id as the value
                                text: value.subcategory_name // Display subcategory_name as the text
                            }));
                        });
                    }
                    console.log("Data", data);
                },
                error: function (xhr, status, error) {
                    console.log("AJAX Error:", status, error);
                },
            });
        }
    } catch (err) {
        console.log(err);
    }
}
</script>
  </body>
    </html>
