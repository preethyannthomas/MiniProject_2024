<?php
session_start();
include("connection.php");
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM tbl_user WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);
$user_data = mysqli_fetch_assoc($result);
$query1 = "SELECT * FROM tbl_customer WHERE user_id = '$user_id'";
$result1 = mysqli_query($conn, $query1);
$user_data1 = mysqli_fetch_assoc($result1);

if (isset($_POST['update'])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $mobile = $_POST["mobile"];
    $old_password = $_POST["old_password"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

    if ($user_data['password'] === md5($old_password)) {
        $update_query = "UPDATE tbl_customer SET customer_name='$name', contact_no='$mobile' WHERE user_id='$user_id'";
        mysqli_query($conn, $update_query);
        $update_email_query = "UPDATE tbl_user SET email='$email' WHERE user_id='$user_id'";
        mysqli_query($conn, $update_email_query);
        if (!empty($new_password)) {
            if ($new_password === $confirm_password) {
                $hashed_password = md5($new_password);
                $update_password_query = "UPDATE users SET password='$hashed_password' WHERE user_id='$user_id'";
                mysqli_query($conn, $update_password_query);
            } else {
                $password_error = "New password and confirm password do not match.";
            }
        }
        $success_message = "Profile updated successfully!";
    } else {
        $password_error = "Old password is incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        
    

    .sec-container {
        margin-top: 100px;
        border-radius: 20px;
        margin-bottom:80px;    }

    .login-container {
        max-width: 500px;
        margin: 0 auto;
        padding: 40px;
        background-color: rgb(251, 243, 243);
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
    <?php include('customer_header.php') ?>
    <section id = "sec"><br><br><br><br><br><br>
<div class="login-container">
    <h2>Edit Profile</h2>
    <?php
    if (isset($success_message)) {
        echo '<div class="alert alert-success">' . $success_message . '</div>';
    }
    ?>
    <form id="registrationForm" method="post">
        <div class="form-group">
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $user_data1['customer_name']; ?>" required>
            <p id="nameError" class="error"></p>
        </div>
        <div class="form-group">
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $user_data['email']; ?>" readonly>
        </div>
        <div class="form-group">
            <input type="tel" class="form-control" id="mobile" name="mobile" value="<?php echo $user_data1['contact_no']; ?>" required>
            <p id="mobileNumberError" class="error"></p>
        </div>
        <div class="form-group">
            <input type="password" class="form-control" id="old_password" name="old_password" placeholder = "Old Password" required>
        </div>
        <div class="form-group">
            <input type="password" class="form-control" id="new_password" name="new_password" placeholder = "New Password">
            <p id="passwordError" class="error"></p>
        </div>
        <div class="form-group">
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder = "Confirm Password">
            <p id="confirmPasswordError" class="error"></p>
            <?php
            if (isset($password_error)) {
                echo '<small class="text-danger">' . $password_error . '</small>';
            }
            ?>
        </div>
        <button type="submit" id = "submit" class="btn-login" name="update">Update Profile</button>
    </form>
</div>

</section>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const nameInput = document.getElementById("name");
        const nameError = document.getElementById("nameError");
        const mobileNumberInput = document.getElementById("mobile");
        const mobileNumberError = document.getElementById("mobileNumberError");
        const passwordInput = document.getElementById("new_password");
        const passwordError = document.getElementById("passwordError");
        const confirmPasswordInput = document.getElementById("confirm_password");
        const confirmPasswordError = document.getElementById("confirmPasswordError");
        const registrationForm = document.getElementById("registrationForm");

        registrationForm.addEventListener("submit", function (event) {
            if (!isValidForm()) {
                event.preventDefault(); // Prevent form submission
                alert("Please fill in all fields correctly.");
            }
        });

        nameInput.addEventListener("input", function () {
            validateName();
        });

        passwordInput.addEventListener("input", function () {
            validatePassword();
        });

        confirmPasswordInput.addEventListener("input", function () {
            validateConfirmPassword();
        });

        mobileNumberInput.addEventListener("input", function () {
            validateMobileNumber();
        });

        function isValidForm() {
            const nameInput = document.getElementById("name");
            const mobileNumberInput = document.getElementById("mobile");
            const passwordInput = document.getElementById("new_password");
            const confirmPasswordInput = document.getElementById("confirm_password");

            return (
                isValidName(nameInput.value) &&
                isValidMobileNumber(mobileNumberInput.value) &&
                isValidPassword(passwordInput.value) &&
                isValidConfirmPassword(passwordInput.value, confirmPasswordInput.value)
            );
        }

        function validateName() {
            if (!isValidName(nameInput.value)) {
                nameError.textContent = "Name contains only alphabetical characters";
            } else {
                nameError.textContent = "";
            }
        }

        function validateMobileNumber() {
            if (!isValidMobileNumber(mobileNumberInput.value)) {
                mobileNumberError.textContent = "Invalid mobile number";
            } else {
                mobileNumberError.textContent = "";
            }
        }

        function validatePassword() {
            const pass = /^[a-zA-Z0-9!@#$%^&*]{6,16}$/;
            if (!pass.test(passwordInput.value)) {
                passwordError.textContent = "Must contain at least 8 characters with special characters";
            } else {
                passwordError.textContent = "";
            }
            validateConfirmPassword();
        }

        function validateConfirmPassword() {
            if (!isValidConfirmPassword(passwordInput.value, confirmPasswordInput.value)) {
                confirmPasswordError.textContent = "Passwords do not match";
            } else {
                confirmPasswordError.textContent = "";
            }
        }

        function isValidName(name) {
            const namePattern = /^[A-Za-z\s]+$/;
            return namePattern.test(name);
        }

        function isValidMobileNumber(mobile) {
            const mob = /^[6-9]\d{9}$/;
            return mob.test(mobile);
        }

        function isValidPassword(password) {
            const passPattern = /^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&-+=()])(?=\\S+$).{8,20}$/;
            return passPattern.test(password);
        }

        function isValidConfirmPassword(password, confirmPassword) {
            return password === confirmPassword;
        }
    });
</script>

<?php include('customer_footer.php') ?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
