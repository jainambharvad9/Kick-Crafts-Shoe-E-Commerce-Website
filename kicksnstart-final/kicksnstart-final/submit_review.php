<?php
session_start();
include 'db.php';


if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit();
}

if (isset($_POST['submit_review'])) {
    $product_id = $_POST['product_id'];
    $user_id = $_SESSION['user_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    // Insert the review into the database
    $stmt = $pdo->prepare("
        INSERT INTO reviews (product_id, user_id, rating, comment, created_at)
        VALUES (?, ?, ?, ?, NOW())
    ");
    $stmt->execute([$product_id, $user_id, $rating, $comment]);

    $_SESSION['success_message'] = "Review submitted successfully!";
    header("Location: product_detail.php?product_id=" . $product_id);
    exit();
}
?>
