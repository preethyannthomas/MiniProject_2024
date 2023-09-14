<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Add your custom CSS styles here */
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Your Shopping Cart</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Placeholder cart items -->
                <tr>
                    <td>Product Name 1</td>
                    <td>2</td>
                    <td>$25.00</td>
                    <td>$50.00</td>
                    <td><button class="btn btn-danger btn-sm">Remove</button></td>
                </tr>
                <tr>
                    <td>Product Name 2</td>
                    <td>1</td>
                    <td>$30.00</td>
                    <td>$30.00</td>
                    <td><button class="btn btn-danger btn-sm">Remove</button></td>
                </tr>
                <!-- Add more rows for other cart items -->
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3"></td>
                    <td><strong>Total: $80.00</strong></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
        <div class="text-center">
            <a href="#" class="btn btn-primary">Continue Shopping</a>
            <a href="#" class="btn btn-success">Checkout</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
