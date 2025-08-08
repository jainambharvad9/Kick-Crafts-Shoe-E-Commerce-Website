<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user_id'])) {
    // Redirect logged-in users to the home page (or dashboard)
    header("Location: login.php");
    exit();
}
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}


// Handle Add-to-Cart
// Handle Add-to-Cart
if (isset($_POST['add_to_cart'])) {
    $productId = $_POST['product_id'];
    $productName = $_POST['product_name'];
    $productPrice = $_POST['product_price'];
    $productColor = $_POST['product_color'];
    $productSize = $_POST['product_size'];
    $productQuantity = $_POST['product_quantity'];

    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $productId && $item['color'] == $productColor && $item['size'] == $productSize) {
            $item['quantity'] += $productQuantity;
            $found = true;
            break;
        }
    }
    unset($item);

    if (!$found) {
        $_SESSION['cart'][] = [
            "id" => $productId,
            "name" => $productName,
            "price" => $productPrice,
            "color" => $productColor,
            "size" => $productSize,
            "quantity" => $productQuantity
        ];
    }

    header("Location: cart.php");
    exit;
}

// Sync the session cart with the shopping_cart table for the current user
$user_id = $_SESSION['user_id'];

// Clear existing entries for this user in the shopping_cart table
$clearCartStmt = $pdo->prepare("DELETE FROM shopping_cart WHERE user_id = ?");
$clearCartStmt->execute([$user_id]);

// Insert current session cart items into the shopping_cart table
$insertCartStmt = $pdo->prepare("
    INSERT INTO shopping_cart (cart_id, user_id, product_id, quantity, size, color)
    VALUES (NULL, ?, ?, ?, ?, ?)
");

foreach ($_SESSION['cart'] as $item) {
    $insertCartStmt->execute([
        $user_id,
        $item['id'],       // product_id
        $item['quantity'],
        $item['size'],
        $item['color']
    ]);
}


// Update Quantity via AJAX
if (isset($_POST['update_quantity'])) {
    $index = $_POST['index'];
    $newQuantity = $_POST['quantity'];

    if (isset($_SESSION['cart'][$index]) && $newQuantity > 0) {
        // Update quantity in session
        $_SESSION['cart'][$index]['quantity'] = $newQuantity;

        // Update quantity in database
        $updateStmt = $pdo->prepare("UPDATE shopping_cart SET quantity = ? WHERE user_id = ? AND product_id = ? AND size = ? AND color = ?");
        $updateStmt->execute([
            $newQuantity,
            $user_id,
            $_SESSION['cart'][$index]['id'],
            $_SESSION['cart'][$index]['size'],
            $_SESSION['cart'][$index]['color']
        ]);
    }

    // Return updated subtotal and total
    $subtotal = $_SESSION['cart'][$index]['price'] * $_SESSION['cart'][$index]['quantity'];
    $total = array_sum(array_map(function ($item) {
        return $item['price'] * $item['quantity'];
    }, $_SESSION['cart']));

    echo json_encode(['subtotal' => $subtotal, 'total' => $total]);
    exit;
}

// Remove Item via AJAX
if (isset($_POST['remove_item'])) {
    $index = $_POST['index'];

    if (isset($_SESSION['cart'][$index])) {
        $removedItem = $_SESSION['cart'][$index];

        // Remove from session
        unset($_SESSION['cart'][$index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']); // Re-index array

        // Remove from database
        $deleteStmt = $pdo->prepare("DELETE FROM shopping_cart WHERE user_id = ? AND product_id = ? AND size = ? AND color = ?");
        $deleteStmt->execute([
            $user_id,
            $removedItem['id'],
            $removedItem['size'],
            $removedItem['color']
        ]);
    }

    // Calculate updated total after removal
    $total = array_sum(array_map(function ($item) {
        return $item['price'] * $item['quantity'];
    }, $_SESSION['cart']));

    echo json_encode(['total' => $total, 'cart_empty' => empty($_SESSION['cart'])]);
    exit;
}
// Calculate initial total amount
$total_amount = array_sum(array_map(function ($item) {
    return $item['price'] * $item['quantity'];
}, $_SESSION['cart']));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart - Sneaker Store</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <?php
    include 'header.php';
    ?><br><br><br><br><br>
<h2><center>My Shopping Cart</center></h2>

<div id="cart-content">
        
        <?php if (empty($_SESSION['cart'])): ?>
            <p id="empty-message">Your cart is empty. <a href="index.php">Continue shopping</a>.</p>
        <?php else: ?>
            <table border="1" id="cart-table">
                <tr>
                    <th>Product</th>
                    <th>Color</th>
                    <th>Size</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Actions</th>
                </tr>
                <?php foreach ($_SESSION['cart'] as $index => $item): ?>
                    <tr id="item-<?php echo $index; ?>">
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td><?php echo htmlspecialchars($item['color']); ?></td>
                        <td><?php echo htmlspecialchars($item['size']); ?></td>
                        <td>₹<?php echo number_format($item['price'], 2); ?></td>
                        <td>
                            <input type="number" class="quantity" data-index="<?php echo $index; ?>" value="<?php echo $item['quantity']; ?>" min="1">
                        </td>
                        <td class="subtotal" id="subtotal-<?php echo $index; ?>">₹<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                        <td>
                            <button class="remove-item" data-index="<?php echo $index; ?>">Remove</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="5" align="right"><strong>Total:</strong></td>
                    <td colspan="2"><strong id="total">₹<?php echo number_format($total_amount, 2); ?></strong></td>
                </tr>
            </table>


            <a href="checkout.php">Proceed to Checkout</a>
        <?php endif; ?>
    </div>
    <?php
    include 'footer.php';
    ?>
    <script>
        $(document).ready(function() {
            // Update quantity
            $('.quantity').on('input', function() {
                const index = $(this).data('index');
                const quantity = $(this).val();

                $.post('cart.php', {
                    update_quantity: true,
                    index: index,
                    quantity: quantity
                }, function(response) {
                    const data = JSON.parse(response);
                    $('#subtotal-' + index).text('$' + data.subtotal.toFixed(2));
                    $('#total').text('$' + data.total.toFixed(2));
                });
            });

            // Remove item
            $('.remove-item').on('click', function() {
                const index = $(this).data('index');

                $.post('cart.php', {
                    remove_item: true,
                    index: index
                }, function(response) {
                    const data = JSON.parse(response);
                    $('#item-' + index).remove(); // Remove the row from the table
                    $('#total').text('$' + data.total.toFixed(2)); // Update the total amount

                    // If the cart is empty, show the empty message and hide the cart table
                    if (data.cart_empty) {
                        $('#cart-table').remove();
                        $('#cart-content').html('<p id="empty-message">Your cart is empty. <a href="index.php">Continue shopping</a>.</p>');
                    }
                });
            });
        });
    </script>
    
</body>

</html>