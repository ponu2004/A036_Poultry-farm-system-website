<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "register";

// Establish the connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Check if email is not empty
    if (!empty($email)) {
        // Use mysqli_real_escape_string to prevent SQL injection
        $email = mysqli_real_escape_string($conn, $email);

        // Check if the email exists in the database
        $query = "SELECT * FROM form WHERE LOWER(email) = LOWER('$email')";  // Case-insensitive comparison
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            // Generate the reset link
            $reset_link = "http://yourdomain.com/reset_password.php?email=$email";

            // Send the reset link via email
            $subject = "Reset Your Password";
            $message = "Click the following link to reset your password: $reset_link";
            $headers = "From: noreply@yourdomain.com";

            if (mail($email, $subject, $message, $headers)) {
                echo "<script>alert('Password reset link sent to your email.');</script>";
            } else {
                echo "<script>alert('Failed to send email.');</script>";
            }
        } else {
            echo "<script>alert('Email not found.');</script>";
        }
    } else {
        echo "<script>alert('Please enter your email.');</script>";
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
</head>
<body>
    <form method="POST">
        <h1>Forgot Password</h1>
        <input type="email" name="email" placeholder="Enter your email" required>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
