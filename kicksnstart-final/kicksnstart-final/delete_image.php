<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

include 'db.php';

// Get image_id and product_id from the query string
$image_id = $_GET['image_id'];
$product_id = $_GET['product_id'];

// Fetch the image details from the database
$stmt = $pdo->prepare("SELECT image_url FROM product_images WHERE image_id = ?");
$stmt->execute([$image_id]);
$image = $stmt->fetch();

if ($image) {
    $imagePath = $image['image_url'];

    // Delete the image file from the server
    if (file_exists($imagePath)) {
        unlink($imagePath); // Removes the file
    }

    // Delete the image record from the database
    $stmt = $pdo->prepare("DELETE FROM product_images WHERE image_id = ?");
    $stmt->execute([$image_id]);

    // Redirect back to the edit product page with a success message
    header("Location: edit_product.php?product_id=$product_id&status=success");
    exit();
} else {
    // Redirect back with an error message if the image doesn't exist
    header("Location: edit_product.php?product_id=$product_id&status=error");
    exit();
}
?>
