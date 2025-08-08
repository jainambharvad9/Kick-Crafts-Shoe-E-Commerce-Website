<link rel="stylesheet" href="style.css">
<link rel="icon" href="/favicon.ico">
<nav class="navbar">
    <a href="index.php"><img src="imges/logo2.png" alt="Logo"></a>
    <ul>
        <?php if (isset($_SESSION['admin_id'])): ?>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="manage_products.php">Products</a></li>
            <li><a href="manage_users.php">Users</a></li>
            <li><a href="manage_orders.php">Orders</a></li>
            <li><a href="admin_logout.php">Logout</a></li>
        <?php elseif (isset($_SESSION['user_id'])): ?>
            <li><a href="index.php">Home</a></li>
            <li><a href="aboutus.php">About</a></li>
            <li><a href="product.php">Product</a></li>
            <li><a href="terms.php">T&C</a></li>
            <li><a href="cart.php">Cart</a></li>
            <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
            <li><a href="index.php">Home</a></li>
            <li><a href="aboutus.php">About</a></li>
            <li><a href="product.php">Product</a></li>
            <li><a href="terms.php">T&C</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
        <?php endif; ?>
    </ul>
</nav>