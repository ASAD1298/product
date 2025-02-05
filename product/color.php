<?php
// Include database connection
include('../db.php');
?>
<form action="color.php" method="POST">
    <div class="options">
        <div class="color-options">
            <h3>Add Color:</h3>
        <label>
            <input type="text" name="color">                        
        </label>
        </div>
    </div>            
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

?>

<?php
$result = mysqli_query($conn, "SELECT * FROM colors");
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['color_name']}</td>
            <td>
                <a href='update.php?id={$row['id']}'>Update</a> |
                <a href='delete.php?id={$row['id']}'>Delete</a><br>
            </td>
            </tr>";
}
?>