<?php
session_start();
include("connection.php");
   
if (isset($_POST['login'])) {
    $name = $_POST["email"];
    $pass = $_POST["password"];
    $pass = md5($pass);

    if (!empty($name) && !empty($pass) && !is_numeric($name)) {
        $recaptchaSecretKey = "6Legj5MnAAAAAEURNcMOtZQAacUKNiRwRtoc1gjj";
        $recaptchaResponse = $_POST['g-recaptcha-response'];

        $verifyResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptchaSecretKey&response=$recaptchaResponse");
        $responseData = json_decode($verifyResponse);

        if ($responseData->success) {
            $query = "SELECT * FROM tbl_user WHERE email = '$name' AND password = '$pass'";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                $user_data = mysqli_fetch_assoc($result);

                if ($user_data['password'] === $pass) {
                    $_SESSION['user_id'] = $user_data['user_id'];
                    $role = $user_data['role'];
                    
                    switch ($role) {
                        case 0:
                            header("Location: admin/adminProfile.php");
                            break;
                        case 1:
                            header("Location: home.php");
                            break;
                        case 2:
                            header("Location: seller/sellerProfile.php");
                            break;
                        default:
                            echo '<script>alert("Invalid role!")</script>';
                            break;
                    }
                }
            } else {
                echo '<script>alert("Wrong username or password!")</script>';
            }
        } else {
            echo '<script>alert("reCAPTCHA verification failed!")</script>';
        }
    } else {
        echo '<script>alert("Wrong username or password!")</script>';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
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
        max-width: 326px;
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
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="login-container">
                    <h2><img src="images/logo.png" style="height: 60px;"></h2>
                    <div class="form-group">
                        <form id="loginForm" method="post" name = "login">
                            <input type="email" name="email" id="id_email" placeholder="Email">
                            <p id="emailError" class="error"></p>
                            <input type="password" name="password" id="id_password" placeholder="Password">
                            <p id="passwordError" class="error"></p>
                            <div class="g-recaptcha" data-sitekey="6Legj5MnAAAAAMy8KZAXmeroGPQFM7hdMFE_E9zL"
                                 style="align-items: center;"></div><br>
                            <button type="submit" name = "login" class="btn btn-login" id="log" style="color:#ede5e5;">Login</button>
                            <br>
                            <table>
                                <tr>
                                    <td>
                                        <b><a href="recover_psw.php" style="text-decoration: none; color:black;">Forgot Password?</a></b>
                                    </td>
                                    <td>
                                        <b><a href="registration.php" style="text-decoration: none; color:black; text-align:right;">&emsp; &emsp; &emsp;&emsp;&emsp;New User?</a></b>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const emailInput = document.getElementById("id_email");
                const emailError = document.getElementById("emailError");
                const passwordInput = document.getElementById("id_password");
                const passwordError = document.getElementById("passwordError");
                const loginForm = document.getElementById("loginForm");

                loginForm.addEventListener("submit", function (event) {
                    if (!isValidLoginForm()) {
                        event.preventDefault();
                        alert("Please fill in all fields correctly.");
                    }
                });

                function isValidLoginForm() {
                    const emailInput = document.getElementById("id_email");
                    const passwordInput = document.getElementById("id_password");

                    return (
                        isValidEmail(emailInput.value) &&
                        isValidPassword(passwordInput.value)
                    );
                }

                emailInput.addEventListener("input", function () {
                    if (!isValidEmail(emailInput.value)) {
                        emailError.textContent = "Invalid email format";
                    } else {
                        emailError.textContent = "";
                    }
                });

                passwordInput.addEventListener("input", function () {
                    const passPattern = /^[a-zA-Z0-9!@#$%^&*]{6,16}$/;
                        if (!passPattern.test(passwordInput.value)) {
                            passwordError.textContent = "Must contain at least 8 characters with a uppercase, lowercase, special character, and a number";
                        } else {
                            passwordError.textContent = "";
                        }

                });

                function isValidEmail(email) {
                    const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
                    return emailPattern.test(email);
                }
            });
        </script>
    </div>
</body>
</html>
