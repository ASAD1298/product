<?php
// Include database connection
include('db.php');

// Fetch product data
$product_query = "SELECT * FROM products WHERE id = 1"; // For product with id=1
$product_result = mysqli_query($conn, $product_query);
$product = mysqli_fetch_assoc($product_result);

// Fetch color options for the product
$color_query = "SELECT * FROM colors";
$color_result = mysqli_query($conn, $color_query);

// Fetch size options for the product
$size_query = "SELECT * FROM sizes";
$size_result = mysqli_query($conn, $size_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['name']; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="product-container">
        <h1><?php echo $product['name']; ?></h1>
        <p class="price">$<?php echo $product['price']; ?></p>
        <p class="description"><?php echo $product['description']; ?></p>
        
        <form action="process.php" method="POST">
            <div class="options">
                <div class="color-options">
                    <h3>Select Color:</h3>
                    <?php while ($color = mysqli_fetch_assoc($color_result)): ?>
                        <label>
                            <input type="checkbox" name="color[]" value="<?php echo $color['color_name']; ?>">
                            <?php echo $color['color_name']; ?>
                        </label>
                    <?php endwhile; ?>
                </div>

                <div class="size-options">
                    <h3>Select Size:</h3>
                    <?php while ($size = mysqli_fetch_assoc($size_result)): ?>
                        <label>
                            <input type="checkbox" name="size[]" value="<?php echo $size['size_name']; ?>">
                            <?php echo $size['size_name']; ?>
                        </label>
                    <?php endwhile; ?>
                </div>
            </div>
            
            <button type="submit" class="button">Add to Cart</button>
        </form>
    </div>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
