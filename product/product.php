<?php
// Include database connection
include('../db.php');
?>
<form action="product.php" method="POST">
    <div class="options">
        <div class="product-options">
            <h3>Add product:</h3>
        <label>
            <input type="text" name="product"><br>
            <input type="text" name="description"><br>
            <input type="text" name="price"><br><br>
            <?php
            // Fetch color options for the product
            $color_query = "SELECT * FROM colors";
            $color_result = mysqli_query($conn, $color_query);
            echo "Select Color".'<br><br>';
            while ($row = mysqli_fetch_assoc($color_result)) {
                echo "<tr>
                        <td><input type='checkbox' name='color[]' value='{$row['color_name']}'> {$row['color_name']}<br></td>
                      </tr>";
            }
            echo '<br>';
            
            // Fetch size options for the product
            $size_query = "SELECT * FROM sizes";
            $size_result = mysqli_query($conn, $size_query);
            echo "Select Size".'<br><br>';
            while ($row = mysqli_fetch_assoc($size_result)) {
                echo "<tr>
                        <td><input type='checkbox' name='size[]' value='{$row['size_name']}'> {$row['size_name']}<br></td>
                      </tr>";
            }
            echo '<br><br>';
            ?>
        </label>
        </div>
    </div>            
    <button type="submit" class="button">Add product</button>
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
?>
<?php
$result = mysqli_query($conn, "SELECT * FROM products");
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['name']}</td>
            <td>{$row['description']}</td>
            <td>{$row['price']}</td>
            <td>
                <a href='update.php?id={$row['id']}'>Update</a> |
                <a href='delete.php?id={$row['id']}'>Delete</a><br>
            </td>
            </tr>";
}
?>