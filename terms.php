<?php 
session_start();
include('header.php'); ?>
<br>
<br>
<br>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms & Conditions - Kicks & Crafts</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* General Styling */
        body {
            font-family: 'Open Sans', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .terms-container {
            padding: 50px;
            background: #f7f7f7;
        }
        .terms-section {
            max-width: 1200px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .terms-section h1 {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #222;
        }
        .terms-section table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 1rem;
        }
        .terms-section table th, .terms-section table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .terms-section table th {
            background: #4CAF50;
            color: #fff;
        }
        .terms-section p {
            line-height: 1.8;
            font-size: 1rem;
            color: #555;
        }
        .message-form {
            margin-top: 30px;
            padding: 30px;
            background: #f7f7f7;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .message-form h2 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 20px;
        }
        .message-form form {
            max-width: 600px;
            margin: 0 auto;
        }
        .message-form label {
            display: block;
            margin: 10px 0 5px;
            font-size: 1rem;
        }
        .message-form input, .message-form textarea, .message-form button {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .message-form textarea {
            resize: vertical;
            height: 100px;
        }
        .message-form button {
            background: #4CAF50;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        .message-form button:hover {
            background: #45a049;
        }
    </style>
</head>
<body>
    <div class="terms-container">
        <div class="terms-section">
            <h1>Terms & Conditions</h1>
            <p>At <strong>Kicks & Crafts</strong>, we are committed to providing our customers with the best shopping experience. Please read our terms and conditions carefully to understand our policies.</p>

            <h2>Delivery Instructions & Payment Methods</h2>
            <table>
                <tr>
                    <th>Policy</th>
                    <th>Details</th>
                </tr>
                <tr>
                    <td>Delivery Time</td>
                    <td>Standard delivery takes 5-7 business days. Express delivery is available for an additional fee.</td>
                </tr>
                <tr>
                    <td>Delivery Charges</td>
                    <td>Free delivery on orders above ₹5000. A flat shipping fee of ₹50 applies for smaller orders.</td>
                </tr>
                <tr>
                    <td>Payment Methods</td>
                    <td>We accept Credit/Debit Cards, PayPal, and Cash on Delivery (COD).</td>
                </tr>
                <tr>
                    <td>International Shipping</td>
                    <td>Currently, we only ship within the United States.</td>
                </tr>
            </table>

            <h2>Returns & Refunds</h2>
            <table>
                <tr>
                    <th>Policy</th>
                    <th>Details</th>
                </tr>
                <tr>
                    <td>7-Day Replacement</td>
                    <td>If the product is defective or damaged, request a replacement within 7 days of delivery.</td>
                </tr>
                <tr>
                    <td>24-Hour Refund</td>
                    <td>Refunds are processed within 24 hours after the returned product is received and inspected.</td>
                </tr>
                <tr>
                    <td>Refund Method</td>
                    <td>Refunds will be credited to your original payment method or as store credit.</td>
                </tr>
            </table>
        </div>

        <!-- Message Form Section -->
        <div class="message-form">
            <h2>Message Customer Support</h2>
            <form action="send_message.php" method="POST">
                <label for="name">Your Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your name" required>

                <label for="email">Your Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email address" required>

                <label for="message">Your Message</label>
                <textarea id="message" name="message" placeholder="Write your message here..." required></textarea>

                <button type="submit">Send Message</button>
            </form>
        </div>
    </div>
</body>
</html>
<?php include('footer.php'); ?>
