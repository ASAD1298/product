<?php
include('../db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM colors WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        header("Location: color.php"); // Redirect after deletion
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
