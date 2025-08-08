<link rel="stylesheet" href="style.css">

<?php
include 'db.php'; // Database connection
session_start();


if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit();
}


// Get the category and search filter from URL if set, default to showing all
$category = isset($_GET['category']) ? $_GET['category'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Prepare SQL query based on filters
$query = "
    SELECT products.*, categories.name AS category_name, 
        (SELECT image_url FROM product_images WHERE product_id = products.product_id ORDER BY image_id ASC LIMIT 1) AS image
    FROM products
    JOIN categories ON products.category_id = categories.category_id
    WHERE 1 = 1
";

$params = [];

// Apply category filter
if ($category) {
    $query .= " AND categories.name = :category";
    $params[':category'] = $category;
}

// Apply search filter
if ($search) {
    $query .= " AND products.name LIKE :search";
    $params[':search'] = '%' . $search . '%';
}

// Prepare and execute the query
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.ico">
    <title>Products</title>
    <style>
                input, select, textarea {
            width: 139px;
            padding: 10px;
            font-size: 14px;
            text-align: center;
            align-items: center;
            border: 1px solid #dddddd;
            border-radius: 4px;
            background: #f9f9f9;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>
<br><br><br>
    <!-- Category Filter and Search Bar -->
    <div class="togg">
        <a href="product.php?category=Men"><button>Men</button></a>
        <a href="product.php?category=Women"><button>Women</button></a>
        <a href="product.php"><button>All</button></a> <!-- Reset Filter -->

        <!-- Search Form -->
        <form method="GET" action="product.php" class="search-form">
            <input type="text" id="hid" name="search" placeholder="Search Products..." value="<?php echo htmlspecialchars($search); ?>">
            <a href=""><button type="submit">Search</button></a>
        </form>
    </div>

    <!-- Product Display -->
    <section class="product-grid">
        <?php if (count($products) > 0): ?>
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
                                <input type="hidden" name="product_quantity" value="1">
                                <!-- <button type="submit" name="add_to_cart">Add to Cart</button> -->
                            </form>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No products found. Try adjusting your search or filter.</p>
        <?php endif; ?>
    </section>

    <?php include 'footer.php'; ?>
    <!-- <script>
    // Toggle visibility of the search input field
    function toggleSearch() {
        const searchInput = document.getElementById("searchInput");
        const searchButton = document.getElementById("srchbtn");

        if (searchInput.style.display === "none" || searchInput.style.display === "") {
            searchInput.style.display = "inline-block"; // Show the input
            searchInput.focus(); // Automatically focus the input field
        } else {
            searchInput.style.display = "none"; // Hide the input
        }
    }
</script> -->
<script>
    // Toggle visibility of the search input field
    function toggleSearch() {
        const searchInput = document.getElementById("searchInput");
        const searchButton = document.getElementById("srchbtn");

        if (searchInput.style.display === "block") {
           return; // Automatically focus the input field
        } else {
            searchInput.style.display = "block"; // Hide the input
            searchInput.focus();
        }
        function hid(){
            var searchInput = document.getElementById('searchInput');
            searchInput.style.display = 'none';
        }
    }
</script>
</body>

</html>
