<?php
include 'db.php';
$stmt = $pdo->query("SELECT * FROM products");

while ($product = $stmt->fetch()) {
    echo "<div>
            <h3>{$product['name']}</h3>
            <p>Price: {$product['price']}</p>
            <a href='product.php?product_id={$product['product_id']}'>View Details</a>
          </div>";
}
?>
