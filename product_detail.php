<?php
session_start();
include 'db.php';

// Get product ID from the URL
$product_id = isset($_GET['product_id']) ? $_GET['product_id'] : null;

if ($product_id) {
    // Fetch product details
    $stmt = $pdo->prepare("
        SELECT products.*, categories.name AS category_name
        FROM products
        JOIN categories ON products.category_id = categories.category_id
        WHERE products.product_id = ?
    ");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch all images for the product
    $imageStmt = $pdo->prepare("SELECT image_url FROM product_images WHERE product_id = ?");
    $imageStmt->execute([$product_id]);
    $images = $imageStmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch reviews for the product
    $reviewStmt = $pdo->prepare("
        SELECT r.rating, r.comment, r.created_at, u.first_name
        FROM reviews r
        JOIN users u ON r.user_id = u.user_id
        WHERE r.product_id = ?
        ORDER BY r.created_at DESC
    ");
    $reviewStmt->execute([$product_id]);
    $reviews = $reviewStmt->fetchAll(PDO::FETCH_ASSOC);

    // Calculate average rating and review count
    $averageRating = 0;
    $reviewCount = count($reviews);
    if ($reviewCount > 0) {
        $sumRatings = array_reduce($reviews, function($sum, $review) {
            return $sum + $review['rating'];
        }, 0);
        
        $averageRating = round($sumRatings / $reviewCount, 1);
    }

    // Check if product exists
    if (!$product) {
        echo "Product not found.";
        exit();
    }

    // Split sizes into an array
    $sizes = explode(',', $product['size']);
} else {
    echo "Invalid product.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> - Product Details</title>
    <link rel="icon" href="/favicon.ico">
    <link rel="stylesheet" href="product.css">
    <style>
        .reviews-section {
    
    width: 40%;
}

.rating-summary {
    font-size: 16px;
    margin-bottom: 10px;
}

.reviews-list .review-item {
    border: 1px solid #ddd;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 5px;
    background-color: #f9f9f9;
}

.review-form {
    margin-top: 20px;
    width: 100%;
}

.review-form label {
    display: block;
    margin: 10px 0 5px;
}

.review-form select,
.review-form textarea {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border-radius: 4px;
    border: 1px solid #ddd;
}

.submit-review-btn {
    background-color: #808080;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.submit-review-btn:hover {
    background-color:  #808080;
}

    </style>

</head>
<body>
    <?php include 'header.php'; ?>
<br>
<br>
<br><br>
    <div class="product-details-container">
        <!-- Left Section: Images -->
        <div class="product-images-section">
            <div class="main-image">
                <img id="mainImage" src="<?php echo htmlspecialchars($images[0]['image_url'] ?? 'placeholder.jpg'); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
            </div>
            <div class="image-thumbnails">
                <?php foreach ($images as $image): ?>
                    <img class="thumbnail" src="<?php echo htmlspecialchars($image['image_url']); ?>" alt="Thumbnail" onclick="changeMainImage(this.src)">
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Right Section: Product Info -->
        <div style="text-align: justify;" class="product-info-section">
            <h1 class="product-title"><?php echo htmlspecialchars($product['name']); ?></h1>
            <p class="product-price">₹<?php echo number_format($product['price'], 2); ?></p>
            <p class="product-description"><?php echo htmlspecialchars($product['description']); ?></p>
            <p><strong>Category:</strong> <?php echo htmlspecialchars($product['category_name']); ?></p>
            <p><strong>Color:</strong> <?php echo htmlspecialchars($product['color']); ?></p>
            <p><strong>Stock Available:</strong> <?php echo htmlspecialchars($product['stock']); ?></p>

            <!-- Size Selection -->
            <form method="POST" action="cart.php">
                <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product['name']); ?>">
                <input type="hidden" name="product_price" value="<?php echo $product['price']; ?>">
                <input type="hidden" name="product_color" value="<?php echo htmlspecialchars($product['color']); ?>">
                <input type="hidden" name="product_quantity" value="1" min="1">

                <label for="size"><p><strong>Select Size:</strong></p></label>
                <div class="size-options">
                    <?php foreach ($sizes as $size): ?>
                        <label class="size-label">
                            <input type="radio" name="product_size" value="<?php echo htmlspecialchars($size); ?>" required>
                            <?php echo htmlspecialchars($size); ?>
                        </label>
                    <?php endforeach; ?>
                </div>
                <button type="submit" name="add_to_cart" class="add-to-cart-btn">Add to Cart</button>
            </form>
        </div>

        <!-- Reviews Section -->
        <div class="reviews-section">
        <h2>Customer Reviews</h2>
        <div class="rating-summary">
            <p><strong>Overall Rating:</strong> <?php echo $averageRating; ?> / 5 (<?php echo $reviewCount; ?> reviews)</p>
        </div>
        <div class="reviews-list">
            <?php if (!empty($reviews)): ?>
                <?php foreach ($reviews as $review): ?>
                    <div class="review-item">
                        <p><strong><?php echo htmlspecialchars($review['first_name']); ?></strong> - <?php echo htmlspecialchars($review['created_at']); ?></p>
                        <p>Rating: <?php echo str_repeat('⭐', $review['rating']); ?></p>
                        <p><?php echo htmlspecialchars($review['comment']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No reviews yet. Be the first to review this product!</p>
            <?php endif; ?>
        </div>

        <!-- Review Form -->
        <h3>Leave a Review</h3>
        <form method="POST" action="submit_review.php" class="review-form">
            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
            <label for="rating">Rating:</label>
            <select name="rating" id="rating" required>
                <option value="">Select Rating</option>
                <option value="5">5 - Excellent</option>
                <option value="4">4 - Very Good</option>
                <option value="3">3 - Good</option>
                <option value="2">2 - Fair</option>
                <option value="1">1 - Poor</option>
            </select>
            <label for="comment">Comment:</label>
            <textarea name="comment" id="comment" rows="4" required></textarea>
            <button type="submit" class="submit-review-btn" name="submit_review" >Submit Review</button>
        </form>
    </div>

    </div>

    <!-- Reviews Section -->
    <!-- <div class="reviews-section">
        <h2>Customer Reviews</h2>
        <div class="rating-summary">
            <p><strong>Overall Rating:</strong> <?php echo $averageRating; ?> / 5 (<?php echo $reviewCount; ?> reviews)</p>
        </div>
        <div class="reviews-list">
             <?php if (!empty($reviews)): ?>
                <?php foreach ($reviews as $review): ?>
                    <div class="review-item">
                        <p><strong><?php echo htmlspecialchars($review['first_name']); ?></strong> - <?php echo htmlspecialchars($review['created_at']); ?></p>
                        <p>Rating: <?php echo str_repeat('⭐', $review['rating']); ?></p>
                        <p><?php echo htmlspecialchars($review['comment']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No reviews yet. Be the first to review this product!</p>
            <?php endif; ?>
        </div> -->

        <!-- Review Form -->
        <!-- <h3>Leave a Review</h3>
        <form method="POST" action="submit_review.php" class="review-form">
            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
            <label for="rating">Rating:</label>
            <select name="rating" id="rating" required>
                <option value="">Select Rating</option>
                <option value="5">5 - Excellent</option>
                <option value="4">4 - Very Good</option>
                <option value="3">3 - Good</option>
                <option value="2">2 - Fair</option>
                <option value="1">1 - Poor</option>
            </select>
            <label for="comment">Comment:</label>
            <textarea name="comment" id="comment" rows="4" required></textarea>
            <button type="submit" class="submit-review-btn" name="submit_review" >Submit Review</button>
        </form>
    </div> -->

    <?php include 'footer.php'; ?>

    <script>
        function changeMainImage(src) {
            document.getElementById("mainImage").src = src;
        }
    </script>
</body>
</html>
