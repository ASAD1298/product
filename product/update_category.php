<?php
// Include database connection
include('../db.php');

// Check if an ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the category details for the given ID
    $result = mysqli_query($conn, "SELECT * FROM categories WHERE id = $id");
    $category = mysqli_fetch_assoc($result);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Update category name
        $category_name = $_POST['category_name'];
        $sql = "UPDATE categories SET category_name = '$category_name' WHERE id = $id";
        if (mysqli_query($conn, $sql)) {
            echo "Category updated successfully!";
            header("Location: category.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
} else {
    echo "No category ID provided!";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Category</title>
</head>
<body>

<form action="update_category.php?id=<?php echo $id; ?>" method="POST">
    <label>
        Category Name:
        <input type="text" name="category_name" value="<?php echo $category['category_name']; ?>" required><br><br>
    </label>
    <button type="submit" class="button">Update Category</button>
</form>

</body>
</html>
