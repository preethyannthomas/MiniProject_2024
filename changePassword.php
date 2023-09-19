<?php
session_start();
include("connection.php");
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['change_password'])) {
    $old_password = $_POST["old_password"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

    $query = "SELECT password FROM tbl_user WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $query);
    $user_data = mysqli_fetch_assoc($result);

    if ($user_data['password'] === md5($old_password)) {
        if ($new_password === $confirm_password) {
            $hashed_password = md5($new_password);
            $update_password_query = "UPDATE tbl_user SET password='$hashed_password' WHERE user_id='$user_id'";
            mysqli_query($conn, $update_password_query);
            $success_message = "Password changed successfully!";
        } else {
            $password_error = "New password and confirm password do not match.";
        }
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
    <title>Change Password</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .sec-container {
            margin-top: 100px;
            border-radius: 20px;
            margin-bottom: 80px;
        }

        .login-container {
            max-width: 500px;
            margin: 0 auto;
            padding: 40px;
            background-color: white;
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

        .error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }

    </style>
</head>
<body>
    <?php include('customer_header.php') ?>
    <section id="sec"><br><br><br><br><br><br>
        <div class="login-container">
            <h2>Change Password</h2>
            <?php
            if (isset($success_message)) {
                echo '<div class="alert alert-success">' . $success_message . '</div>';
            }
            ?>
            <form id="changePasswordForm" method="post">
                <div class="form-group">
                    <input type="password" class="form-control" id="old_password" name="old_password" placeholder="Old Password" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="new_password" name="new_password" placeholder="New Password" required>
                    <p id="passwordError" class="error"></p>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
                    <p id="confirmPasswordError" class="error"></p>
                    <?php
                    if (isset($password_error)) {
                        echo '<small class="text-danger">' . $password_error . '</small>';
                    }
                    ?>
                </div>
                <button type="submit" id="submit" class="btn-login" name="change_password">Change Password</button>
            </form>
        </div>
    </section>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const passwordInput = document.getElementById("new_password");
            const passwordError = document.getElementById("passwordError");
            const confirmPasswordInput = document.getElementById("confirm_password");
            const confirmPasswordError = document.getElementById("confirmPasswordError");
            const changePasswordForm = document.getElementById("changePasswordForm");

            changePasswordForm.addEventListener("submit", function (event) {
                if (!isValidForm()) {
                    event.preventDefault(); // Prevent form submission
                    alert("Please fill in all fields correctly.");
                }
            });

            passwordInput.addEventListener("input", function () {
                validatePassword();
            });

            confirmPasswordInput.addEventListener("input", function () {
                validateConfirmPassword();
            });

            function isValidForm() {
                const passwordInput = document.getElementById("new_password");
                const confirmPasswordInput = document.getElementById("confirm_password");

                return (
                    isValidPassword(passwordInput.value) &&
                    isValidConfirmPassword(passwordInput.value, confirmPasswordInput.value)
                );
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
