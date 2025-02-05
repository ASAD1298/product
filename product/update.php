<?php
include('../db.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM colors WHERE id = $id");
    $color = mysqli_fetch_assoc($result);

    if (!$color) {
        die("Color not found.");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Color</title>
</head>
<body>
    <h1>Update Color</h1>
    <form action="update.php?id=<?php echo $color['id']; ?>" method="POST">
        <input type="text" name="color" value="<?php echo $color['color_name']; ?>" required><br>
        <input type="submit" value="Update">
    </form>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $color = $_POST['color'];
    
    $sql = "UPDATE colors SET color_name = '$color' WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        header("Location: color.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
