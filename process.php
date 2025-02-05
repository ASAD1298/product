<?php
// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $colors = isset($_POST['color']) ? implode(", ", $_POST['color']) : "No color selected";
    $sizes = isset($_POST['size']) ? implode(", ", $_POST['size']) : "No size selected";
    echo "<h1>Order Summary</h1>";
    echo "<p>Selected Colors: $colors</p>";
    echo "<p>Selected Sizes: $sizes</p>";
} else {
    echo "<p>No data submitted.</p>";
}
?>
