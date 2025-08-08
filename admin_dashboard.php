<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

include 'db.php';

// Fetch data for the dashboard
$totalProducts = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$totalOrders = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$totalSales = $pdo->query("SELECT SUM(total_amount) FROM orders")->fetchColumn();
$totalCarts = $pdo->query("SELECT COUNT(*) FROM shopping_cart")->fetchColumn();

// Fetch detailed data for tables and charts
$products = $pdo->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
$orders = $pdo->query("SELECT * FROM orders")->fetchAll(PDO::FETCH_ASSOC);
$carts = $pdo->query("SELECT * FROM shopping_cart")->fetchAll(PDO::FETCH_ASSOC);

// Pass data to JavaScript
$productData = json_encode($products);
$orderData = json_encode($orders);
$cartData = json_encode($carts);

// Fetch user growth data
$users = $pdo->query("
    SELECT first_name, last_name, DATE(created_at) as date, COUNT(*) as count 
    FROM users 
    GROUP BY DATE(created_at)
")->fetchAll(PDO::FETCH_ASSOC);

$userGrowthData = json_encode($users); // Pass this to JavaScript
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
    body {
        font-family: 'Open Sans', sans-serif;
        background-color: #f4f4f9;
        margin: 0;
        padding: 0;
    }

    .container {
        padding: 20px;
        max-width: 1200px;
        margin: auto;
    }

    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .dashboard-header h1 {
        margin: 0;
        font-size: 1.8rem;
        color: #333;
    }

    .dashboard-header .profile {
        display: flex;
        align-items: center;
    }

    .dashboard-header .profile img {
        border-radius: 50%;
        width: 40px;
        height: 40px;
        margin-right: 10px;
    }

    .dashboard-header .profile span {
        font-size: 1rem;
        color: #333;
    }

    .stats {
        display: flex;
        gap: 20px;
        margin-bottom: 30px;
    }

    .stats .card {
        flex: 1;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 20px;
        text-align: center;
    }

    .stats .card h3 {
        margin: 0;
        font-size: 2rem;
        color: #4e73df;
    }

    .stats .card p {
        margin: 5px 0 0;
        color: #6c757d;
    }

    .tabs {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .tabs .tab-header {
        display: flex;
        border-bottom: 1px solid #e0e0e0;
        
    }

    .tabs .tab-header button {
        flex: 1;
        padding: 10px;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 1rem;
        color: #333;
        outline: none;
        transition: 0.3s;
    }

    .tabs .tab-header button.active {
        font-weight: bold;
        color: #4e73df;
        border-bottom: 2px solid #4e73df;
    }


    .tabs .tab-content {
        padding: 20px;
        display: none;

    }

    .tabs .tab-content.active {
        display:grid;
    }
</style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<?php include 'header.php'; ?>
<br><br><br><br>
<div class="container">
        <div class="dashboard-header">
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        </div>

        <!-- Stats Cards -->
        <div class="stats">
            <div class="card">
                <h3><?php echo $totalProducts; ?></h3>
                <p>Total Products</p>
            </div>
            <div class="card">
                <h3><?php echo $totalOrders; ?></h3>
                <p>Total Orders</p>
            </div>
            <div class="card">
                <h3>₹<?php echo number_format($totalSales, 2); ?></h3>
                <p>Total Sales</p>
            </div>
            <div class="card">
                <h3><?php echo $totalCarts; ?></h3>
                <p>Active Carts</p>
            </div>
        </div>

<div class="tabs">
    <div class="tab-header">
        <button class="active" onclick="showTab(0)">Products</button>
        <button onclick="showTab(1)">Orders</button>
        <button onclick="showTab(2)">Users</button>
        <!-- <button onclick="showTab(3)">User</button> -->
    </div>
    <div class="tab-content active" id="products-tab">
        <h3>Products Overview</h3>
        <canvas id="productChart" style="width:100%;max-width:600px;"></canvas>
        <table border="2" style="text-align: center;" >
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Brand</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Category</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= $product['product_id'] ?></td>
                    <td><?= $product['name'] ?></td>
                    <td><?= $product['brand'] ?></td>
                    <td><?= $product['price'] ?></td>
                    <td><?= $product['stock'] ?></td>
                    <td><?= $product['category_id'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="tab-content" id="orders-tab">
        <h3>Orders Overview</h3>
        <canvas id="orderChart" style="width:100%;max-width:600px;"></canvas>
        <table border="2" style="text-align: center;">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User ID</th>
                    <th>Order Date</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= $order['order_id'] ?></td>
                    <td><?= $order['user_id'] ?></td>
                    <td><?= $order['order_date'] ?></td>
                    <td><?= $order['total_amount'] ?></td>
                    <td><?= $order['order_status'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- <div class="tab-content" id="carts-tab">
        <h3>Carts Overview</h3>
        <canvas id="cartChart" style="width:100%;max-width:600px;"></canvas>
        <table border="2" style="text-align: center;">
            <thead>
                <tr>
                    <th>Cart ID</th>
                    <th>User ID</th>
                    <th>Product ID</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($carts as $cart): ?>
                <tr>
                    <td><?= $cart['cart_id'] ?></td>
                    <td><?= $cart['user_id'] ?></td>
                    <td><?= $cart['product_id'] ?></td>
                    <td><?= $cart['quantity'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div> -->
    <div class="tab-content" id="users-tab">
    <h3>User Growth Overview</h3>
    <canvas id="userChart" style="width:100%;max-width:600px;"></canvas>
    <table border="2" style="text-align: center;">
        <thead>
            <tr>
                <th>Date</th>
                <th>New Users</th>
                <th>New Users Name</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['date'] ?></td>
                <td><?= $user['count'] ?></td>
                <td><?= $user['first_name']. ' ' . $user['last_name'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</div>

<script>
    // Parse PHP data
    const productData = <?= $productData ?>;
    const orderData = <?= $orderData ?>;
    const cartData = <?= $cartData ?>;

    // Chart for Products
    new Chart(document.getElementById('productChart'), {
        type: 'bar',
        data: {
            labels: productData.map(p => p.name),
            datasets: [{
                label: 'Stock',
                data: productData.map(p => p.stock),
                backgroundColor: 'rgba(75, 192, 192, 0.6)'
            }]
        }
    });

    // Chart for Orders
    new Chart(document.getElementById('orderChart'), {
        type: 'line',
        data: {
            labels: orderData.map(o => o.order_date),
            datasets: [{
                label: 'Total Amount',
                data: orderData.map(o => o.total_amount),
                backgroundColor: 'rgba(153, 102, 255, 0.6)'
            }]
        }
    });

    // Chart for Carts
    // new Chart(document.getElementById('cartChart'), {
    //     type: 'pie',
    //     data: {
    //         labels: cartData.map(c => `Cart ${c.cart_id}`),
    //         datasets: [{
    //             label: 'Quantities',
    //             data: cartData.map(c => c.quantity),
    //             backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56']
    //         }]
    //     }
    // });
    // Parse PHP data
const userGrowthData = <?= $userGrowthData ?>;

// Prepare data for the chart
const userDates = userGrowthData.map(u => u.date);
const userCounts = userGrowthData.map(u => u.count);

// User Growth Chart
new Chart(document.getElementById('userChart'), {
    type: 'line',
    data: {
        labels: userDates, // Dates of new users
        datasets: [{
            label: 'New Users Per Day',
            data: userCounts, // Counts of new users
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1,
            fill: true
        }]
    },
    options: {
        plugins: {
            title: {
                display: true,
                text: 'User Growth Over Time'
            }
        },
        responsive: true,
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'Date'
                }
            },
            y: {
                title: {
                    display: true,
                    text: 'New Users'
                },
                beginAtZero: true
            }
        }
    }
});


    // Tab switching logic
    function showTab(index) {
        const tabs = document.querySelectorAll('.tab-content');
        tabs.forEach((tab, i) => {
            tab.classList.toggle('active', i === index);
        });
        const buttons = document.querySelectorAll('.tab-header button');
        buttons.forEach((btn, i) => {
            btn.classList.toggle('active', i === index);
        });
    }
</script>
</body>
</html>
