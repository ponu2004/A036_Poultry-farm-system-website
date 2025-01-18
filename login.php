<?php
session_start(); 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "register";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['SignIn'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        echo "<script>alert('Both fields are required.');</script>";
    } else {
        $sql = "SELECT * FROM form WHERE username='$username' AND password='$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $_SESSION['username'] = $username;  
            header("Location: home.php"); 
            exit;
        } else {
            echo "<script>alert('Invalid username or password.');</script>";
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"> <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="style1.css"> 
</head>
<body>
    <form method="POST" autocomplete="off">
        <h1>Login</h1>
        <div class="form-container">
            <div>
                <input type="text" name="username" id="username" placeholder="Username" value=""/><br><br>
            </div>
            <div>
                <input type="password" name="password" id="password" placeholder="Password" value=""/><br><br>
            </div>
            <p>
            <form action="home.php" method="get">
            <input type="submit" name="SignIn" id="SignIn" value="Sign In">
            </form>
                <p>Not a member? <a href="register.php">SignUp</a></p><br>
                <p><a href="forgotpass.php">Forgot password?</a></p>
            </p>
        </div>
    </form>
</body>
</html>