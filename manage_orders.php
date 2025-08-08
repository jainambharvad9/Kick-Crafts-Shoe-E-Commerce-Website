<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

include 'db.php';   

// Fetch all orders
$stmt = $pdo->query("SELECT * FROM orders");
$orders = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Orders</title>
</head>
<style>
    body {
        text-align: center;
    }

    .product {
        width: 99%;
        /* Adjust for 3 columns with 20px gap */
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 16px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        background-color: #fff;
        margin: 10px;
    }

    a button {
        margin: 10px 10px;
        display: inline-block;
        outline: 0;
        border: 0;
        cursor: pointer;
        font-weight: 600;
        color: rgb(72, 76, 122);
        font-size: 14px;
        height: 38px;
        padding: 8px 24px;
        border-radius: 50px;
        background-image: linear-gradient(180deg, #fff, #f5f5fa);
        box-shadow: 0 4px 11px 0 rgb(37 44 97 / 15%),
            0 1px 3px 0 rgb(93 100 148 / 20%);
        transition: all 0.2s ease-out;
    }

    a button:hover {
        box-shadow: 0 8px 22px 0 rgb(37 44 97 / 15%),
            0 4px 6px 0 rgb(93 100 148 / 20%);
            scale: 1.1;
        color: #fff;
        background-image: linear-gradient(180deg, #808080, #808080);
    }
</style>

<body>
    <?php include 'header.php'; ?>
    <br><br><br><br>

    <h1>Manage Orders</h1>

    <?php foreach ($orders as $order): ?>
        <div style="text-align: justify;" class="product">
            <h3>Order ID: <?php echo htmlspecialchars($order['order_id']); ?></h3>
            <p>User ID: <?php echo htmlspecialchars($order['user_id']); ?></p>
            <p>Total Amount: $<?php echo htmlspecialchars($order['total_amount']); ?></p>
            <p>Deliverd Status: <?php echo htmlspecialchars($order['order_status']); ?></p>
            <p>Payment Status: <?php echo htmlspecialchars($order['payment_status']); ?></p>
            <a href="update_order_status.php?order_id=<?php echo $order['order_id']; ?>"><button>Update Status</button></a>
        </div>
    <?php endforeach; ?>
</body>

</html>