<?php
   session_start();
   include("connection.php");
   include("functions.php");
   if($_SERVER['REQUEST_METHOD'] == "POST"){
      $name = $_POST["logadh"];
      $pass = $_POST["logpass"];
      if(!empty($name) && !empty($pass) && !is_numeric($name)){
         $query = "SELECT * FROM tbl_sign_up WHERE adh_no = '$name' and pass = '$pass'";
         $result = mysqli_query($con, $query);
         if($result){
            if($result && mysqli_num_rows($result) > 0){
               $user_data = mysqli_fetch_assoc($result);
               if($user_data['pass'] === $pass){
                  $_SESSION['user_id'] = $user_data['user_id'];
                  header("Location: Registration_form.php");
                  die;
               }
            }
         }
         echo '<script>alert("Wrong username or password!")</script>';
      }else
      {
         echo '<script>alert("Wrong username or password!")</script>';
      }
   }
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Sign In</title>
   <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
   <style>
      body {
         margin: 0;
         padding: 0;
         font-family: sans-serif;
         background: url("https://images.shiksha.com/mediadata/images/articles/1585561442phplR2Sme.jpeg");
         background-repeat: no-repeat;
         background-size: cover;
      }

      *,
      :after,
      :before {
         box-sizing: border-box
      }

      .clearfix:after,
      .clearfix:before {
         content: '';
         display: table
      }

      .clearfix:after {
         clear: both;
         display: block
      }

      a {
         color: inherit;
         text-decoration: none
      }

      ::placeholder {
         color: #d9d9d9;
         Font-family: Georgia, Times, Times New Roman, serif;
         font-size: 18px;
         font-style: italic
      }

      .container {
         position: absolute;
         top: 50%;
         left: 68%;
         transform: translate(-50%, -50%);
         width: 580px;
         background: #fff;
         padding: 45px;
         box-sizing: border-box;
         border: 1px solid rgba(0, 0, 0, .1);
         border-radius: 12px;
         box-shadow: 0 5px 10px rgba(0, 0, 0, .2);
         text-align: right;
      }

      .container h1 {

         margin: 0 0 40px;
         padding: 0;
         color: rgb(66, 133, 244);
         letter-spacing: 2px;
         Font-family: Georgia, Times, Times New Roman, serif;
      }

      .container input {
         padding: 5px;
         margin-bottom: 30px;
         width: 55%;
         box-sizing: border-box;
         box-shadow: none;
         outline: none;
         border: none;
         border-bottom: 2px solid #999;
      }

      .container input[type="submit"] {
         background-color: #0078d0;
         border: 0;
         border-radius: 56px;
         color: #fff;
         cursor: pointer;
         display: inline-block;
         font-family: system-ui, -apple-system, system-ui, "Segoe UI", Roboto, Ubuntu, "Helvetica Neue", sans-serif;
         font-size: 18px;
         font-weight: 600;
         outline: 0;
         padding: 14px 21px;
         position: relative;
         text-align: center;
         text-decoration: none;
         transition: all .3s;
         user-select: none;
         -webkit-user-select: none;
         touch-action: manipulation;
         border-radius: 25px;
         height: 40px;
         margin-bottom: 0;
      }

      #submit {
         background-color: #0078d0;
         border: 0;
         border-radius: 56px;
         color: #fff;
         cursor: pointer;
         display: inline-block;
         font-family: system-ui, -apple-system, system-ui, "Segoe UI", Roboto, Ubuntu, "Helvetica Neue", sans-serif;
         font-size: 18px;
         font-weight: 600;
         outline: 0;
         padding: 16px 21px;
         position: relative;
         text-align: center;
         text-decoration: none;
         transition: all .3s;
         user-select: none;
         -webkit-user-select: none;
         touch-action: manipulation;
      }

      #submit:before {
         background-color: initial;
         background-image: linear-gradient(#fff 0, rgba(255, 255, 255, 0) 100%);
         border-radius: 125px;
         content: "";
         height: 50%;
         left: 4%;
         opacity: .5;
         position: absolute;
         top: 0;
         transition: all .3s;
         width: 92%;
      }

      #submit:hover {
         box-shadow: rgba(255, 255, 255, .2) 0 3px 15px inset, rgba(0, 0, 0, .1) 0 3px 5px, rgba(0, 0, 0, .1) 0 10px 13px;
         transform: scale(1.05);
      }

      @media (min-width: 768px) {
         #submit {
            padding: 16px 48px;
         }
      }

      .container input[type="submit"]:before {
         background-color: initial;
         background-image: linear-gradient(#fff 0, rgba(255, 255, 255, 0) 100%);
         border-radius: 125px;
         content: "";
         height: 50%;
         left: 4%;
         opacity: .5;
         position: absolute;
         top: 0;
         transition: all .3s;
         width: 92%;
      }

      .container input[type="submit"]:hover {
         box-shadow: rgba(255, 255, 255, .2) 0 3px 15px inset, rgba(0, 0, 0, .1) 0 3px 5px, rgba(0, 0, 0, .1) 0 10px 13px;
         transform: scale(1.05);
      }

      @media (min-width: 768px) {
         .container input[type="submit"] {
            padding: 16px 48px;
         }
      }

      .container form div {
         position: relative;
      }

      .container form div label {
         position: absolute;
         top: 3px;
         pointer-events: none;
         left: 0;
         transition: .5s;
      }

      .container input:focus~label,
      .container input:valid~label {
         left: 0;
         top: -20px;
         color: rgb(66, 133, 244);
         font-size: 12px;
         font-weight: bold;
      }

      .container input:focus,
      .container input:valid {
         border-bottom: 2px solid rgb(66, 133, 244);
      }

      .error_form {
         top: 2px;
         color: rgb(216, 15, 15);
         font-size: 15px;
         font-family: Helvetica;
      }
   </style>
</head>

<body>
   <div class="container">
      <i>
         <h1>Sign In</h1>
      </i>
      <form id="login" method="POST">
         <div>
            <input type="text" id="logadh" name="logadh" required="">
            <span class="error_form" id="logadh_error_message"></span>
            <label>Aadhar Number</label>
         </div>
         <div>
            <input type="password" id="logpass" name="logpass" required="">
            <span class="error_form" id="logpass_error_message"></span>
            <label>Password</label>
         </div>
         <div>
            <center>
           <button type="submit"  class="log" name="log" id="submit">Log in</button><br> 
               <button type="submit" style="background-color: Transparent; color:#0078d0; background-repeat:no-repeat;border: none;"><br><i>
                     <a href="SignUp.php">New user? Register here</a></i></button>
            </center>
      </form>
     
   </div>
   <script>
      $(function() {
         $("#logpass_error_message").hide();
         $("#logadh_error_message").hide();
         var error_logpass = false;
         var error_logadh = false;
         $("#logadh").focusout(function() {
            check_logadh();
         });
         $("#logpass").focusout(function() {
            check_logpass();
         });

         function check_logadh() {
            var pattern = /^[2-9]{1}[0-9]{3}\s{1}[0-9]{4}\s{1}[0-9]{4}$/;
            var sname = $("#logadh").val()
            if (pattern.test(sname) && sname !== '') {
               $("#logadh_error_message").hide();
               $("#logadh").css("border-bottom", "2px solid #34F458");
            } else {
               $("#logadh_error_message").html("Invalid Aadhar Number");
               $("#logadh_error_message").show();
               $("#logadh").css("border-bottom", "2px solid #F90A0A");
               error_logadh = true;
            }
         }

         function check_logpass() {
            var password_length = $("#logpass").val().length;
            if (password_length < 8) {
               $("#logpass_error_message").html("Atleast 8 Characters");
               $("#logpass_error_message").show();
               $("#form_logpass").css("border-bottom", "2px solid #F90A0A");
               error_password = true;
            } else {
               $("#logpass_error_message").hide();
               $("#logpass").css("border-bottom", "2px solid #34F458");
            }
         }
         // $(".log").click(function() {
         //    error_logadh = false;
         //    error_logpass = false;
         //    check_logadh();
         //    check_logpass();
         //    if (error_logadh === false && error_logpass === false) {
         //       return false;
         //    } else {
         //       alert("Please Fill the form Correctly");
         //       return true;
         //    }
         // });
      });
   </script>
</body>

</html>