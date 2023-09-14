<?php
// Include the database connection file
include("../connection.php");

// Fetch admin's products from tbl_product
session_start();
if (!isset($_SESSION['user_id'])) {
    header('location:./');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch address details from tbl_address
$addressQuery = "SELECT * FROM tbl_address WHERE user_id = $user_id";
$addressResult = $conn->query($addressQuery);

if ($addressResult->num_rows == 1) {
    $addressRow = $addressResult->fetch_assoc();
}else {
    // Address not present, set default values
    $addressRow = [
        'address' => '',
        'area' => '',
        'city' => '',
        'state' => '',
        'pincode' => '',
        'mobile_number' => '',
    ];
}

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Get form data
    $address = $_POST['address'];
    $area = $_POST['area'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $pincode = $_POST['pincode'];
    $mobile = $_POST['mobile'];

    // Check if the user has an existing address
    if ($addressResult->num_rows == 0) {
        // If no existing address, insert a new address
        $insertQuery = "INSERT INTO tbl_address (user_id, address, area, city, state, pincode, mobile_number) VALUES ('$user_id', '$address', '$area', '$city', '$state', '$pincode', '$mobile')";
        $conn->query($insertQuery);
    } else {
        // If an address exists, update it
        $updateQuery = "UPDATE tbl_address SET address = '$address', area = '$area', city = '$city', state = '$state', pincode = '$pincode', mobile_number = '$mobile' WHERE user_id = '$user_id'";
        $conn->query($updateQuery);
    }

    // Redirect to adminProfile.php
    header('Location: adminProfile.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  
  <title>Change Address</title>
  
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
  <script src="../libs/bower/breakpoints.js/dist/breakpoints.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script>
    Breakpoints();
  </script>
  <style>
    .error-message{
        color: red;
    }
  </style>
  <script type="text/javascript">

function checkpass()
{
if(document.changepassword.newpassword.value!=document.changepassword.confirmpassword.value)
{
alert('New Password and Confirm Password field does not match');
document.changepassword.confirmpassword.focus();
return false;
}
return true;
}   

</script>
</head>
  
<body class="menubar-left menubar-unfold menubar-light theme-primary">
<!--============= start main area -->

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
            <h3 class="widget-title">Change Address</h3>
          </header><!-- .widget-header -->
          <hr class="widget-separator">
          <div class="widget-body">    
            <form class="form-horizontal" name="editAddressForm" method="post">
                <div class="form-group">
                    <label for="address" class="col-sm-3 control-label">Address:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="address" id="address" required="true" value="<?php echo $addressRow['address']; ?>">
                        <span class="error-message" id="addressError"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="area" class="col-sm-3 control-label">Area:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="area" id="area" required="true" value="<?php echo $addressRow['area']; ?>">
                        <span class="error-message" id="areaError"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="city" class="col-sm-3 control-label">City:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="city" id="city" required="true" value="<?php echo $addressRow['city']; ?>">
                        <span class="error-message" id="cityError"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="state" class="col-sm-3 control-label">State:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="state" id="state" required="true" value="<?php echo $addressRow['state']; ?>">
                        <span class="error-message" id="stateError"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="pincode" class="col-sm-3 control-label">Pincode:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="pincode" id="pincode" required="true" value="<?php echo $addressRow['pincode']; ?>">
                        <span class="error-message" id="pincodeError"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="mobile" class="col-sm-3 control-label">Mobile Number:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="mobile" id="mobile" required="true" value="<?php echo $addressRow['mobile_number']; ?>">
                        <span class="error-message" id="mobileError"></span>
                    </div>
                </div>

                <!-- Add more fields if needed -->

                <div class="row">
                    <div class="col-sm-9 col-sm-offset-3">
                        <button type="submit" class="btn btn-success" name="submit">Save Changes</button>
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
  <!-- SIDE PANEL -->
 

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
  <script>
    document.addEventListener("DOMContentLoaded", function () {

        const addressInput = document.getElementById("address");
        const areaInput = document.getElementById("area");
        const cityInput = document.getElementById("city");
        const stateInput = document.getElementById("state");
        const pincodeInput = document.getElementById("pincode");
        const mobileInput = document.getElementById("mobile");
        const addressError = document.getElementById("addressError");
        const areaError = document.getElementById("areaError");
        const cityError = document.getElementById("cityError");
        const stateError = document.getElementById("stateError");
        const pincodeError = document.getElementById("pincodeError");
        const mobileError = document.getElementById("mobileError");
        const editAddressForm = document.forms.editAddressForm;

        editAddressForm.addEventListener("submit", function (event) {
            if (!isValidForm()) {
                event.preventDefault(); // Prevent form submission
                alert("Please fill in all fields correctly.");
            }
        });

        function isValidForm() {
            return (
                isValidAddress(addressInput.value) &&
                isValidArea(areaInput.value) &&
                isValidCity(cityInput.value) &&
                isValidState(stateInput.value) &&
                isValidPincode(pincodeInput.value) &&
                isValidMobileNumber(mobileInput.value)
            );
        }

        addressInput.addEventListener("input", function () {
            validateAddress();
        });

        areaInput.addEventListener("input", function () {
            validateArea();
        });

        cityInput.addEventListener("input", function () {
            validateCity();
        });

        stateInput.addEventListener("input", function () {
            validateState();
        });

        pincodeInput.addEventListener("input", function () {
            validatePincode();
        });

        mobileInput.addEventListener("input", function () {
            validateMobileNumber();
        });

        function validateAddress() {
            if (!isValidAddress(addressInput.value)) {
                addressError.textContent = "Invalid address";
            } else {
                addressError.textContent = "";
            }
        }

        function validateArea() {
            if (!isValidArea(areaInput.value)) {
                areaError.textContent = "Invalid area";
            } else {
                areaError.textContent = "";
            }
        }

        function validateCity() {
            if (!isValidCity(cityInput.value)) {
                cityError.textContent = "Invalid city";
            } else {
                cityError.textContent = "";
            }
        }

        function validateState() {
            if (!isValidState(stateInput.value)) {
                stateError.textContent = "Invalid state";
            } else {
                stateError.textContent = "";
            }
        }

        function validatePincode() {
            if (!isValidPincode(pincodeInput.value)) {
                pincodeError.textContent = "Invalid pincode";
            } else {
                pincodeError.textContent = "";
            }
        }

        function validateMobileNumber() {
            if (!isValidMobileNumber(mobileInput.value)) {
                mobileError.textContent = "Invalid mobile number";
            } else {
                mobileError.textContent = "";
            }
        }

        function isValidAddress(address) {
            // You can define your validation logic for the address field here.
            // Example: You may want to check if the address is not empty or meets certain criteria.
            return address.trim() !== "";
        }

        function isValidArea(area) {
            // You can define your validation logic for the area field here.
            return area.trim() !== "";
        }

        function isValidCity(city) {
            // You can define your validation logic for the city field here.
            return city.trim() !== "";
        }

        function isValidState(state) {
            // You can define your validation logic for the state field here.
            return state.trim() !== "";
        }

        function isValidPincode(pincode) {
            // You can define your validation logic for the pincode field here.
            return /^[0-9]{6}$/.test(pincode);
        }

        function isValidMobileNumber(mobile) {
            // You can define your validation logic for the mobile number field here.
            // Example: You may want to check if the mobile number has a valid format.
            return /^[6-9]\d{9}$/.test(mobile);
        }
    });
</script>

</body>
</html>
