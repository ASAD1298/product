<?php
// Include database connection
include('../db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css"> <!-- Add your CSS file -->
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h2>Admin Dashboard</h2>
    <ul>
        <li><a href="product.php">Products</a></li>
        <li><a href="color.php">Colors</a></li>
        <li><a href="size.php">Sizes</a></li>
        <li><a href="category.php">Categories</a></li>
    </ul>
</div>

<!-- Main Content -->
<div class="main-content">
    <!-- Product Section -->
    <div class="section">
        <h3>Add Product</h3>
        <form action="product.php" method="POST">
            <label>
                Product Name:
                <input type="text" name="product" required><br><br>
                Description:
                <input type="text" name="description" required><br><br>
                Price:
                <input type="text" name="price" required><br><br>

                <!-- Color Options -->
                <?php
                $color_query = "SELECT * FROM colors";
                $color_result = mysqli_query($conn, $color_query);
                echo "Select Color:<br>";
                while ($row = mysqli_fetch_assoc($color_result)) {
                    echo "<input type='checkbox' name='color[]' value='{$row['color_name']}'> {$row['color_name']}<br>";
                }
                ?>

                <!-- Size Options -->
                <?php
                $size_query = "SELECT * FROM sizes";
                $size_result = mysqli_query($conn, $size_query);
                echo "Select Size:<br>";
                while ($row = mysqli_fetch_assoc($size_result)) {
                    echo "<input type='checkbox' name='size[]' value='{$row['size_name']}'> {$row['size_name']}<br>";
                }
                ?>
            </label><br><br>

            <button type="submit" class="button">Add Product</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product = $_POST['product'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $sql = "INSERT INTO products (name, description, price) VALUES ('$product', '$description', '$price')";
            if (mysqli_query($conn, $sql)) {
                header("Location: product.php"); 
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }

        // Display Products
        $result = mysqli_query($conn, "SELECT * FROM products");
        echo "<h3>Products</h3><table><tr><th>ID</th><th>Name</th><th>Description</th><th>Price</th><th>Actions</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['description']}</td>
                    <td>{$row['price']}</td>
                    <td><a href='update.php?id={$row['id']}'>Update</a> | <a href='delete.php?id={$row['id']}'>Delete</a></td>
                  </tr>";
        }
        echo "</table>";
        ?>
    </div>

    <!-- Color Section -->
    <div class="section">
        <h3>Add Color</h3>
        <form action="color.php" method="POST">
            <label>
                Color Name:
                <input type="text" name="color" required><br><br>
            </label>
            <button type="submit" class="button">Add Color</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $color = $_POST['color'];
            $sql = "INSERT INTO colors (color_name) VALUES ('$color')";
            if (mysqli_query($conn, $sql)) {
                header("Location: color.php"); 
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }

        // Display Colors
        $result = mysqli_query($conn, "SELECT * FROM colors");
        echo "<h3>Colors</h3><table><tr><th>ID</th><th>Color Name</th><th>Actions</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['color_name']}</td>
                    <td><a href='update.php?id={$row['id']}'>Update</a> | <a href='delete.php?id={$row['id']}'>Delete</a></td>
                  </tr>";
        }
        echo "</table>";
        ?>
    </div>

    <!-- Size Section -->
    <div class="section">
        <h3>Add Size</h3>
        <form action="size.php" method="POST">
            <label>
                Size Name:
                <input type="text" name="size" required><br><br>
            </label>
            <button type="submit" class="button">Add Size</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $size = $_POST['size'];
            $sql = "INSERT INTO sizes (size_name) VALUES ('$size')";
            if (mysqli_query($conn, $sql)) {
                header("Location: size.php"); 
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }

        // Display Sizes
        $result = mysqli_query($conn, "SELECT * FROM sizes");
        echo "<h3>Sizes</h3><table><tr><th>ID</th><th>Size Name</th><th>Actions</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['size_name']}</td>
                    <td><a href='update.php?id={$row['id']}'>Update</a> | <a href='delete.php?id={$row['id']}'>Delete</a></td>
                  </tr>";
        }
        echo "</table>";
        ?>
    </div>
</div>

</body>
</html>
