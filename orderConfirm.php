<?php
include("connection.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    header('location:./');
}

$user_id = $_SESSION['user_id'];

$query = "SELECT c.*, p.product_name, pd.size, pd.new_price
          FROM tbl_cart c
          INNER JOIN tbl_product p ON c.product_id = p.product_id
          INNER JOIN tbl_productdetail pd ON c.product_id = pd.product_id AND c.size = pd.size
          WHERE c.user_id = '$user_id' AND c.status = 1";

$result = mysqli_query($conn, $query);

$query_user = "SELECT * FROM tbl_user WHERE user_id = '$user_id'";
$result_user = mysqli_query($conn, $query_user);
$row_user = mysqli_fetch_assoc($result_user);

$customer_email = $row_user['email'];

$query_address = "SELECT * FROM tbl_address WHERE user_id = '$user_id' AND is_default = 1";
$result_address = mysqli_query($conn, $query_address);
$row_address = mysqli_fetch_assoc($result_address);
$shipping_name = $row_address['name'];
$shipping_mobile_number = $row_address['mobile_number'];
$shipping_address = $row_address['address'] . ', ' . $row_address['area'] . ', ' . $row_address['city'] . ', ' . $row_address['state'] . ', ' . $row_address['pincode'];

$total_amount = 0;

while ($row = mysqli_fetch_assoc($result)) {
    $total_amount += $row['new_price'] * $row['quantity'];
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<?php include('customer_header.php') ?>

<section>
    <br><br><br><br>
    <div class="container mt-4">
        <h2>Order Confirmation</h2>
        <br>        <h4>Customer Information</h4>
        <br>

        <p>Email: <?php echo $customer_email; ?></p>
        <br>

        <h4>Order Details</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Size</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
                mysqli_data_seek($result, 0); 
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td>' . $row['product_name'] . '</td>';
                    echo '<td>' . $row['size'] . '</td>';
                    echo '<td>Rs ' . $row['new_price'] * $row['quantity'] . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
        <br>

        <h4>Shipping Address</h4><br>
        <p>Name: <?php echo $shipping_name; ?></p>
        <p>Mobile Number: <?php echo $shipping_mobile_number; ?></p>
        <p><?php echo $shipping_address; ?></p>
        <br>

        <h4>Total Amount: Rs <?php echo $total_amount; ?></h4> 
        <br><a href="payment.html"><button class = "btn btn-secondary">Buy Now</button></a>
    </div>
   
</section>

<?php include('customer_footer.php') ?>
</body>
</html>
