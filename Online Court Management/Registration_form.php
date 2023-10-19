<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Details</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <script src = "RegFormScript.js"></script>
</head>
<style>
    * {
        padding: 0px;
        margin: 0px;
    }

    #heading {
        background-color: rgba(99, 6, 99, 0.281);
    }

    #img {
        padding-bottom: 15px;
    }

    #main {
        display: flex;
        position: fixed;
    }

    #main1 {
        background-color: white;
        border-right: solid;
        border-right-color: rgb(99, 6, 99);
        border-top-color: rgb(99, 6, 99);
        height: 750px;
        width: 203px;
    }

    #details {
        padding-left: 50px;
    }

    #btn1,
    #btn2,
    #btn4 {
        border: none;
        font-size: 16px;
        cursor: pointer;
        padding: 10px 37px 10px 16px;
        width: 203px;
        background-color: white;
        text-align: left;
    }

    #btn1:focus-within,
    #btn2:focus-within,
    #btn4:focus-within {
        background-color: rgb(99, 6, 99);
        color: white;
    }

    fieldset {
        margin-top: 40px;
        padding-left: 55px;
        width: 1000px;
    }

    #txt1,.txt1 {
        width: 450px;
        height: 30px;
        padding: 2px 2px 2px 6px;
        color: rgb(99, 6, 99);
        border-radius: 8px;
        border-color: rgb(237, 211, 247);
    }

    #btn3 {
        padding-left: 26px;
        background-color: rgb(99, 6, 99);
        color: white;
        border: none;
        font-size: 16px;
        cursor: pointer;
        padding: 10px 22px 10px 16px;
        border-radius: 15px;
    }

    #btn3:hover {
        background-color: wheat;
        color: rgb(99, 6, 99);
    }

    table,
    td,
    th {
        border-style: solid;
        border-width: 1px;
        border-collapse: collapse;
        background-color: darkgray;
        border-color: white;
        font-size: large;
    }
    .error_form
    {
        top: 10px;
        color: rgb(216, 15, 15);
        font-size: 15px;
        font-family: Helvetica;
    }
    th {
        color: white;
        font-size: x-large;
    }

    #si {
        width: 120px;
        text-align: center;
    }

    #complaint {
        text-align: left;
        width: 630px;
    }

    #status {
        width: 200px;
    }

    #pic {
        
        padding-left: 14px;
        padding-top: 14px;
        padding-bottom: 10px;
display: inline-block; 
position: relative; 
width: 180px; 
height: 180px; 
overflow: hidden; 
border-radius: 20%;
    }
</style>

<body onload="load()">
    <div id="heading">
        <h1 style="color: rgb(104, 7, 104);"><i>Kerala Judicial Portal</i></h1><br>
    </div>
    <div id="main">
        <div id="main1">
            <input type="image" src="https://www.ajaydubedi.com/wp-content/uploads/2016/06/user-add-icon.png"alt="" height="150px"
            width="150px" id="pic"/>
            <input type="file" id="my_file" style="display: none;" accept=".jpeg,.png,.jpg" onchange="loadFile(event)"/>
            <center>
                <h4>Appu</h4>
            </center><br>
            <input type="button" value="Personal Details" id="btn1" onclick=load()>
            <input type="button" value="Complaint Registration" id="btn2" onclick="reg()">
            <input type="button" value="Complaint Status" id="btn4" onclick="stat()">
        </div>
        <div id="details"><br>
            <div id="details_1">
                <fieldset style="border-color: rgb(211, 42, 211); border-radius: 10px;">
                    <legend>
                        <h2 style="color: rgb(99, 6, 99)">PERSONAL DETAILS</h2>
                    </legend><br>
                    <span class="error_form" id="name_error_message"></span>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                    &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                    &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                    <span class="error_form" id="mob_error_message"></span>
                    <br>
                    <input type="text" class="txt1" placeholder="Name" id = "name" name="name" required>&emsp;
                    <input type="text" class="txt1" id = "mob" placeholder="Mobile Number" required><br><br>
                    <span class="error_form" id="email_error_message"></span>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                    &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                    &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                    <span class="error_form" id="remail_error_message"></span><br>
                    <input type="email" name="email" id = "email" required class="txt1" placeholder="Mail-id">&emsp;
                    <input type="email" name="email" id = "remail" required class="txt1" placeholder="Alternate Mail-id"><br><br>
                    <span class="error_form" id="fname_error_message"></span>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                    &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                    &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                    <span class="error_form" id="mname_error_message"></span>
                    <br>
                    <input type="text" class="txt1" id = "fname" placeholder="Father Name" required>&emsp;
                    <input type="text" class="txt1" id = "mname" placeholder="Mother Name" required><br><br>
                    <input type="text" placeholder="Date of Birth" class="txt1" id="datepicker">
                    <br>
                    Gender:&emsp;<input type="radio" name="gender" id="male"><label for="male"> Male</label>
                    &emsp;<input type="radio" name="gender" id="female"><label for="female"> Female</label>
                    &emsp;<input type="radio" name="gender" id="others"><label for="others">
                        Others</label>
                    
                    <br><br>
                    </span>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                    &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                    &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                    <span class="error_form" id="add1_error_message"></span>
                    <br>
                    <select class="txt1" id = "dist" name = "dist">
                        <option value="0" disabled selected hidden>Enter your District</option>
                        <option>Alappuzha</option>
                        <option>Ernakulam</option>
                        <option>Idukki</option>
                        <option>Kannur</option>
                        <option>Kasargod</option>
                        <option>Kollam</option>
                        <option>Kottayam</option>
                        <option>Kozhikode</option>
                        <option>Malappuram</option>
                        <option>Palakkad</option>
                        <option>Pathanamthitta</option>
                        <option>Thiruvananthapuram</option>
                        <option>Thrissur</option>
                        <option>Wayanad</option>
                    </select>&emsp;&emsp;
                    <input type="text" class="txt1" id = "add1" placeholder="Address line 1">&emsp;
                    <br><br>
                    <span class="error_form" id="add2_error_message"></span>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                    &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                    &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                    <span class="error_form" id="post_error_message"></span>
                    <br>
                    <input type="text" class="txt1" id = "add2" placeholder="Address line 2">&emsp;&nbsp;
                    <input type="number" class="txt1" id = "post" placeholder="Post code" required>&emsp;<br><br>
                    Upload Aadhar Card &emsp;<input type="file" accept=".png, .jpg, .jpeg, .pdf">&emsp;
                    <br><br>
                    <input type="button" id="btn3" value="Submit" height="200px" width="200px"
                        style="margin-left: 410px;">
                        
                    <br><br>
                    <br>
                </fieldset>
            </div>
            <br>
        </div>
        <div id="reg" style="padding-left:35px"><br>
            <div id="reg_1">
                <fieldset style="border-color: rgb(211, 42, 211); border-radius: 10px;">
                    <legend>
                        <h2 style="color: rgb(99, 6, 99)">COMPLAINT REGISTRATION</h2>
                    </legend><br>
                    Enter your complaint: <br><br>
                    <textarea name="complaint" id="comp" cols="128" rows="15"
                        title="Enter your complaint"></textarea><br><br>
                    <center>
                        <input type="Button" id="btn3" value="Save and Upload" onclick="submit()">
                    </center><br><br>
                </fieldset>
            </div>
        </div>
        <div id="stat" style="padding-left:35px"><br>
            <div id="stat_1">
                <fieldset style="border-color: rgb(211, 42, 211); border-radius: 10px;">
                    <legend>
                        <h2 style="color: rgb(99, 6, 99)">COMPLAINT STATUS</h2>
                    </legend><br>
                    <table>
                        <tr>
                            <th id="si">SI No.</th>
                            <th id="complaint">Complaint</th>
                            <th id="status">Status</th>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                    <br><br>
                </fieldset>

            </div>
        </div>
    </div>

</body>

</html>