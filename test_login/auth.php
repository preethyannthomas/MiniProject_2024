<?php
session_start();

if (!isset($_SESSION['ucode']) || (isset($_SESSION['ucode']) && empty($_SESSION['ucode']))) {
    if (strpos($_SERVER['PHP_SELF'], 'login.php') === false) {
        header('location: login.php');
        exit;
    }
} else {
    // User is logged in, now check their role and redirect accordingly
    if (isset($_SESSION['login_role'])) {
        $role = $_SESSION['login_role'];

        switch ($role) {
            case 0:
                // Admin role
                if (strpos($_SERVER['PHP_SELF'], 'admin/adminProfile.php') === false) {
                    echo "Debug: Redirecting to admin profile";
                    header('location: admin/adminProfile.php');
                    exit;
                }
                break;
            case 1:
                // User role
                if (strpos($_SERVER['PHP_SELF'], 'home.php') === false) {
                    echo "Debug: Redirecting to home page";
                    header('location: home.php');
                    exit;
                }
                break;
            case 2:
                // Seller role
                if (strpos($_SERVER['PHP_SELF'], 'seller/sellerProfile.php') === false) {
                    echo "Debug: Redirecting to seller profile";
                    header('location: seller/sellerProfile.php');
                    exit;
                }
                break;
            default:
                // Invalid role
                echo "Debug: Invalid role";
                echo '<script>alert("Invalid role!")</script>';
                if (strpos($_SERVER['PHP_SELF'], 'login.php') === false) {
                    echo "Debug: Redirecting to login page";
                    header('location: login.php');
                    exit;
                }
                break;
        }
    } else {
        // Role information not available, redirect to login page
        if (strpos($_SERVER['PHP_SELF'], 'login.php') === false) {
            echo "Debug: Redirecting to login page (Role info not available)";
            header('location: login.php');
            exit;
        }
    }
}
?>
