<?php 
session_start();
include('header.php'); 
?>
<br>
<br>
<br>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Kicks & Crafts</title>
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="style.css">

    <style>
        /* General Styling */
        body {
            font-family: 'Open Sans', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .about-container {
            padding: 50px;
            background: #f7f7f7;
        }
        .about-section {
            max-width: 1200px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .about-section h1 {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #222;
        }
        .about-section p {
            line-height: 1.8;
            font-size: 1rem;
            color: #555;
        }
        .about-section .info {
            margin: 30px 0;
        }
        .about-section .info h3 {
            font-size: 1.8rem;
            color: #222;
            margin-bottom: 10px;
        }
        .about-section .info ul {
            list-style: none;
            padding: 0;
        }
        .about-section .info ul li {
            margin-bottom: 10px;
            font-size: 1rem;
            display: flex;
            align-items: center;
        }
        .about-section .info ul li::before {
            content: "✔";
            color: #4CAF50;
            font-weight: bold;
            margin-right: 10px;
        }
        .mission-section {
            background: #808080;
            color: #fff;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
        }
        .mission-section h2 {
            font-size: 2rem;
        }
        .mission-section p {
            color: #fff;
            font-size: 1.1rem;
            margin-top: 10px;
        }
        .contact-info {
            margin-top: 30px;
            text-align: center;
        }
        .contact-info h3 {
            font-size: 1.8rem;
            margin-bottom: 10px;
        }
        .contact-info p {
            font-size: 1rem;
        }
        /* Responsive Design */
        @media (max-width: 768px) {
            .about-section h1 {
                font-size: 2rem;
            }
            .about-section p {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
 
    <div class="about-container">
        <div class="about-section">
            <h1>About Us</h1>
            <p>Welcome to <strong>Kicks & Crafts</strong>, your ultimate destination for stylish, high-quality footwear that meets your fashion and comfort needs. We take pride in offering a curated collection of handcrafted shoes, designed for both everyday wear and special occasions. At Kicks & Crafts, we believe every step matters, and we’re here to ensure yours are both comfortable and fashionable.</p>
            
            <div class="info">
                <h3>What Makes Us Special?</h3>
                <ul>
                    <li>Premium Quality Materials – Every shoe is crafted with top-grade leather, fabric, and materials for durability.</li>
                    <li>Wide Variety – Sneakers, formal shoes, casual wear, and more to suit every personality and occasion.</li>
                    <li>Handcrafted Perfection – Combining traditional craftsmanship with modern designs.</li>
                    <li>Affordable Prices – Luxury footwear without the premium price tag.</li>
                </ul>
            </div>

            <div class="mission-section">
                <h2>Our Mission</h2>
                <p>To redefine the shoe shopping experience by offering handcrafted, stylish, and sustainable footwear that empowers individuals to walk confidently, every day.</p>
            </div>

            <div class="info">
                <h3>Why Choose Kicks & Crafts?</h3>
                <ul>
                    <li>Exceptional Customer Service – Your satisfaction is our priority.</li>
                    <li>Eco-friendly Practices – Committed to sustainability in every step.</li>
                    <li>Exclusive Designs – Stay ahead of the trends with our unique collections.</li>
                </ul>
            </div>

            <div class="contact-info">
                <h3>Contact Us</h3>
                <p>Phone: +91 99981 73929</p>
                <p>Email: support@kicksandcrafts.com</p>
                <p>Address: 123 Shoe Lane, Fashion City, NY 10001</p>
            </div>
        </div>
    </div>
</body>
</html>
<?php include('footer.php'); ?>
