<?php
session_start();
include 'db.php'; // Include database connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : []; // Access cart items

// Calculate total amount
$total_amount = 0;
foreach ($cart_items as $cart_item) {
    $item_total = $cart_item['price'] * $cart_item['quantity']; // Calculate total for this item
    $total_amount += $item_total; // Add to total amount
}
?>
<br>
<br>
<br>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Kicks & Crafts</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f4f4;
        }

        .checkout-container {
            max-width: 1200px;
            margin: 30px auto;
            background: #fff;
            border-radius: 10px;
            padding: 20px 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background: #808080;
            color: #fff;
        }

        table tr:last-child td {
            border-bottom: none;
        }

        table td {
            font-size: 0.9rem;
            color: #555;
        }

        .total-amount {
            text-align: right;
            font-size: 1.2rem;
            margin: 10px 0;
        }

        form {
            max-width: 800px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            color: #333;
            font-size: 1rem;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 0.9rem;
        }

        button {
            background: #808080;
            color: #fff;
            font-size: 1rem;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background: #808080;
        }

        .continue-shopping {
            text-align: center;
            margin-top: 15px;
        }

        .continue-shopping a {
            text-decoration: none;
            color: #808080;
            font-weight: 600;
        }

        .continue-shopping a:hover {
            text-decoration: underline;
        }

        .summary-header {
            background: #f7f7f7;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .payment-methods img {
            width: 50px;
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="checkout-container">
        <h2>Checkout</h2>
        <?php if (empty($cart_items)): ?>
            <p>Your cart is empty. <a href="index.php">Continue shopping</a>.</p>
        <?php else: ?>
            <!-- Order Summary -->
            <div class="summary-header">
                <h3>Order Summary</h3>
            </div>
            <table>
                <tr>
                    <th>Product</th>
                    <th>Color</th>
                    <th>Size</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
                <?php foreach ($cart_items as $cart_item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($cart_item['name']); ?></td>
                        <td><?php echo htmlspecialchars($cart_item['color']); ?></td>
                        <td><?php echo htmlspecialchars($cart_item['size']); ?></td>
                        <td>₹<?php echo number_format($cart_item['price'], 2); ?></td>
                        <td><?php echo $cart_item['quantity']; ?></td>
                        <td>₹<?php echo number_format($cart_item['price'] * $cart_item['quantity'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <p class="total-amount"><strong>Total Amount: ₹<?php echo number_format($total_amount, 2); ?></strong></p>

            <!-- Checkout Form -->
            <form method="POST" action="process_checkout.php">
                <h3>Shipping Information</h3>
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" placeholder="Enter your address" required>

                <label for="city">City:</label>
                <input type="text" id="city" name="city" placeholder="Enter your city" required>

                <label for="postal_code">Postal Code:</label>
                <input type="text" id="postal_code" name="postal_code" placeholder="Enter your postal code" required>

                <h3>Payment Method</h3>
                <div class="payment-methods">
                    <img src="imges\women\visa.png" alt="Visa">
                    <img src="imges\women\mastercard.png" alt="MasterCard">
                    <img src="imges\women\paypal.png" alt="PayPal">
                </div>

                <button type="submit" id="razorpay-button">Pay with Razorpay</button>
            </form>
            <div class="continue-shopping">
                <a href="index.php">Continue Shopping</a>
            </div>
        <?php endif; ?>
    </div>

    <?php include 'footer.php'; ?>

    <script>
    const options = {
        key: "rzp_test_DWRZo0KhaNrAyw", // Razorpay Test API Key
        amount: "<?php echo $total_amount * 100; ?>", // Amount in paisa
        currency: "INR",
        name: "Kicks & Crafts",
        description: "Order Payment",
        handler: function (response) {
            fetch('process_checkout.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    razorpay_payment_id: response.razorpay_payment_id,
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Display the modal pop-up
                    const modal = document.getElementById('order-success-modal');
                    document.getElementById('order-id').textContent = data.order_id;
                    modal.style.display = 'block';

                    // Redirect to confirmation page after 5 seconds
                    setTimeout(() => {
                        window.location.href = 'order_confirmation.php?order_id=' + data.order_id;
                    }, 5000);
                } else {
                    alert('Payment Failed: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Payment failed. Please try again.');
            });
        },
        theme: {
            color: "#3399cc",
        },
    };

    document.getElementById('razorpay-button').onclick = function (e) {
        e.preventDefault();
        const rzp = new Razorpay(options);
        rzp.open();
    };

    // Close modal if user clicks outside of it
    window.onclick = function(event) {
        const modal = document.getElementById('order-success-modal');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    };


   </script>
   <!-- Order Success Modal -->
<div id="order-success-modal" style="display: none; position: fixed; z-index: 999; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.5);">
    <div style="background-color: #fff; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 80%; max-width: 400px; border-radius: 10px; text-align: center;">
        <h2 style="color: #808080;">Order Placed Successfully!</h2>
        <p>Your order ID is: <span id="order-id" style="font-weight: bold; color: #333;"></span></p>
        <p>Thank you for shopping with Kicks & Crafts.</p>
        <p>You will be redirected shortly...</p>
        <button onclick="document.getElementById('order-success-modal').style.display='none';" style="margin-top: 10px; padding: 10px 20px; background: #4CAF50; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Close</button>
    </div>
</div>

</body>

</html>