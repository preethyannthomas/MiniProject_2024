<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a New Address</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    body{
        background-image:url('images/backgroundAddress.jpg');
    }
    .login-container{
        margin-top:50px;
        width:700px;
        background-color: rgb(251, 243, 243);
        border-radius: 20px;
        opacity: 0.9;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    .form-group input {
        width: 100%;
        padding: 10px;
        border: 1px solid pink;
        border-radius: 10px;
    }
</style>
</head>
<body>


<section><br><br><br>
      <div class="container">
      <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="login-container">
                  <form method="post">
          
                <label for="fullName">Full name (First and Last name)</label>
                <input type="text" class="form-control" id="uname" placeholder="Enter your full name" onkeyup="validateName()" required>
                <span id="lblErrorName" style="color: red"></span>
                <br>
                <label for="mobileNumber">Mobile number</label>
                <input type="text" class="form-control" id="phone" placeholder="Enter your mobile number" pattern="[0-9]{10}"  onkeyup="validatePhone()"required>
                <span id="lblErrorPhone" style="color: red"></span>
            
                    <label for="pincode">Pincode</label>
                    <input type="text" class="form-control" id="pincode" placeholder="Enter pincode" onkeyup="validatePincode()"required>
                    <span id="lblErrorPincode" style="color: red"></span>
                
                    <label for="flat">Flat, House no., Building, Apartment</label>
                    <input type="text" class="form-control" id="flat" placeholder="Enter flat or house no." onkeyup="validateFlat()"required>
                    <span id="lblErrorFlat" style="color: red"></span>
                
                <label for="area">Area, Street, Landmark</label>
                <input type="text" class="form-control" id="area" placeholder="Enter area, street, landmark" onkeyup="validateArea()"required>
                <span id="lblErrorArea" style="color: red"></span>
            
                    <label for="town">Town/City</label>
                    <input type="text" class="form-control" id="town" placeholder="Enter town or city">
               
                    <label for="state">State</label>
                                                                    <select name="state" id="state" class="form-control" placeholder="State" required>
                                                    <option value="Andhra Pradesh">Andhra Pradesh</option>
                                                    <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                                    <option value="Assam">Assam</option>
                                                    <option value="Bihar">Bihar</option>
                                                    <option value="Chhattisgarh">Chhattisgarh</option>
                                                    <option value="Goa">Goa</option>
                                                    <option value="Gujarat">Gujarat</option>
                                                    <option value="Haryana">Haryana</option>
                                                    <option value="Himachal Pradesh">Himachal Pradesh</option>
                                                    <option value="Jharkhand">Jharkhand</option>
                                                    <option value="Karnataka">Karnataka</option>
                                                    <option value="Kerala" selected>Kerala</option>
                                                    <option value="Madhya Pradesh">Madhya Pradesh</option>
                                                    <option value="Maharashtra">Maharashtra</option>
                                                    <option value="Manipur">Manipur</option>
                                                    <option value="Meghalaya">Meghalaya</option>
                                                    <option value="Mizoram">Mizoram</option>
                                                    <option value="Nagaland">Nagaland</option>
                                                    <option value="Odisha">Odisha</option>
                                                    <option value="Punjab">Punjab</option>
                                                    <option value="Rajasthan">Rajasthan</option>
                                                    <option value="Sikkim">Sikkim</option>
                                                    <option value="Tamil Nadu">Tamil Nadu</option>
                                                    <option value="Telangana">Telangana</option>
                                                    <option value="Tripura">Tripura</option>
                                                    <option value="Uttar Pradesh">Uttar Pradesh</option>
                                                    <option value="Uttarakhand">Uttarakhand</option>
                                                    <option value="West Bengal">West Bengal</option>
                                                </select>
            
            <button type="submit" class="btn btn-primary">Add Address</button>
        </form>
     
</div>
</div>
</div>
</section>

    <!-- Include Bootstrap JS and jQuery -->
    <script src="js/myscripts.js"> </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
<script>
    function validateName() {
    var letters = /^[A-Za-z\s]+$/;

    var name= document.getElementById("uname");
    var lblError = document.getElementById("lblErrorName");    
   
      if(name.value.match(letters))
      {
        lblError.innerHTML="";
        
        return true;
      }
     
        lblError.innerHTML="Name field required only alphabet characters";
        
        return false;
      
  }
  
  function validateEmail(){
    var email= document.getElementById("email").value; 
    var lblError = document.getElementById("lblErrorEmail");
      lblError.innerHTML = "";
      var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
     if(email==""){
      lblError.innerHTML="Email is required";
      
      return false;
     }
     if (!expr.test(email)) {
          lblError.innerHTML = "Invalid email address.";
          
          return false;
      }
    
        lblError.innerHTML="";
        
        return true;
      
  }
  
  function validatePhone(){
    var phone=document.getElementById("phone").value;
    var lblError=document.getElementById("lblErrorPhone");
    lblError.innerHTML = "";
    const phonePattern = /^[6-9]\d{9}$/;
    if(phone==""){
      lblError.innerHTML="Mobile number is required";
      
      return false;
     }
     if (!phonePattern.test(phone)){
      lblError.innerHTML="Enter a valid mobile number (10 digits)";
      return false;
     }
     if(phone.length>10){
      lblError.innerHTML="Only 10 digit is possible";
      return false;
     }
     lblError.innerHTML="";
        
     return true;
   

  }

  function validatePassword(){
    var pwd= document.getElementById("pwd").value;
    var lblError = document.getElementById("lblErrorPass");
          pattern= /^[a-zA-Z0-9!@#$%^&*]{6,16}$/;
           if(pwd==" ")
          {
              lblError.innerHTML="Please enter Password";
             
              return false;
          }
          if(!pattern.test(pwd))
          {
            lblError.innerHTML="Feild should conatin one special charater and one number";
            
            return false;
          }
           if(document.getElementById("pwd").value.length < 6)
          {
            lblError.innerHTML="Password minimum length is 6 ";
           
            return false;
          }
           if(document.getElementById("pwd").value.length > 12)
          {
            lblError.innerHTML="Password max length is 12";
            
            return false;
          }
          
            lblError.innerHTML=" ";
            
            return true;
          
  }
  function validateRepeatPassword(){
    var pwd= document.getElementById("pwd").value;
    var rpwd= document.getElementById("repeat-pwd").value;
    var lblError = document.getElementById("lblErrorRepeatPass");
    if(rpwd==""){
      lblError.innerHTML="Enter confirm password";
     
      return false;
    }
     if(pwd!=rpwd){
      lblError.innerHTML="Password not matched";
      
      return false;
    }
    
      lblError.innerHTML=" ";
     
      return true;
    
  }
  
  function validatePincode(){
    var pin = document.getElementById("pincode").value;
    var lblError= document.getElementById("lblErrorPincode");
    var postPattern = /^[1-9][0-9]{5}$/;
    if(pin==""){
      lblError.innerHTML="Pincode is required";
      return false;
    }
    else if (!postPattern.test(pin)){
      lblError.innerHTML="enter valid pin";
      return false;
     }
     else{    
      lblError.innerHTML=" ";
     
      return true;
     }

  }

  function validateFlat(){
    var flat = document.getElementById("flat").value;
    var lblError= document.getElementById("lblErrorFlat");

    if(flat==""){
      lblError.innerHTML="The feild is required";
      return false;
    }
    else{
      lblError.innerHTML=" ";  
      return true;
    }

  }

  function validateArea(){
    var area = document.getElementById("area").value;
    var lblError= document.getElementById("lblErrorArea");

    if(area==""){
      lblError.innerHTML="The feild is required";
      return false;
    }
    else{
      lblError.innerHTML=" ";  
      return true;
    }

  }

</script>
</html>