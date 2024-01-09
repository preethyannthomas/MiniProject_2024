<?php
// Include the database connection file
include("../connection.php");

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $mobile = $_POST["mobile"];
    $companyName = $_POST["company_name"];
    $companyEmail = $_POST["company_email"];
    $password = md5($_POST["password"]);
    $gstin = $_POST["gstin"];
    $addressLine = $_POST["address_line2"];
    $area = $_POST["area"];
    $city = $_POST["city"];
    $state = $_POST["state"];
    $zip = $_POST["zip"];
    $role = 2; // Default role

    // Check if the email and GSTIN do not exist in the database
    $checkEmailQuery = "SELECT * FROM tbl_user WHERE email = '$companyEmail'";
    $checkGstinQuery = "SELECT * FROM tbl_seller WHERE gstin = '$gstin'";

    $emailResult = $conn->query($checkEmailQuery);
    $gstinResult = $conn->query($checkGstinQuery);

    if ($emailResult->num_rows > 0) {
        echo '<script>alert("Email already exists.")</script>';
    } elseif ($gstinResult->num_rows > 0) {
        echo '<script>alert("GSTIN already exists.")</script>';
    } else {
        // Insert data into the users table
        $insertUserQuery = "INSERT INTO tbl_user (email, password, role, status) VALUES ('$companyEmail', '$password', $role, 1)";
        $conn->query($insertUserQuery);

        // Get the user ID of the newly inserted user
        $userId = $conn->insert_id;

        // Insert data into the sellers table
        $insertSellerQuery = "INSERT INTO tbl_seller (user_id, seller_name, company_name, contact_no,gstin) VALUES ($userId, '$name', '$companyName', '$mobile','$gstin')";
        $conn->query($insertSellerQuery);

        // Insert data into the addresses table
        $insertAddressQuery = "INSERT INTO tbl_address (user_id, name, mobile_number, pincode, address, area, city, state) VALUES ($userId, '$name', '$mobile', '$zip', '$addressLine', '$area', '$city', '$state')";
        $conn->query($insertAddressQuery);

        // Redirect to the login page
        header("Location: login.php");
        exit();
    }
    
    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/font-awesome.css">
    <link rel="stylesheet" href="../css/templatemo-hexashop.css">
    <link rel="stylesheet" href="../css/owl-carousel.css">
    <link rel="stylesheet" href="../css/lightbox.css">
    <link rel="stylesheet" href="../css/sellerHome.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="../js/sellerHome.js"></script>
    <title>Careers</title>
    <style>
        * {
            font-size: 18px;
        }

        body {
            font-style: italic;
            font-family: 'Times, Times New Roman, serif';
        }

        .highlight-box {
            border: 2px solid #a8b0bc;
            /* Border color */
            padding: 10px;

            /* Padding inside the box */
            background-color: #d7eced;
            /* Background color */
            display: inline-block;
            /* Display as an inline box */
        }

        /* Optional: Style for the equation text */
        .equation {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .faq-container {

            margin: 0 auto;
        }

        .faq-item {
            margin-bottom: 5px;
        }

        .faq-question {
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            font-weight: bold;
            padding: 10px;
            background-color: white;
        }

        .faq-answer {
            display: none;
            padding: 10px;
            border-top: 1px solid #ccc;
            background-color: #f0f0f0;
        }

        .arrow {
            width: 0;
            height: 0;
            border: 4px solid transparent;
            border-bottom-color: black;

            transform: rotate(180deg);
            /* Set the initial rotation */
            transition: transform 0.3s ease-in-out;
        }
        .error_form{
            color:red;
        }
        .open .arrow {
            transform: rotate(0deg);
        }
    </style>
</head>

<body onload="load()">


    <!-- ***** Header Area Start ***** -->
    <header class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        <a href="../index.php" class="logo">
                            <img src="../images/logo.png">
                        </a>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Menu Start ***** -->

                        <ul class="nav" style="font-size: 18px;">
                            <li class="scroll-to-section" id="learning"><a href = "about.php">About SwapZone</a></li>
                            <li class="scroll-to-section" id="learning"><a href = "life.php">Life at SwapZone</a></li>
                            <li class="scroll-to-section" id="learning"><a>Jobs</a></li>
                            <li class="submenu" id="createAccount">
                                <a href="interview.php">Interviewing at SwapZone</a>
                                <ul>
                                    <li><a href="#listProducts">Know your Team</a></li>
                                    <li><a href="#Storage">How we hire</a></li>
                                    <li><a href="#receive">Interview Resources</a></li>
                                </ul>
                            </li>
                            <li class="scroll-to-section" id="learning"><a href = "../login.php">Candidate Login</a></li>
                        </ul>
                        <a class='menu-trigger'>
                            <span>Menu</span>
                        </a>
                        <!-- ***** Menu End ***** -->
                    </nav>
                </div>
            </div>
        </div>
    </header>
 
    <!-- Plugins -->
    <script src="../js/owl-carousel.js"></script>
    <script src="../js/accordions.js"></script>
    <script src="../js/datepicker.js"></script>
    <script src="../js/scrollreveal.min.js"></script>
    <script src="../js/waypoints.min.js"></script>
    <script src="../js/jquery.counterup.min.js"></script>
    <script src="../js/imgfix.min.js"></script>
    <script src="../js/slick.js"></script>
    <script src="../js/lightbox.js"></script>
    <script src="../js/isotope.js"></script>

    <!-- Global Init -->
    <script src="../js/custom.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>