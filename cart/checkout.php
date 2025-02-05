<?php
session_start();
$conn = new mysqli("localhost", "root", "", "order_db");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $total = 0;

    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    $stmt = $conn->prepare("INSERT INTO orders (name, email, address, total) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssd", $name, $email, $address, $total);
    $stmt->execute();
    $order_id = $stmt->insert_id;
    $stmt->close();

    $_SESSION['cart'] = [];

    echo "<p>Thank you for your order! Your order ID is #$order_id.</p>";
    echo "<a href='index.php' class='text-blue-500'>Go Back</a>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Checkout</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="container mx-auto">
        <h2 class="text-2xl font-bold mb-4">Checkout</h2>
        <form method="post">
            <input type="text" name="name" placeholder="Name" class="w-full p-2 border mb-2" required>
            <input type="email" name="email" placeholder="Email" class="w-full p-2 border mb-2" required>
            <input type="text" name="address" placeholder="Address" class="w-full p-2 border mb-2" required>
            <button type="submit" class="bg-blue-500 text-white p-2 rounded w-full">Place Order</button>
        </form>
    </div>
</body>
</html>
    