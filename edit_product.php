<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

include 'db.php';

$product_id = $_GET['product_id'];

// Fetch product details
$stmt = $pdo->prepare("SELECT * FROM products WHERE product_id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch();

// Fetch categories
$categoriesStmt = $pdo->query("SELECT category_id, name FROM categories");
$categories = $categoriesStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch all product images
$imagesStmt = $pdo->prepare("SELECT image_id, image_url FROM product_images WHERE product_id = ?");
$imagesStmt->execute([$product_id]);
$images = $imagesStmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize form data
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $stock = $_POST['stock'];
    $category_id = $_POST['category_id'];
    $size = isset($_POST['size']) ? implode(',', $_POST['size']) : '';
    $color = $_POST['color'];

    // Update product details
    $stmt = $pdo->prepare("UPDATE products SET name = ?, price = ?, description = ?, stock = ?, category_id = ?, size = ?, color = ? WHERE product_id = ?");
    $stmt->execute([$name, $price, $description, $stock, $category_id, $size, $color, $product_id]);

    // Handle new image uploads
    foreach ($_FILES['images']['name'] as $index => $imageName) {
        if ($imageName) {
            $target = "pro-img/" . basename($imageName);
            $imageTmpName = $_FILES['images']['tmp_name'][$index];
            if (move_uploaded_file($imageTmpName, $target)) {
                $imageStmt = $pdo->prepare("INSERT INTO product_images (product_id, image_url) VALUES (?, ?)");
                $imageStmt->execute([$product_id, $target]);
            }
        }
    }

    echo "Product updated successfully!";
    header("Location: manage_products.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <style>
        body{
            align-items: center;
        }
        /* .container {
            max-width: 800px;
            margin: 50px auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
        } */

        h1 {
            text-align: center;
            color: #333333;
        }

        form {
            align-items: center;
            display: flex;
            flex-direction: column;
            gap: 15px;
            padding: 20px;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            color: #555555;
        }

        input, select, textarea {
            width: 70%;
            padding: 10px;
            font-size: 14px;
            text-align: center;
            align-items: center;
            border: 1px solid #dddddd;
            border-radius: 4px;
            background: #f9f9f9;
        }

        input[type="checkbox"] {
            width: auto;
            display: flex;
            margin: 0px 8px;
        }

        button {
            padding: 12px 20px;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .sizes{
            display: flex;
        }
        .images-container {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        .images-container div {
            text-align: center;
        }

        .images-container img {
            max-width: 150px;
            height: auto;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .images-container a {
            display: inline-block;
            margin-top: 5px;
            text-decoration: none;
            color: #ff4d4d;
            font-size: 14px;
        }

        .images-container a:hover {
            text-decoration: underline;
        }

        .form-section {
            margin-bottom: 20px;
        }

        @media (max-width: 600px) {
            .container {
                padding: 15px;
            }

            button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>
<br><br><br><br>

<h1>Edit Product</h1>
<form method="POST" enctype="multipart/form-data">
    <label for="name">Product Name:</label>
    <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>

    <label for="price">Price:</label>
    <input type="number" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>

    <label for="description">Description:</label>
    <textarea name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>

    <label for="stock">Stock:</label>
    <input type="number" name="stock" value="<?php echo htmlspecialchars($product['stock']); ?>" required>

    <label for="category_id">Category:</label>
    <select name="category_id" required>
        <?php foreach ($categories as $category): ?>
            <option value="<?php echo $category['category_id']; ?>" <?php echo $product['category_id'] == $category['category_id'] ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($category['name']); ?>
            </option>
        <?php endforeach; ?>
    </select>
            
    <label for="size">Size:</label>
    <div class="sizes">
    <?php
    $selected_sizes = explode(',', $product['size']);
    $available_sizes = ["8", "9", "10", "11", "12"];
    foreach ($available_sizes as $size_option) {
        $checked = in_array($size_option, $selected_sizes) ? 'checked' : '';
        echo "<input type='checkbox' name='size[]' value='$size_option' $checked> $size_option ";
    }
    ?>
    </div>
    

    <label for="color">Color:</label>
    <input type="text" name="color" value="<?php echo htmlspecialchars($product['color']); ?>" required>

    <label for="images">Upload New Images:</label>
    <input type="file" name="images[]" multiple>

    <h3>Existing Images:</h3>
    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
        <?php foreach ($images as $image): ?>
            <div>
                <img src="<?php echo htmlspecialchars($image['image_url']); ?>" alt="Product Image" style="width: 100px; height: auto;">
                <p>
                    <a href="delete_image.php?image_id=<?php echo $image['image_id']; ?>&product_id=<?php echo $product_id; ?>">Delete</a>
                </p>
            </div>
        <?php endforeach; ?>
    </div>
    <br><br>

    <button type="submit">Update Product</button>
</form>
</body>
</html>
