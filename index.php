<?php
session_start();
include 'db.php';

// Fetch products from the database
$stmt = $pdo->prepare("SELECT 
                        products.*, 
                        (SELECT image_url FROM product_images WHERE product_id = products.product_id ORDER BY image_id ASC LIMIT 1) AS image 
                        FROM products 
                        ORDER BY created_at DESC 
                        LIMIT 3"); // Show latest 8 products with the first image
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sneaker Store</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" type="text/css" href="css/base.css" />
    <link rel="stylesheet" type="text/css" href="css/slider.css" />
    <script>
        document.documentElement.className = "js";
        var supportsCssVars = function() {
            var e, t = document.createElement("style");
            return t.innerHTML = "root: { --tmp-var: bold; }", document.head.appendChild(t), e = !!(window.CSS && window.CSS.supports && window.CSS.supports("font-weight", "var(--tmp-var)")), t.parentNode.removeChild(t), e
        };
        supportsCssVars() || alert("Please view this demo in a modern browser that supports CSS Variables.");
    </script>
    <style>
        /* Full-Screen Slider Styles */
        .slider-container {
            position: relative;
            width: 100%;
            height: 100vh;
            overflow: hidden;
        }

        .slider-container img {
            width: 100%;
            height: 100vh;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }

        .slider-container img.active {
            opacity: 1;
        }

        .header {
            position: absolute;
            top: 0;
            width: 100%;
            /* background-color: rgba(255, 255, 255, 0.5); Adjust transparency here */
            z-index: 10;
            /* Ensure header is on top */
            padding: 10px 20px;

        }
    </style>

</head>

<body>
<?php
        include 'header.php';
        ?>
    <!-- Navbar -->
   

    <!-- Full-Screen Slider -->
    <div class="slider-container">
        <img src="imges/s8.jpg" alt="Slide 1" class="active">
        <img src="imges/s1.png" alt="Slide 2">
        <img src="imges/s3.png" alt="Slide 3">
        <img src="imges/s11.jpg" alt="Slide 4">
        <img src="imges/s9.jpg" alt="Slide 5">
        <img src="imges/s10.jpeg" alt="Slide 6">
    </div>

    <!-- Hero Banner -->
    <section class="hero">
        <h2>Find Your Perfect Pair</h2>
        <p>Explore the latest collections and hottest releases</p>
        <button onclick="window.location.href='product.php'">Shop Now</button>
    </section>


    <!-- Featured Section -->
    <section class="featured-section">
        <h3>Latest Arrivals</h3>
        <p>Discover the new and exclusive styles for every occasion</p>
    </section>

    <!-- Product Grid -->
    <section class="product-grid">
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <a href="product_detail.php?product_id=<?php echo $product['product_id']; ?>" class="product-link">
                <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <div class="product-info">
                        <h4><?php echo htmlspecialchars($product['name']); ?></h4>
                        <p class="price">₹<?php echo number_format($product['price'], 2); ?></p>
                        <p><strong>Colour Shown:</strong> <?php echo htmlspecialchars($product['color']); ?></p>
                        <form method="POST" action="cart.php">
                            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                            <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product['name']); ?>">
                            <input type="hidden" name="product_price" value="<?php echo $product['price']; ?>">
                            <input type="hidden" name="product_quantity" value="1" min="1">
                        </form>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </section>

    <!-- Footer -->
    <?php
    include 'footer.php';
    ?>
    <script src='js/anime.min.js'></script>
    <script src='js/pieces.min.js'></script>
    <script src='js/demo.js'></script>
    <script>
        const slides = document.querySelectorAll('.slider-container img');
        let currentSlide = 0;

        function showNextSlide() {
            slides[currentSlide].classList.remove('active');
            currentSlide = (currentSlide + 1) % slides.length;
            slides[currentSlide].classList.add('active');
        }

        // Change slide every 3 seconds
        setInterval(showNextSlide, 3000);
    </script>
</body>

</html>