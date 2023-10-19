<?php
         session_start();
	      include("connection.php");
	      include("functions.php");
	      if($_SERVER['REQUEST_METHOD'] == "POST"){
		      $name = $_POST["form_fname"];
            $adh_no = $_POST["form_sname"];
            $pass = $_POST["form_password"];
            $email = $_POST["form_email"];
		      if(!empty($name) && !empty($pass) && !is_numeric($name)){
               $query = "SELECT * FROM tbl_sign_up WHERE adh_no = '$name' and pass = '$pass' LIMIT 1;";
               $query_run = mysql_query($query);
               if (mysql_num_rows($query_run) == 1){
                  echo '<script>alert(Please enter some valid information!")</script>';
               }
               $query = "";
               $result = mysqli_query($con, $query);
               if($result){
                  if($result && mysqli_num_rows($result) > 0){
                     $user_data = mysqli_fetch_assoc($result);
                     if($user_data['pass'] === $pass){
                        echo '<script>alert(Please enter some valid information!")</script>';
                        
                     }else{
                  $query = "INSERT into tbl_sign_up (name, adh_no, email,pass) values('$name','$adh_no','$email','$pass')";
                  mysqli_query($con, $query);
                  header("Location: Registration_form.php");
                  die;
                     
               }
               }
            }
            }
         }
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Sign Up</title>
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
         <h1>Sign Up</h1>
      </i>
      <form id="registration_form" method="POST" >
         <div>
            <input type="text" id="form_fname" name="form_fname" required="">
            <span class="error_form" id="fname_error_message"></span>
            <label>Name </label>
         </div>
         <div>
            <input type="text" id="form_sname" name="form_sname" required="">
            <span class="error_form" id="sname_error_message"></span>
            <label>Aadhar Number</label>
         </div>
         <div>
            <input type="email" id="form_email" name="form_email" required="">
            <span class="error_form" id="email_error_message"></span>
            <label>Email id</label>
         </div>
         <div>
            <input type="password" id="form_password" name="form_password" required="">
            <span class="error_form" id="password_error_message"></span>
            <label>Password</label>
         </div>
         <div>
            <input type="password" id="form_retype_password" name="form_retype_password" required="">
            <span class="error_form" id="retype_password_error_message"></span>
            <label>Re-Enter Password</label>
         </div>
         <center>
            <button type="submit" id="submit" name = "sub_up">Register</button><br> 
            <button type="submit" style="background-color: Transparent; color:#0078d0; background-repeat:no-repeat;border: none; "><br><i>
                  <a href="SignIn.php">Already a user?</a></i></button>
         </center>
      </form>
      
   </div>
   <script>
      $(function() {

         $("#fname_error_message").hide();
         $("#sname_error_message").hide();
         $("#email_error_message").hide();
         $("#password_error_message").hide();
         $("#retype_password_error_message").hide();
         var error_fname = false;
         var error_sname = false;
         var error_email = false;
         var error_password = false;
         var error_retype_password = false;
         $("#form_fname").focusout(function() {
            check_fname();
         });
         $("#form_sname").focusout(function() {
            check_sname();
         });
         $("#form_email").focusout(function() {
            check_email();
         });
         $("#form_password").focusout(function() {
            check_password();
         });
         $("#form_retype_password").focusout(function() {
            check_retype_password();
         });

         function check_fname() {
            var pattern = /^[a-zA-Z]*$/;
            var fname = $("#form_fname").val();
            if (pattern.test(fname) && fname !== '') {
               $("#fname_error_message").hide();
               $("#form_fname").css("border-bottom", "2px solid #34F458");
            } else {
               $("#fname_error_message").html("Should contain only Characters");
               $("#fname_error_message").show();
               $("#form_fname").css("border-bottom", "2px solid #F90A0A");
               error_fname = true;
            }
         }

         function check_sname() {
            var pattern = /^[2-9]{1}[0-9]{3}\s{1}[0-9]{4}\s{1}[0-9]{4}$/;
            var sname = $("#form_sname").val()
            if (pattern.test(sname) && sname !== '') {
               $("#sname_error_message").hide();
               $("#form_sname").css("border-bottom", "2px solid #34F458");
            } else {
               $("#sname_error_message").html("Invalid Aadhar Number");
               $("#sname_error_message").show();
               $("#form_sname").css("border-bottom", "2px solid #F90A0A");
               error_sname = true;
            }
         }

         function check_password() {
            var password_length = $("#form_password").val().length;
            if (password_length < 8) {
               $("#password_error_message").html("Atleast 8 Characters");
               $("#password_error_message").show();
               $("#form_password").css("border-bottom", "2px solid #F90A0A");
               error_password = true;
            } else {
               $("#password_error_message").hide();
               $("#form_password").css("border-bottom", "2px solid #34F458");
            }
         }

         function check_retype_password() {
            var password = $("#form_password").val();
            var retype_password = $("#form_retype_password").val();
            if (password !== retype_password) {
               $("#retype_password_error_message").html("Passwords Did not Matched");
               $("#retype_password_error_message").show();
               $("#form_retype_password").css("border-bottom", "2px solid #F90A0A");
               error_retype_password = true;
            } else {
               $("#retype_password_error_message").hide();
               $("#form_retype_password").css("border-bottom", "2px solid #34F458");
            }
         }

         function check_email() {
            var pattern = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            var email = $("#form_email").val();
            if (pattern.test(email) && email !== '') {
               $("#email_error_message").hide();
               $("#form_email").css("border-bottom", "2px solid #34F458");
            } else {
               $("#email_error_message").html("Invalid Email");
               $("#email_error_message").show();
               $("#form_email").css("border-bottom", "2px solid #F90A0A");
               error_email = true;
            }
         }
         // $("#submit").click(function() {
         //    error_fname = false;
         //    error_sname = false;
         //    error_email = false;
         //    error_password = false;
         //    error_retype_password = false;

         //    check_fname();
         //    check_sname();
         //    check_email();
         //    check_password();
         //    check_retype_password();

         //    if (error_fname === false && error_sname === false && error_email === false && error_password === false && error_retype_password === false) {
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