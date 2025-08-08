<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

include 'db.php';

// Fetch all products
$stmt = $pdo->query("
    SELECT 
    p.product_id,
    p.name,
    p.price,
    p.description,
    (
        SELECT image_url 
        FROM product_images pi 
        WHERE pi.product_id = p.product_id 
        ORDER BY pi.image_id ASC 
        LIMIT 1
    ) AS img_source
FROM 
    products p;

");
$products = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Products</title>
</head>
<style>
    body {
        text-align: center;
    }

    body a {
        text-decoration: none;
        list-style-type: none;
    }

    .product {
        width: 99%;
        /* Adjust for 3 columns with 20px gap */
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 16px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        background-color: #fff;
        margin: 10px;
    }

    a button {
        margin: 10px 10px;
        display: inline-block;
        outline: 0;
        border: 0;
        cursor: pointer;
        font-weight: 600;
        color: rgb(72, 76, 122);
        font-size: 14px;
        height: 38px;
        padding: 8px 24px;
        border-radius: 50px;
        background-image: linear-gradient(180deg, #fff, #f5f5fa);
        box-shadow: 0 4px 11px 0 rgb(37 44 97 / 15%),
            0 1px 3px 0 rgb(93 100 148 / 20%);
        transition: all 0.2s ease-out;
    }

    a button:hover {
        box-shadow: 0 8px 22px 0 rgb(37 44 97 / 15%),
            0 4px 6px 0 rgb(93 100 148 / 20%);
    }


    .product {
        display: flex;
    }

    .product img {
        height: 200px;
        width: 200px;
    }

    .con {
        margin: 10px 20px;
    }

    a button:hover {
        scale: 1.1;
        color: #fff;
        background-image: linear-gradient(180deg, #808080, #808080);
    }
</style>

<body>
    <?php include 'header.php'; ?>
    <br><br><br><br>

    <h1>Manage Products</h1>
    <a href="add_product.php"><button>Add New Product</button></a><br><br>

    <?php foreach ($products as $product): ?>
        <div style="text-align: justify;" class="product">
            <div class="p-img">
                <img src="<?php echo htmlspecialchars($product['img_source']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
            </div>
            <div class="con">
                <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                <p><strong>Price: </strong>₹ <?php echo htmlspecialchars($product['price']); ?></p>
                <p>
                <h4>Description:</h4> <?php echo htmlspecialchars($product['description']); ?></p>
                <a href="edit_product.php?product_id=<?php echo $product['product_id']; ?>"><button>Edit</button></a> |
                <a href="delete_product.php?product_id=<?php echo $product['product_id']; ?>"><button>Delete</button></a>
            </div>
        </div>
    <?php endforeach; ?>

    <?php include 'footer.php'; ?>

</body>

</html>