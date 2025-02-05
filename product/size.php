<?php
// Include database connection
include('../db.php');
?>
<form action="size.php" method="POST">
    <div class="options">
        <div class="size-options">
            <h3>Add size:</h3>
        <label>
            <input type="text" name="size">                        
        </label>
        </div>
    </div>            
    <button type="submit" class="button">Add size</button>
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

?>
<?php
$result = mysqli_query($conn, "SELECT * FROM sizes");
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['size_name']}</td>
            <td>
                <a href='update.php?id={$row['id']}'>Update</a> |
                <a href='delete.php?id={$row['id']}'>Delete</a><br>
            </td>
            </tr>";
}
?>