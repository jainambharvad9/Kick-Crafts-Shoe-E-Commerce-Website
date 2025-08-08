<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

include 'db.php';

$product_id = $_GET['product_id'];

// Delete product from the database
$stmt = $pdo->prepare("DELETE FROM products WHERE product_id = ?");
$stmt->execute([$product_id]);

echo "Product deleted successfully!";
header("Location: manage_products.php");
exit();
?>
