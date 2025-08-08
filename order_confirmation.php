<?php
session_start();

// Check if `order_id` is provided
if (!isset($_GET['order_id'])) {
    echo "Order ID not provided.";
    header("Location: product.php");
    exit();
}

include 'db.php';
$order_id = $_GET['order_id'];

try {
    // Start transaction
    $pdo->beginTransaction();

    // Fetch order details and associated user_id
    $orderStmt = $pdo->prepare("SELECT * FROM orders WHERE order_id = ?");
    $orderStmt->execute([$order_id]);
    $order = $orderStmt->fetch();

    if (!$order) {
        throw new Exception("Order not found.");
    }

    $user_id = $order['user_id']; // Retrieve user_id from the order

    // Fetch shopping cart items for the user
    $cartStmt = $pdo->prepare("
        SELECT sc.*, p.name AS product_name, p.price
        FROM shopping_cart sc
        JOIN products p ON sc.product_id = p.product_id
        WHERE sc.user_id = ?
    ");
    $cartStmt->execute([$user_id]);
    $cart_items = $cartStmt->fetchAll(PDO::FETCH_ASSOC);

    if(!$cart_items){
        header("Location: product.php");
    }

    if (!$cart_items) {
        throw new Exception("Shopping cart is empty.");
        
    }

    // Display cart items in the HTML below...

    // Clear the cart after fetching the details
    $clearCartStmt = $pdo->prepare("DELETE FROM shopping_cart WHERE user_id = ?");
    $clearCartStmt->execute([$user_id]);

    // Commit transaction
    $pdo->commit();
} catch (Exception $e) {
    // Rollback transaction in case of error
    $pdo->rollBack();
    echo "Error: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table th,
        table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table th {
            background: #f8f8f8;
        }

        .total-row td {
            font-weight: bold;
            text-align: right;
        }

        .button-container {
            text-align: center;
            margin: 20px 0;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            background: #333;
            text-decoration: none;
            border-radius: 4px;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #555;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Order Confirmation</h1>
        <p>Thank you for your purchase! Your order ID is: <strong>#<?php echo htmlspecialchars($order['order_id']); ?></strong></p>
        <p>Total Amount: <strong>$<?php echo number_format($order['total_amount'], 2); ?></strong></p>

        <h2>Order Summary</h2>
        <table>
            <tr>
                <th>Product Name</th>
                <th>Color</th>
                <th>Size</th>
                <th>Unit Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
            <?php foreach ($cart_items as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                    <td><?php echo htmlspecialchars($item['color']); ?></td>
                    <td><?php echo htmlspecialchars($item['size']); ?></td>
                    <td>₹<?php echo number_format($item['price'], 2); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>₹<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
            <tr class="total-row">
                <td colspan="5">Total Amount</td>
                <td>₹<?php echo number_format($order['total_amount'], 2); ?></td>
            </tr>
        </table>

        <div class="button-container">
            <a href="index.php" class="btn">Continue Shopping</a>
            <a href="contact_support.php" class="btn">Contact Support</a>
        </div>
    </div>
</body>

</html>