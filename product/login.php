<?php
session_start();

// Database connection settings
define('DB_HOST', 'localhost');   // Replace with your host if different
define('DB_NAME', 'product_db');  // Replace with your database name
define('DB_USER', 'root');        // Replace if your username is different
define('DB_PASS', '');            // Replace if your password is set

// Initialize error message
$error_message = '';

// Handle the form submission (POST request)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'], $_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Connect to the database
    try {
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if the email exists in the users table
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verify the entered password with the stored hashed password
            if (password_verify($password, $user['password'])) {
                // Start a session and store user details (login successful)
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                header("Location: dashboard.php"); // Redirect to a protected page
                exit();
            } else {
                $error_message = "Incorrect password. Please try again.";
            }
        } else {
            $error_message = "No user found with that email. Please check your email or sign up.";
        }
    } catch (PDOException $e) {
        error_log("Error in login process: " . $e->getMessage());
        $error_message = "There was an error connecting to the database. Please try again later.";
    }
}
?>
