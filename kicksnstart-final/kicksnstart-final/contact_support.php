<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}
include ('db.php');

?>

<br>
<br>
<br>
<br><br>
<br>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Support - Kicks & Crafts</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Custom styles for Contact Support page */
        .contact-container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background: #f9f9f9;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .contact-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .contact-header h1 {
            color: #333;
        }

        .contact-info {
            margin-bottom: 30px;
            font-size: 1.1em;
            line-height: 1.8em;
            color: #555;
        }

        .contact-info ul {
            list-style: none;
            padding: 0;
        }

        .contact-info ul li {
            margin-bottom: 10px;
        }

        .contact-info ul li i {
            color: #007bff;
            margin-right: 10px;
        }

        .contact-form {
            width: 100%;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-group textarea {
            height: 100px;
        }

        .form-group button {
            background: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 1.1em;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        .form-group button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="contact-container">
        <div class="contact-header">
            <h1>Contact Support</h1>
            <p>We’re here to help! Reach out to us for any queries or assistance.</p>
        </div>

        <div class="contact-info">
            <h2>How to Reach Us</h2>
            <ul>
                <li><i class="fas fa-phone-alt"></i> <strong>Phone:</strong> +91 999-817-2939</li>
                <li><i class="fas fa-envelope"></i> <strong>Email:</strong> support@kicksandcrafts.com</li>
                <li><i class="fas fa-map-marker-alt"></i> <strong>Address:</strong> 123 Sneakers Lane, Fashion City, USA</li>
                <li><i class="fas fa-clock"></i> <strong>Support Hours:</strong> Mon-Fri: 9 AM - 5 PM (EST)</li>
            </ul>
        </div>

        <form class="contact-form" method="POST" action="process_contact.php">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Your full name" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Your email address" required>
            </div>
            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject" placeholder="Subject of your message" required>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" placeholder="Write your message here..." required></textarea>
            </div>
            <div class="form-group">
                <button type="submit">Send Message</button>
            </div>
        </form>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
