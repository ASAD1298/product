<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add to cart
if (isset($_POST['add_to_cart'])) {
    $product = [
        'id' => $_POST['id'],
        'name' => $_POST['name'],
        'price' => $_POST['price'],
        'quantity' => $_POST['quantity']
    ];
    $_SESSION['cart'][] = $product;
}

// Remove item
if (isset($_GET['remove'])) {
    $index = $_GET['remove'];
    unset($_SESSION['cart'][$index]);
    $_SESSION['cart'] = array_values($_SESSION['cart']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cart</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="container mx-auto">
        <h2 class="text-2xl font-bold mb-4">Shopping Cart</h2>
        <?php if (!empty($_SESSION['cart'])) { ?>
            <table class="w-full bg-white rounded shadow">
                <tr class="bg-gray-200">
                    <th class="p-2">Name</th>
                    <th class="p-2">Price</th>
                    <th class="p-2">Quantity</th>
                    <th class="p-2">Subtotal</th>
                    <th class="p-2">Action</th>
                </tr>
                <?php 
                $total = 0;
                foreach ($_SESSION['cart'] as $index => $item) { 
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                ?>
                <tr>
                    <td class="p-2"><?php echo $item['name']; ?></td>
                    <td class="p-2">$<?php echo $item['price']; ?></td>
                    <td class="p-2"><?php echo $item['quantity']; ?></td>
                    <td class="p-2">$<?php echo number_format($subtotal, 2); ?></td>
                    <td class="p-2"><a href="cart.php?remove=<?php echo $index; ?>" class="text-red-500">Remove</a></td>
                </tr>
                <?php } ?>
                <tr class="bg-gray-200">
                    <td colspan="3" class="p-2">Total</td>
                    <td class="p-2">$<?php echo number_format($total, 2); ?></td>
                </tr>
            </table>
            <a href="checkout.php" class="mt-4 block bg-green-500 text-whPte p-2 text-center rounded">Proceed to Checkout</a>
        <?php } else { ?>
            <p>Your cart is empty</p>
        <?php } ?>
    </div>
</body>
</html>
