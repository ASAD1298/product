<?php
// Database connection
$host = 'localhost';
$dbname = 'product_db';
$username = 'root'; // Change if different
$password = ''; // Change if different

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Initialize variables
$errors = [];
$success = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $address = trim($_POST['address']);

    // Validation
    if (empty($full_name)) {
        $errors[] = "Full name is required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }

    if (empty($address)) {
        $errors[] = "Address is required.";
    }

    // Check if email already exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        $errors[] = "Email is already registered.";
    }

    // If no errors, proceed
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $verification_code = rand(100000, 999999); // 6-digit verification code

        // Insert user into database
        $stmt = $pdo->prepare("INSERT INTO users (email, password, full_name, address, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$email, $hashed_password, $full_name, $address, 'customer']);

        // Simulate sending verification code (in real apps, use email service)
        $success = "Signup successful! Your verification code is: $verification_code";

        // Save code in session for verification
        session_start();
        $_SESSION['verification_code'] = $verification_code;
        $_SESSION['email'] = $email;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Signup Form</h2>

        <?php if (!empty($errors)): ?>
            <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="mb-4">
                <label class="block text-gray-700">Full Name</label>
                <input type="text" name="full_name" class="w-full p-2 border rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Email</label>
                <input type="email" name="email" class="w-full p-2 border rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Password</label>
                <input type="password" name="password" class="w-full p-2 border rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Address</label>
                <textarea name="address" class="w-full p-2 border rounded" required></textarea>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">Sign Up</button>
        </form>

        <?php if ($success): ?>
            <div class="mt-4 text-center">
                <a href="verify.php" class="text-blue-500 hover:underline">Click here to verify your account</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
