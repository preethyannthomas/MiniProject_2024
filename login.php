<?php
require_once('test_login/auth.php');
require_once('vendor/autoload.php');
include("connection.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$clientID = "95908132454-43ct561tga2rk82a6bku1e1llekgfemv.apps.googleusercontent.com"; // Replace with your Google Client ID
$secret = "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"; // Replace with your Google Client Secret

// Google API Client
$gclient = new Google_Client();

$gclient->setClientId($clientID);
$gclient->setClientSecret($secret);
$gclient->setRedirectUri('http://localhost/Project/login.php');

$gclient->addScope('email');
$gclient->addScope('profile');



// Check if the user clicks the Google sign-in button
if (isset($_GET['code'])) {
    // Get Token
    $token = $gclient->fetchAccessTokenWithAuthCode($_GET['code']);

    // Check if fetching token did not return any errors
    if (!isset($token['error'])) {
        // Setting Access token
        $gclient->setAccessToken($token['access_token']);

        // Store access token
        $_SESSION['access_token'] = $token['access_token'];

        // Get Account Profile using Google Service
        $gservice = new Google_Service_Oauth2($gclient);

        // Get User Data
        $udata = $gservice->userinfo->get();
        foreach ($udata as $k => $v) {
            $_SESSION['login_' . $k] = $v;
        }
        $_SESSION['ucode'] = $_GET['code'];
        $email = $_SESSION['login_email'];

        if (isset($_SESSION['ucode']) && !empty($_SESSION['ucode'])) {
            // Query the database to check if the email exists
            $query = "SELECT * FROM tbl_user WHERE email = '" . mysqli_real_escape_string($conn, $email) . "'";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                $user_data = mysqli_fetch_assoc($result);
                $role = $user_data['role'];

                switch ($role) {
                    case 0:
                        // Admin role
                        $_SESSION['login_role'] = 0;
                        $_SESSION['user_id'] = $user_data['user_id'];
                        header("Location: admin/adminProfile.php");
                        exit;
                    case 1:
                        $_SESSION['login_role'] = 1;
                        $_SESSION['user_id'] = $user_data['user_id'];
                        // User role
                        header("Location: home.php");
                        exit;
                    case 2:
                        $_SESSION['login_role'] = 2;
                        $_SESSION['user_id'] = $user_data['user_id'];
                        // Seller role
                        header("Location: seller/sellerProfile.php");
                        exit;
                    case 3:
                        $_SESSION['login_role'] = 3;
                        $_SESSION['user_id'] = $user_data['user_id'];
                        // Delivery boy role
                        header("Location: deliveryboy/deliveryboyProfile.php");
                        exit;
                    default:
                        // Invalid role
                        echo '<script>alert("Invalid role!")</script>';
                        exit;
                }
            } else {
                // Email not found in the database
                echo '<script>alert("Email not found!")</script>';
            }
        } else {
            echo '<script>alert("Invalid session code!")</script>';
        }
    } else {
        echo '<script>alert("Token retrieval error!")</script>';
    }
}
?>
<!-- Rest of your login.php code... -->


<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("connection.php");
   
if (isset($_POST['login'])) {
    $name = $_POST["email"];
    $pass = $_POST["password"];
    $pass = md5($pass);

    /* if (!empty($name) && !empty($pass) && !is_numeric($name)) {
        $recaptchaSecretKey = "6Legj5MnAAAAAEURNcMOtZQAacUKNiRwRtoc1gjj";
        $recaptchaResponse = $_POST['g-recaptcha-response'];

        $verifyResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptchaSecretKey&response=$recaptchaResponse");
        $responseData = json_decode($verifyResponse);

        if ($responseData->success) { */
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
                        case 3:
                            header("Location: deliveryboy/deliveryboyProfile.php");
                            break;
                        default:
                            echo '<script>alert("Invalid role!")</script>';
                            break;
                    }
                }
            } /* else {
                echo '<script>alert("Wrong username or password!")</script>';
            }
        } else {
            echo '<script>alert("reCAPTCHA verification failed!")</script>';
        } 
    } */else {
        echo '<script>alert("Wrong username or password!")</script>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <style>
    body {
        background-color: #f8f9fa;
        background-image: url("images/bg2.jpg");
        background-repeat: no-repeat;
        background-size: cover;
        height: 100vh;
    }
    .google-icon {
            width: 18px;
            height: 18px;
        }

        /* Sign in with Google button styling */
        .sign-in-button {
            background-color: #E74C3C; /* Red background color */
            color: #ffffff; /* White text color */
            border: none;
            border-radius: 50px; /* Make the button round */
            padding: 10px 20px; /* Adjust padding as needed */
            cursor: pointer;
            display: flex;
            align-items: center; /* Vertically center icon and text */
            width:328px;
        }

        /* White circle surrounding the icon */
        .icon-circle {
            background-color: #ffffff; /* White circle background color */
            border-radius: 60%; /* Make it a circle */
            padding: 5px; /* Adjust padding as needed */
            margin-right: 10px; /* Adjust the spacing between icon and text */
            margin-left:60px;
        }

        /* Hover effect */
        .sign-in-button:hover {
            background-color: #C0392B; /* Slightly darker red on hover */
        }
        .hr-with-text {
            position: relative;
            border: none;
            height: 1px; /* Adjust the height of the line as needed */
            background-color: #ccc; /* Adjust the color of the line as needed */
        }

        /* Style for the "or" text */
        .or-text {
            position: absolute;
            top: -10px; /* Adjust the vertical position of the text */
            left: 50%;
            background-color: #fff; /* Background color to hide part of the line */
            padding: 0 10px; /* Adjust padding as needed */
            transform: translateX(-50%); /* Center the text horizontally */
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
</head>

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
                           <!-- <div class="g-recaptcha" data-sitekey="6Legj5MnAAAAAMy8KZAXmeroGPQFM7hdMFE_E9zL"
                                 style="align-items: center;width:330px;"></div><br> -->
                            <button type="submit" name = "login" class="btn btn-login" id="log" style="color:#ede5e5;">Login</button>
                            <hr class="hr-with-text">
    <span class="or-text">or</span>
    <button class="sign-in-button">
        <div class="icon-circle">
       
        <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google icon" class="google-icon">
    </a>
      
        </div>
        <a href="<?= $gclient->createAuthUrl() ?>" class="btn btn btn-primary btn-flat rounded-0" style = "text-decoration:none; color:white;">Login with Google</a>   
       
    </button>
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
        
    </div>
</body>
</html>
