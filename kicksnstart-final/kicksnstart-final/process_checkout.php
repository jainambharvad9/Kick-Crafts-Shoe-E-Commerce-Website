<?php
session_start();
include 'db.php'; // Ensure this connects to your database properly

// Debugging log
file_put_contents('debug.log', "Starting process_checkout.php\n", FILE_APPEND);

// Verify POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
    exit();
}

// Get Razorpay response
$raw_input = file_get_contents("php://input");
file_put_contents('debug.log', "Received input: $raw_input\n", FILE_APPEND);

$input = json_decode($raw_input, true);
if (!$input || !isset($input['razorpay_payment_id'])) {
    file_put_contents('debug.log', "Invalid JSON input or missing payment ID\n", FILE_APPEND);
    echo json_encode(["success" => false, "message" => "Invalid payment response"]);
    exit();
}

// Razorpay Payment Details
$razorpay_payment_id = $input['razorpay_payment_id'];
$total_amount = $_SESSION['total_amount'] ?? null;

// Validate that cart and session exist
if (!isset($_SESSION['user_id']) || !isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    file_put_contents('debug.log', "Cart is empty or user not logged in\n", FILE_APPEND);
    echo json_encode(["success" => false, "message" => "Cart is empty or user not logged in"]);
    exit();
}

try {
    $pdo->beginTransaction();

    // Fetch user and cart info
    $user_id = $_SESSION['user_id'];
    $cart_items = $_SESSION['cart'];
    $shipping_address = $_POST['address'] ?? 'Default Address';
    $total_amount = array_sum(array_map(function ($item) {
        return $item['price'] * $item['quantity'];
    }, $cart_items));

    // Insert order into orders
    $order_stmt = $pdo->prepare(
        "INSERT INTO orders (user_id, order_date, total_amount, shipping_address, payment_status) 
        VALUES (?, NOW(), ?, ?, ?)"
    );
    $order_stmt->execute([$user_id, $total_amount, $shipping_address, 'Paid']);
    $order_id = $pdo->lastInsertId();

    // Insert order items into order_items
    foreach ($cart_items as $item) {
        $item_stmt = $pdo->prepare(
            "INSERT INTO order_items (order_id, product_id, quantity, unit_price, total_price) 
            VALUES (?, ?, ?, ?, ?)"
        );
        $item_stmt->execute([
            $order_id,
            $item['id'],
            $item['quantity'],
            $item['price'],
            $item['price'] * $item['quantity']
        ]);
    }

    $pdo->commit();

    // Clear cart session
    unset($_SESSION['cart']);

    // Log success
    file_put_contents('debug.log', "Order successfully placed. Order ID: $order_id\n", FILE_APPEND);

    // Respond success
    echo json_encode(["success" => true, "order_id" => $order_id]);
    exit();
} catch (Exception $e) {
    $pdo->rollBack();
    file_put_contents('debug.log', "Error processing order: " . $e->getMessage() . "\n", FILE_APPEND);
    echo json_encode(["success" => false, "message" => "Order processing failed"]);
    exit();
}
