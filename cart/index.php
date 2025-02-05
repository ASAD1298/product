<?php
session_start();
$conn = new mysqli("localhost", "root", "", "cart_db");

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM products");

if (!$result) {
    die("Error fetching products: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Shopping Cart</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="container mx-auto">
        <h2 class="text-2xl font-bold mb-4">Products</h2>
        <div class="grid grid-cols-3 gap-4">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="bg-white p-4 rounded shadow">
                <img src="<?php echo !empty($row['']) ? $row[''] : 'shirt.jpg'; ?>" class="w-full h-40 object-cover rounded">

                    <p class="font-semibold mt-2"><?php echo $row['name']; ?></p>
                    <p class="text-green-500 font-bold">$<?php echo $row['price']; ?></p>
                    <form method="post" action="cart.php" class="mt-2">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="name" value="<?php echo $row['name']; ?>">
                        <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
                        <input type="number" name="quantity" value="1" min="1" class="border p-1 w-full">
                        <button type="submit" name="add_to_cart" class="bg-blue-500 text-white px-3 py-1 mt-2 rounded w-full">Add to Cart</button>
                    </form>
                </div>
            <?php } ?>
        </div>
        <a href="cart.php" class="block mt-4 text-blue-600">View Cart</a>
    </div>
</body>
</html>
