<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('location:./');
}
require 'connection.php'; 
if (isset($_GET['address_id'])) {
    $addressId = $_GET['address_id'];

    $selectQuery = "SELECT * FROM tbl_address WHERE address_id = '$addressId'";
    $result = mysqli_query($conn, $selectQuery);
    $addressData = mysqli_fetch_assoc($result);
    mysqli_free_result($result);

 
}
if (isset($_POST['submit'])) {
    $user_id = $_SESSION['user_id'];
    $name = $_POST['name'];
    $mobile_number = $_POST['phone'];
    $pincode = $_POST['pincode'];
    $address = $_POST['flat'] ;
    $area = $_POST['area'];
    $city = $_POST['town'];
    $state = $_POST['state'];
    $query = "UPDATE tbl_address set user_id = '$user_id', name = '$name', mobile_number = '$mobile_number', 
    pincode = '$pincode', address = '$address',area = '$area', city = '$city', state = '$state' where address_id = '$addressId'";

    if (mysqli_query($conn, $query)) {
        echo '<script>alert("Address added successfully!");</script>';
        header("Location: profile.php");
    } else {
        echo '<script>alert("Error adding address!");</script>';
    }
    
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a New Address</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="images/logo.png">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.css">
    <link rel="stylesheet" href="css/templatemo-hexashop.css">
    <link rel="stylesheet" href="css/owl-carousel.css">
    <link rel="stylesheet" href="css/lightbox.css">
    <style>
    #sec{
      
        height: 90vh;
    }

    .sec-container {
        margin-top: 60px;
        border-radius: 20px;
        margin-bottom:80px;    }

    .login-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 40px;
       
        border-radius: 20px;
        opacity: 0.9;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .login-container h2 {
        text-align: center;
        margin-bottom: 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        font-weight: bold;
    }

    .form-group input {
        width: 100%;
        padding: 10px;
        border: 1px solid pink;
        border-radius: 20px;
    }

    .btn-login {
        display: block;
        width: 100%;
        padding: 10px;
        color: #ffffff;
        background: #392626;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: 0.4s linear;
        border: none;
        border-radius: 10px;
        border-color: #131312;
        text-align: center;
        text-decoration: none;
    }

    .btn-login:hover {
        color: #ffffff;
        background: #080808;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: 0.4s linear;
    }

    .bold-on-hover {
        font-weight: normal;
        transition: font-weight 0.2s ease;
    }

    .bold-on-hover:hover,
    .bold-on-hover:active,
    .bold-on-hover:visited {
        font-weight: bold;
        text-decoration: none;
    }

    .error {
        color: red;
        font-size: 14px;
        margin-top: 5px;
    }
</style>
</head>
<body>
<header class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
           
                        <a href="index.html" class="logo">
                            <img src="images/logo.png">
                        </a>
          
                        <ul class="nav">
                            <li class="scroll-to-section"><a href="productList.php?category_id=4">Home</a></li>
                            <li class="scroll-to-section"><a href="productList.php?category_id=1">Men</a></li>
                            <li class="scroll-to-section"><a href="productList.php?category_id=2">Women</a></li>
                            <li class="scroll-to-section"><a href="productList.php?category_id=3">Kids</a></li>
                            <li class="submenu" id="#updateProfile" onclick="updateProfile()">
                                <a href="#paymentCycle"><i class="fas fa-user"></i></a>
                                <ul>
                                    <li><a href="#paymentCycle">Your Profile</a></li>
                                    <li><a href="#paymentCycle">Cart</a></li>
                                    <li><a href="wishList.php">Wishlist</a></li>
                                    <li><a href="#fees">Your Orders</a></li>
                                    <li><a href="logout.php">Log Out</a></li>
                                </ul>
                            </li>

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

<section id = "sec"><br><br><br>
      <div class="sec-container">
      <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="login-container">
                  <form method="post" id="addressForm">
          
                <input type="text" class="form-control" name = "name" id="uname"  value="<?php echo $addressData['name']; ?>">
                <span id="errorName" style="color: red"></span>
                <br>
             
                <input type="text" class="form-control" name = "phone" id="phone"  value="<?php echo $addressData['mobile_number']; ?>" pattern="[0-9]{10}" >
                <span id="errorPhone" style="color: red"></span>
            <br>
             
                    <input type="text" class="form-control" name = "pincode" id="pincode" value="<?php echo $addressData['pincode']; ?>" >
                    <span id="errorPincode" style="color: red"></span>
            <br>
                    <input type="text" class="form-control" name = "flat" id="flat" value="<?php echo $addressData['address']; ?>">
                    <span id="errorFlat" style="color: red"></span>
                
          <br>
                <input type="text" class="form-control" name = "area" id="area"  value="<?php echo $addressData['area']; ?>">
                <span id="errorArea" style="color: red"></span>
            
               <br>
                    <input type="text" class="form-control" name = "town" id="town"  value="<?php echo $addressData['city']; ?>">
                    <span id="errorTown" style="color: red"></span>
                 <br>
                <select name="state" id="state" class="form-control" placeholder="<?php echo $addressData['state']; ?>" required>
                                                    <option value="Andhra Pradesh">Andhra Pradesh</option>
                                                    <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                                    <option value="Assam">Assam</option>
                                                    <option value="Bihar">Bihar</option>
                                                    <option value="Chhattisgarh">Chhattisgarh</option>
                                                    <option value="Goa">Goa</option>
                                                    <option value="Gujarat">Gujarat</option>
                                                    <option value="Haryana">Haryana</option>
                                                    <option value="Himachal Pradesh">Himachal Pradesh</option>
                                                    <option value="Jharkhand">Jharkhand</option>
                                                    <option value="Karnataka">Karnataka</option>
                                                    <option value="Kerala" selected>Kerala</option>
                                                    <option value="Madhya Pradesh">Madhya Pradesh</option>
                                                    <option value="Maharashtra">Maharashtra</option>
                                                    <option value="Manipur">Manipur</option>
                                                    <option value="Meghalaya">Meghalaya</option>
                                                    <option value="Mizoram">Mizoram</option>
                                                    <option value="Nagaland">Nagaland</option>
                                                    <option value="Odisha">Odisha</option>
                                                    <option value="Punjab">Punjab</option>
                                                    <option value="Rajasthan">Rajasthan</option>
                                                    <option value="Sikkim">Sikkim</option>
                                                    <option value="Tamil Nadu">Tamil Nadu</option>
                                                    <option value="Telangana">Telangana</option>
                                                    <option value="Tripura">Tripura</option>
                                                    <option value="Uttar Pradesh">Uttar Pradesh</option>
                                                    <option value="Uttarakhand">Uttarakhand</option>
                                                    <option value="West Bengal">West Bengal</option>
                     </select>
            <br>
            <button type="submit" name = "submit" class="btn-login">Update Address</button>
        </form>
        
</div>
</div>
</div>
</section>
<footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="first-item">
                        <div class="logo">
                            <img src="images/white-logo.png" alt="SwapZone">
                        </div>
                        <ul>
                            <li><a href="#">SwapZone, Kochi</a></li>
                            <li><a href="#">SwapZone@gmail.com</a></li>
                            <li><a href="#">+91 9548782431</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <h4>Shopping &amp; Categories</h4>
                    <ul>
                        <li><a href="#">Men’s Shopping</a></li>
                        <li><a href="#">Women’s Shopping</a></li>
                        <li><a href="#">Kid's Shopping</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h4>Useful Links</h4>
                    <ul>
                        <li><a href="#">Homepage</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Help</a></li>
                        <li><a href="#">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h4>Help &amp; Information</h4>
                    <ul>
                        <li><a href="#">Help</a></li>
                        <li><a href="#">FAQ's</a></li>
                        <li><a href="#">Shipping</a></li>
                        <li><a href="#">Tracking ID</a></li>
                    </ul>
                </div>
                <div class="col-lg-12">
                    <div class="under-footer">
                        <p>Copyright © 2022 SwapZone Co., Ltd. All Rights Reserved. </p>
                        <ul>
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            <li><a href="#"><i class="fa fa-behance"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Include Bootstrap JS and jQuery -->
    <script src="js/myscripts.js"> </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const nameInput = document.getElementById("uname");
        const nameError = document.getElementById("errorName");
         const phoneInput = document.getElementById("phone");
        const phoneError = document.getElementById("errorPhone");
        const pincodeInput = document.getElementById("pincode");
        const pincodeError = document.getElementById("errorPincode");
        const flatInput = document.getElementById("flat");
        const flatError = document.getElementById("errorFlat");
        const areaInput = document.getElementById("area");
        const areaError = document.getElementById("errorArea");
        const townInput = document.getElementById("town");
        const townError = document.getElementById("errorTown");
        const form = document.getElementById("addressForm");

        form.addEventListener("submit", function (event) {
            if (!isValidForm()) {
                event.preventDefault();
                alert("Please fill in all fields correctly.");
            }
        });

        function isValidForm() {
            return (
                isValidName(nameInput.value) &&
                isValidtown(townInput.value) &&
                isValidPhone(phoneInput.value) &&
                isValidPincode(pincodeInput.value) &&
                isValidFlat(flatInput.value) &&
                isValidArea(areaInput.value)
            );
        }

        nameInput.addEventListener("input", function () {
            if (!isValidName(nameInput.value)) {
                nameError.textContent = "Name field required only alphabet characters";
            } else {
                nameError.textContent = "";
            }
        });

        phoneInput.addEventListener("input", function () {
            if (!isValidPhone(phoneInput.value)) {
                phoneError.textContent = "Enter a valid mobile number (10 digits)";
            } else {
                phoneError.textContent = "";
            }
        });

        pincodeInput.addEventListener("input", function () {
            if (!isValidPincode(pincodeInput.value)) {
                pincodeError.textContent = "Enter valid pin";
            } else {
                pincodeError.textContent = "";
            }
        });

        flatInput.addEventListener("input", function () {
            if (!isValidFlat(flatInput.value)) {
                flatError.textContent = "Field is required";
            } else {
                flatError.textContent = "";
            }
        });

        areaInput.addEventListener("input", function () {
            if (!isValidArea(areaInput.value)) {
                areaError.textContent = "Field is required";
            } else {
                areaError.textContent = "";
            }
        });
        townInput.addEventListener("input", function () {
            if (!isValidArea(townInput.value)) {
                areaError.textContent = "Field is required";
            } else {
                areaError.textContent = "";
            }
        });

        function isValidName(name) {
            const namePattern = /^[A-Za-z\s]+$/;
            return namePattern.test(name);
        }

        function isValidEmail(email) {
            const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
            return emailPattern.test(email);
        }

        function isValidPhone(phone) {
            const phonePattern = /^[6-9]\d{9}$/;
            return phonePattern.test(phone);
        }

        function isValidPincode(pincode) {
            const postPattern = /^[1-9][0-9]{5}$/;
            return postPattern.test(pincode);
        }

        function isValidFlat(flat) {
          const flatPattern = /[A-Za-z0-9'\.\-\s\,]/;
                return flatPattern.test(flat);
        }

        function isValidArea(area) {
          const townPattern = /^[A-Za-z\s]+$/;
          return townPattern.test(area);
        }
        function isValidtown(town) {
          const namePattern = /^[A-Za-z\s]+$/;
          return namePattern.test(town);
        }
    });
</script>
</html>