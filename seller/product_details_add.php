<!DOCTYPE html>
<html>
<head>
    <title>Dynamic Table Rows</title>
    <!-- Include Bootstrap CSS -->
    <style>
        .form-control{
            margin-top:3px;
            margin-bottom: 3px;
        }
        .add-image{
            text-decoration: none; /* Remove underline for links */
            margin-right:5px;
            margin-top: 1px; /* 2rem top margin */
            /* Optional padding for buttons */
            border: 1px solid black; /* Black border */
    color: black; /* Black text color */
    background-color: transparent; 
        }
        .add-image:hover {
    background-color: black; /* Black background on hover */
    color: white; /* White text color on hover */
  }
  .remove-image, .remove-row {
    text-decoration: none; /* Remove underline for links */
    margin-top: 3px; /* 2rem top margin */
    margin-right:5px;
    margin-bottom:5px;
            padding: 0.5rem 1rem; /* Optional padding for buttons */
    border: 1px solid red; /* Red border */
    color: red; /* Red text color */
    background-color: transparent; /* Transparent background */
  }

  .remove-image:hover , .remove-row:hover{
    background-color: red; /* Red background on hover */
    color: white; /* White text color on hover */
  }
  
    </style>
    
</head>
<body>

   
                 
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
                <select class="form-control" name="size[]" required>
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
        <select class="form-control" name="size[]" required>
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

    // Ensure unique names for file inputs in the new row
    var fileInputs = row.querySelectorAll('input[type="file"]');
    fileInputs[0].name = "image[]";
    fileInputs[1].name = "image[]";
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
                inputFile.accept="image/*";
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
</body>
</html>
