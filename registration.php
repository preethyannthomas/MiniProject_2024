<?php
require 'connection.php'; 
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($password);
 
    $query = "INSERT INTO tbl_user (email, password, role, status) VALUES ('$email', '$password', 1, 1)";
   

    if (mysqli_query($conn, $query)) {
        $user_id = mysqli_insert_id($conn); 
        $query = "INSERT INTO tbl_customer (user_id, customer_name, contact_no) VALUES ($user_id, '$name', '$mobile')";
          if (mysqli_query($conn, $query)) {
            echo '<script>alert("Registration Successful!");</script>';
            echo '<script>window.location.href = "login.php";</script>';
        } else {
            echo '<script>alert("Already registered!!");</script>';
            echo '<script>window.location.href = "login.php";</script>';
        }
    } else {
        echo '<script>alert("Email already exists!!");</script>';
        echo '<script>window.location.href = "login.php";</script>';
    }
}
mysqli_close($conn); 
?>
<style>
    body {
        background-color: #f8f9fa;
        background-image: url("images/bg2.jpg");
        background-repeat: no-repeat;
        background-size: cover;
        height: 100vh;
    }

    .container {
        margin-top: 130px;
        border-radius: 20px;
    }

    .login-container {

        max-width: 330px;
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
        border-radius: 10px;
    }

    .btn-login {
        display: block;
        width: 100%;
        padding: 10px;
        color: var(--white);
        background: #392626;
        box-shadow: var(--box-shadow);
        transition: .4s linear;
        border: none;
        border-radius: 10px;
        border-color: #131312;
        text-align: center;
        text-decoration: none;
    }

    .btn-login:hover {
        color: var(--white);
        background: #080808;
        box-shadow: var(--box-shadow);
        transition: .4s linear;
    }

    #form-control {
        color: #F28123;
    }

    .mobile-input-container {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .country-code {
        width: 100px;
    }

    .mobile-number {
        padding-top: 2px;
        flex: 1;
    }

    .country-dropdown {
        width: 100%;
    }

    #btn:hover {
        color: var(--white);
        background: #e26b09;
        box-shadow: var(--box-shadow);
        transition: .4s linear;
    }

    .bold-on-hover {
        font-weight: normal;
        /* Start with normal font weight */
        transition: font-weight 0.2s ease;
        /* Add a transition effect for smooth change */
    }

    /* Apply bold font weight on hover */
    .bold-on-hover:hover,
    .bold-on-hover:active,
    .bold-on-hover:visited {
        font-weight: bold;
        text-decoration: none;
        ;
    }

    .error {
        color: red;
        font-size: 14px;
        margin-top: 5px;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="login-container">
                <h2><img src="images/logo.png" style="height: 60px;"></h2>

                <div class="form-group">
                    <form id="registrationForm" method="post" name = "regForm">
                        <input type="text" name="name" id="id_name" placeholder="Name">
                        <p id="nameError" class="error"></p>
                        
                        <input type="text" name="mobile"id="id_mobile_number" placeholder="Enter mobile number">
                        <p id="mobileNumberError" class="error"></p>

                        <input type="email" name="email" id="id_email" placeholder="Email">
                        <p id="emailError" class="error"></p>
                        
                        <input type="password" name="password" id="id_password" placeholder="Password">
                        <p id="passwordError" class="error"></p>
                        
                        <input type="password" name="confirm_password" id="id_confirm_password"
                            placeholder="Confirm Password">
                        <p id="confirmPasswordError" class="error"></p>
                        <button type="submit" class="btn btn-login" name = "submit" id="submit" style="color: white;"><a href="registration"></a>Create
                            Account</a></button>
                        <br>
                        <b><a href="login.php" style="text-decoration: none;"><input type="button"
                                    value="Already a User?" style="all: unset;
        cursor: pointer; color:#0b0601;text-align: right; "></a></b>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>

        document.addEventListener("DOMContentLoaded", function () {

            const nameInput = document.getElementById("id_name");
            const nameError = document.getElementById("nameError");
            const mobileNumberInput = document.getElementById("id_mobile_number");
            const mobileNumberError = document.getElementById("mobileNumberError");
            const emailInput = document.getElementById("id_email");
            const emailError = document.getElementById("emailError");
            const passwordInput = document.getElementById("id_password");
            const passwordError = document.getElementById("passwordError");
            const confirmPasswordInput = document.getElementById("id_confirm_password");
            const confirmPasswordError = document.getElementById("confirmPasswordError");
            const registrationForm = document.getElementById("registrationForm");

            registrationForm.addEventListener("submit", function (event) {
                if (!isValidForm()) {
                    event.preventDefault(); // Prevent form submission
                    alert("Please fill in all fields correctly.");
                }
            });
            function isValidForm() {
                const nameInput = document.getElementById("id_name");
                const mobileNumberInput = document.getElementById("id_mobile_number");
                const emailInput = document.getElementById("id_email");
                const passwordInput = document.getElementById("id_password");
                const confirmPasswordInput = document.getElementById("id_confirm_password");

                return (
                    isValidName(nameInput.value) &&
                    isValidMobileNumber(mobileNumberInput.value) &&
                    isValidEmail(emailInput.value)
                );
            }
            nameInput.addEventListener("input", function () {
                validateName();
            });

            emailInput.addEventListener("input", function () {
                validateEmail();
            });

            passwordInput.addEventListener("input", function () {
                validatePassword();
            });

            confirmPasswordInput.addEventListener("input", function () {
                validateConfirmPassword();
            });
            mobileNumberInput.addEventListener("input", function () {
                if (!isValidMobileNumber(mobileNumberInput.value)) {
                    mobileNumberError.textContent = "Invalid mobile number";
                } else {
                    mobileNumberError.textContent = "";
                }
            });
            function validateName() {
                if (!isValidName(nameInput.value)) {
                    nameError.textContent = "Name contains only alphabetical character";
                } else {
                    nameError.textContent = "";
                }
            }

            function validateEmail() {
                if (!isValidEmail(emailInput.value)) {
                    emailError.textContent = "Invalid email format";
                } else {
                    emailError.textContent = "";
                }
            }

            function validatePassword() {
    const passPattern = /^[a-zA-Z0-9!@#$%^&*]{6,16}$/;
    if (!passPattern.test(passwordInput.value)) {
        passwordError.textContent = "Must contain at least 8 characters with a uppercase, lowercase, special character, and a number";
    } else {
        passwordError.textContent = "";
    }
    validateConfirmPassword();
}

            function validateConfirmPassword() {
                if (passwordInput.value !== confirmPasswordInput.value) {
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
            function isValidEmail(email) {
                const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
                return emailPattern.test(email);
            }
        });


    </script>