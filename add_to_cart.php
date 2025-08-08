<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';
$product_id = $_GET['product_id'];
$user_id = $_SESSION['user_id'];

// Insert the product into the shopping cart
$stmt = $pdo->prepare("INSERT INTO shopping_cart (user_id, product_id, quantity) VALUES (?, ?, 1)
    ON DUPLICATE KEY UPDATE quantity = quantity + 1");
$stmt->execute([$user_id, $product_id]);

//header("Location: cart.php");
//echo '<script>alert("Added Successfully")</script>';
exit();
?>