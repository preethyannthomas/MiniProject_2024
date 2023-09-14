<?php
// Include the database connection file
include("../connection.php");
session_start();
if (!isset($_SESSION['user_id'])) {
    header('location:./');
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Get the current, new, and confirm passwords from the form
    $currentPassword = $_POST["currentpassword"];
    $newPassword = $_POST["newpassword"];
    $confirmPassword = $_POST["confirmpassword"];

    // Retrieve the current password from the database for the user
    $getUserQuery = "SELECT password FROM tbl_user WHERE user_id = $user_id";
    $userResult = $conn->query($getUserQuery);

    if ($userResult->num_rows == 1) {
        $userRow = $userResult->fetch_assoc();
        $currentDatabasePassword = $userRow["password"];

        // Check if the entered current password matches the database password
        if (md5($currentPassword) == $currentDatabasePassword) {
            // Hash the new password using MD5
            $hashedPassword = md5($newPassword);

            // Update the password in the database
            $updatePasswordQuery = "UPDATE tbl_user SET password = '$hashedPassword' WHERE user_id = $user_id";
            $conn->query($updatePasswordQuery);

            // Display a success message
            echo "<script>alert('Password updated successfully.')</script>";
        } else {
            // Display an error message if the current password is incorrect
            echo "<script>alert('Password entered is incorrect.')</script>";
        }
    } else {
        // Display an error message if the user is not found
        echo "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  
  <title>Change Password</title>
  
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
  <script>
    Breakpoints();
  </script>
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
            <h3 class="widget-title">Change Password</h3>
          </header><!-- .widget-header -->
          <hr class="widget-separator">
          <div class="widget-body">
            
            <form class="form-horizontal" onsubmit="return checkpass();" name="changepassword" id="changepassword" method="post">
              <div class="form-group">
                <label for="exampleTextInput1" class="col-sm-3 control-label">Current Password:</label>
                <div class="col-sm-9">
                  <input type="password" class="form-control" name="currentpassword" id="currentpassword"required='true'>
                </div>
              </div>
              <div class="form-group">
                <label for="email2" class="col-sm-3 control-label">New Password:</label>
                <div class="col-sm-9">
                  <input type="password" class="form-control" name="newpassword"  class="form-control" required="true">
                  <p id="passwordError" class="error" style="color: red;"></p>
                </div>
              </div>
              <div class="form-group">
                <label for="email2" class="col-sm-3 control-label">Confirm Password:</label>
                <div class="col-sm-9">
                  <input type="password" class="form-control"  name="confirmpassword" id="confirmpassword"  required='true'>
                  <p id="confirmPasswordError" class="error" style="color: red;"></p>
                </div>
              </div>
               
            
              <div class="row">
                <div class="col-sm-9 col-sm-offset-3">
                  <button type="submit" class="btn btn-success" name="submit">Change</button>
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
        const currentPasswordInput = document.getElementById("currentpassword");
        const newPasswordInput = document.getElementById("newpassword");
        const confirmPasswordInput = document.getElementById("confirmpassword");
        const passwordError = document.getElementById("passwordError");
        const confirmPasswordError = document.getElementById("confirmPasswordError");
        const changepasswordForm = document.getElementById("changepassword");

        changepasswordForm.addEventListener("submit", function (event) {
            if (!isValidForm()) {
                event.preventDefault(); // Prevent form submission
                alert("Please fill in all fields correctly.");
            }
        });

        function isValidForm() {
            return (
                validatePassword() &&
                validateConfirmPassword()
            );
        }

        newPasswordInput.addEventListener("input", function () {
            validatePassword();
        });

        confirmPasswordInput.addEventListener("input", function () {
            validateConfirmPassword();
        });

        function validatePassword() {
            const passPattern = /^[a-zA-Z0-9!@#$%^&*]{6,16}$/;
            if (!passPattern.test(newPasswordInput.value)) {
                passwordError.textContent = "Must contain at least 6 characters with a valid format";
                return false;
            } else {
                passwordError.textContent = "";
                return true;
            }
        }

        function validateConfirmPassword() {
            if (newPasswordInput.value !== confirmPasswordInput.value) {
                confirmPasswordError.textContent = "Passwords do not match";
                return false;
            } else {
                confirmPasswordError.textContent = "";
                return true;
            }
        }
    });

  </script>
</body>
</html>
