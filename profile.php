<!DOCTYPE html>
<html lang="en">
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .align-right {
        text-align: left;
    }
    </style>
</head>
<body>
    <?php include('customer_header.php') ?>
    <section><br><br>
    <div class="container mt-5">
        <div class="row">
            
            <br>
            </div>

           <br> 
            <?php
            session_start();
            if (!isset($_SESSION['user_id'])) {
                header('location:./');
            }
            require 'connection.php'; 
            $user_id = $_SESSION['user_id'];
            $query2 = "SELECT * FROM tbl_user WHERE user_id = '$user_id'";
            $result2 = mysqli_query($conn, $query2);
            $row2 = mysqli_fetch_assoc($result2);
            $mail = $row2['email'];
            $user_id = $_SESSION['user_id'];
            $query1 = "SELECT * FROM tbl_customer WHERE user_id = '$user_id'";
            $result1 = mysqli_query($conn, $query1);
            
            
            while ($row1 = mysqli_fetch_assoc($result1) ) {

                echo '<div class="col-lg-6 mb-4">';
                            
                
                
                
                echo '</div>';
                
             
                echo '<div class="card">';
                echo '<div class="card-body">';
                echo '<div >';
                echo '<p class="card-text"><h3>Personal Details <a href = "updateProfile.php">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<i class="fas fa-edit" style="color: #89a9e1;height:25px;"></i></a></h3></p>';
                echo '<p class="card-text"><br><table><tr><td>Name: </td><td  class="align-right">' . $row1['customer_name'] . '</td></p>';
                echo '<p class="card-text"><tr><td>Mail id: </td><td class="align-right">' .  $mail . '</td></p>';
                echo '<p class="card-text"><tr><td>Contact number: &emsp; &emsp; &emsp;</td><td class="align-right">' . $row1['contact_no'] . '</td></p>';
                echo '<p class="card-text"><tr><td>Password: </td><td class="align-right">*********</td></table></p></div>';
             
                echo '</div>';
            }
            
            mysqli_close($conn); // Close the database connection
            ?>
        </div>
    </div>
    </section>
    <section>
    
    <div class="container mt-5">
    
        <div class="row">
           
            <div class="col-lg-4 mb-4">               
                        <a href="addAddress.php"><img src = "images/addAddress.png" style = "height:280px;width:320px;"></a>
                   
            </div>
            <?php           
            require 'connection.php';             
            $user_id = $_SESSION['user_id'];
            $query = "SELECT * FROM tbl_address WHERE user_id = '$user_id'";
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)) {

                echo '<div class="col-lg-4 mb-4">';
                echo '<div class="card">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $row['name'] . '</h5>';
                echo '<p class="card-text">' . $row['mobile_number'] . '</br> '. $row['address'] . '</br> ' . $row['city'] . '</br> ' . $row['area'] . '</br> ' . $row['state'] . ' </br>' . $row['pincode'] . '</p><br>';
                echo '<a href="edit_address.php?address_id=' . $row['address_id'] . '" class="text-primary"><small>Edit</small></a>';
                echo ' | ';
                echo '<a href="remove_address.php?address_id=' . $row['address_id'] . '" class="text-primary"><small>Remove</small></a>';
                
                if ($row['is_default'] == 1) {
                    echo ' |<small> Default </small>';
                } else {
                    echo ' | <a href="set_default_address.php?address_id=' . $row['address_id'] . '" class="text-primary"><small>Set as Default</small></a>';
                }
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            
            mysqli_close($conn); 
            ?>
        </div>
    </div>
    </section>
    <?php include('customer_footer.php') ?>
   
    <script src="js/myscripts.js"> </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>