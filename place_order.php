<?php
include("connection.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        echo 'error';
        exit();
    }

    $customerId = $_SESSION['user_id'];

    if (isset($_POST['cartData']) && is_array($_POST['cartData'])) {
        $cartData = $_POST['cartData'];

        // Start a database transaction
        mysqli_begin_transaction($conn);

        // Create a new order
        $orderDate = date("Y-m-d H:i:s");
        $status = "Pending";

        $insertOrderQuery = "INSERT INTO tbl_order (customer_id, order_date, total_amount, status) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $insertOrderQuery);

        if ($stmt) {
            $totalAmount = 0;

            foreach ($cartData as $item) {
                $cartId = $item['cart_id'];
                $quantity = $item['quantity'];

                // Fetch product price and product_id
                $fetchProductDataQuery = "SELECT pd.new_price, pd.product_id, pd.detail_id FROM tbl_cart c
                    INNER JOIN tbl_productdetail pd ON c.product_id = pd.product_id AND c.size = pd.size
                    WHERE c.cart_id = ? AND c.user_id = ? AND c.status = 1";
                $stmtFetchProductData = mysqli_prepare($conn, $fetchProductDataQuery);
                mysqli_stmt_bind_param($stmtFetchProductData, 'ss', $cartId, $customerId);
                mysqli_stmt_execute($stmtFetchProductData);
                mysqli_stmt_bind_result($stmtFetchProductData, $price, $productId, $detailId);

                if (mysqli_stmt_fetch($stmtFetchProductData)) {
                    $totalAmount += $price * $quantity;

                    // Insert into tbl_orderdetail
                    $insertOrderDetailQuery = "INSERT INTO tbl_orderdetail (order_id, product_id, quantity, detail_id) VALUES (?, ?, ?, ?)";
                    $stmtInsertOrderDetail = mysqli_prepare($conn, $insertOrderDetailQuery);
                    mysqli_stmt_bind_param($stmtInsertOrderDetail, 'ssss', $orderId, $productId, $quantity, $detailId);

                    if (mysqli_stmt_execute($stmtInsertOrderDetail)) {
                        // Set the status in tbl_cart to 0
                        $updateCartStatusQuery = "UPDATE tbl_cart SET status = 0 WHERE cart_id = ?";
                        $stmtUpdateCartStatus = mysqli_prepare($conn, $updateCartStatusQuery);
                        mysqli_stmt_bind_param($stmtUpdateCartStatus, 's', $cartId);

                        if (!mysqli_stmt_execute($stmtUpdateCartStatus)) {
                            mysqli_rollback($conn);
                            echo 'error';
                            exit();
                        }
                    } else {
                        mysqli_rollback($conn);
                        echo 'error';
                        exit();
                    }
                } else {
                    mysqli_rollback($conn);
                    echo 'error';
                    exit();
                }
            }

            // Insert the order
            $stmt = mysqli_prepare($conn, $insertOrderQuery);
            mysqli_stmt_bind_param($stmt, 'ssss', $customerId, $orderDate, $totalAmount, $status);

            if (mysqli_stmt_execute($stmt)) {
                // Commit the transaction
                mysqli_commit($conn);
                echo 'success';
                exit();
            } else {
                // Rollback the transaction in case of an error
                mysqli_rollback($conn);
                echo 'error';
                exit();
            }
        } else {
            echo 'error';
            exit();
        }
    } else {
        echo 'error';
        exit();
    }
}
?>
