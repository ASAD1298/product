<?php
// Include database connection
include('../db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Categories</title>
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
        <li><a href="category.php">Categories</a></li> <!-- Link to Categories -->
    </ul>
</div>

<!-- Main Content -->
<div class="main-content">
    <!-- Categories Section -->
    <div class="section">
        <h3>Add Category</h3>
        <form action="category.php" method="POST">
            <label>
                Category Name:
                <input type="text" name="category_name" required><br><br>
            </label>
            <button type="submit" class="button">Add Category</button>
        </form>

        <?php
        // Handle the form submission for adding a new category
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $category_name = $_POST['category_name'];

            // SQL to insert the category
            $sql = "INSERT INTO categories (category_name) VALUES ('$category_name')";
            if (mysqli_query($conn, $sql)) {
                echo "Category added successfully!";
                header("Location: category.php"); // Redirect to refresh the page
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }

        // Display the categories in a table
        $result = mysqli_query($conn, "SELECT * FROM categories");
        echo "<h3>Categories</h3><table><tr><th>ID</th><th>Category Name</th><th>Actions</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['category_name']}</td>
                    <td>
                        <a href='update_category.php?id={$row['id']}'>Update</a> |
                        <a href='delete_category.php?id={$row['id']}'>Delete</a>
                    </td>
                  </tr>";
        }
        echo "</table>";
        ?>
    </div>
</div>

</body>
</html>
