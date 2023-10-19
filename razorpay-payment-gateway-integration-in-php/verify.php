<?php

require('config.php');

session_start();

require('razorpay-php/Razorpay.php');
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

$success = true;

$error = "Payment Failed";

if (empty($_POST['razorpay_payment_id']) === false)
{
    $api = new Api($keyId, $keySecret);

    try
    {
        // Please note that the razorpay order ID must
        // come from a trusted source (session here, but
        // could be database or something else)
        $attributes = array(
            'razorpay_order_id' => $_SESSION['razorpay_order_id'],
            'razorpay_payment_id' => $_POST['razorpay_payment_id'],
            'razorpay_signature' => $_POST['razorpay_signature']
        );

        $api->utility->verifyPaymentSignature($attributes);
    }
    catch(SignatureVerificationError $e)
    {
        $success = false;
        $error = 'Razorpay Error : ' . $e->getMessage();
    }
}

if ($success === true)
{
    $html = "<div class = 'col-md-6' style = 'padding-left:300px; padding-top:100px;'>
                <img src = '../images/PAYMENT-SUCCESS.png'>
                <p style = 'padding-left:230px; font-size:24px;'><strong>Payment ID: </strong>{$_POST['razorpay_payment_id']}</p>
                <a href = '../order.php' style = 'padding-left:280px;'><button style = ' background-color:black; color:white; height:45px; border-radius:30px;
                font-size:20px;'>Click here to see order history</button></a>
            </div>";
}
else
{
    $html = "<p>Your payment failed</p>
             <p>{$error}</p>";
}

echo $html;
