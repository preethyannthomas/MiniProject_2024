<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("connection.php");

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM tbl_customer WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $userDetails = mysqli_fetch_assoc($result);
        $name = $userDetails['customer_name'];
    }
    

    $query = "SELECT * FROM tbl_user WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $userDetails = mysqli_fetch_assoc($result);
        $email = $userDetails['email'];
      
    } 
 
} else {
 
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap"
        rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

    <title>SwapZone</title>
    <link rel="icon" href="images/logo.png">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.css">
    <link rel="stylesheet" href="css/templatemo-hexashop.css">
    <link rel="stylesheet" href="css/owl-carousel.css">
    <link rel="stylesheet" href="css/lightbox.css">
</head>
<style>
    body{
        background-image:url('images/backgroundAddress.jpg');
    }
</style>
<body>

<?php include('customer_header.php')?>
    <section id  = "updateProfile">
    <?php 
    $_GET['category_id'] = 4; 
    include('productList.php'); 
    ?>
    </section>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <script src="js/jquery-2.1.0.min.js"></script>

 
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>


    <script src="js/owl-carousel.js"></script>
    <script src="js/accordions.js"></script>
    <script src="js/datepicker.js"></script>
    <script src="js/scrollreveal.min.js"></script>
    <script src="js/waypoints.min.js"></script>
    <script src="js/jquery.counterup.min.js"></script>
    <script src="js/imgfix.min.js"></script>
    <script src="js/slick.js"></script>
    <script src="js/lightbox.js"></script>
    <script src="js/isotope.js"></script>

    <script src="js/custom.js"></script>

    <script>

        $(function () {
            var selectedClass = "";
            $("p").click(function () {
                selectedClass = $(this).attr("data-rel");
                $("#portfolio").fadeTo(50, 0.1);
                $("#portfolio div").not("." + selectedClass).fadeOut();
                setTimeout(function () {
                    $("." + selectedClass).fadeIn();
                    $("#portfolio").fadeTo(50, 1);
                }, 500);

            });
        });

    </script>
    <script>
    $(document).ready(function() {
        $(".category-button").on("click", function() {
            var category = $(this).data("category");
            window.location.href = "product_list.php?category=" + category;
        });
    });
</script>


</body>

</html>