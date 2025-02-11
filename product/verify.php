<?php
session_start();

// Check if verification code and email are set
if (!isset($_SESSION['verification_code'], $_SESSION['email'])) {
    header('Location: signup.php'); // Redirect if no session exists
    exit();
}

// Initialize variables
$errors = [];
$success = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entered_code = trim($_POST['verification_code']);
    $correct_code = $_SESSION['verification_code'];
    $email = $_SESSION['email'];

    if ($entered_code == $correct_code) {
        // Connect to database
        $host = 'localhost';
        $dbname = 'product_db';
        $username = 'root';
        $password = '';

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Update user verification status (add a 'verified' column in users table if needed)
            $stmt = $pdo->prepare("UPDATE users SET role = 'customer' WHERE email = ?");
            $stmt->execute([$email]);

            $success = "Your account has been successfully verified!";

            // Clear session data
            unset($_SESSION['verification_code']);
            unset($_SESSION['email']);

        } catch (PDOException $e) {
            $errors[] = "Database connection failed: " . $e->getMessage();
        }
    } else {
        $errors[] = "Invalid verification code. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Account</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Verify Your Account</h2>

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
            <div class="text-center mt-4">
                <a href="login.php" class="text-blue-500 hover:underline">Login Now</a>
            </div>
        <?php else: ?>
            <form action="" method="POST">
                <div class="mb-4">
                    <label class="block text-gray-700">Enter Verification Code</label>
                    <input type="text" name="verification_code" class="w-full p-2 border rounded" required>
                </div>

                <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">Verify</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
