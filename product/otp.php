<?php
session_start();

// Function to send OTP email
function sendOtpEmail($email, $otp) {
    $apiKey = "a3c819e478a873096d3d14e509352aee"; // Your Email Trap API key
    $subject = "Your OTP Code";
    $message = "Your OTP code is: $otp\nThis OTP is valid for 30 seconds.";

    // Email Trap API URL
    $url = 'https://api.emailtrap.io/send';
    
    // Prepare the email payload
    $data = [
        'to' => $email,
        'subject' => $subject,
        'message' => $message,
        'apiKey' => $apiKey,
    ];

    // Use cURL to send the email
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'], $_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Generate OTP (6-digit number)
    $otp = rand(100000, 999999);

    // Store OTP and expiration time in session
    $_SESSION['otp'] = $otp;
    $_SESSION['otp_expiry'] = time() + 30; // OTP valid for 30 seconds

    // Send OTP to the user's email
    $response = sendOtpEmail($email, $otp);

    // Display response for debugging
    echo $response;
}

// Check if OTP is being validated
if (isset($_POST['otp'])) {
    $enteredOtp = $_POST['otp'];

    // Check if OTP exists and is not expired
    if (isset($_SESSION['otp']) && isset($_SESSION['otp_expiry']) && time() < $_SESSION['otp_expiry']) {
        if ($_SESSION['otp'] == $enteredOtp) {
            echo "OTP verified successfully!";
            // Clear OTP from session after verification
            unset($_SESSION['otp']);
            unset($_SESSION['otp_expiry']);
        } else {
            echo "Invalid OTP.";
        }
    } else {
        echo "OTP expired or not generated.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
</head>
<body>

    <h2>Enter Your Email and Password</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="Enter your email" required><br>
        <input type="password" name="password" placeholder="Enter your password" required><br>
        <button type="submit">Send OTP</button>
    </form>

    <h2>Verify OTP</h2>
    <form method="POST">
        <input type="text" name="otp" placeholder="Enter OTP" required><br>
        <button type="submit">Verify OTP</button>
    </form>

</body>
</html>


