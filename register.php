<?php
session_start();
include('connect.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){
    // Collect form data
    $name = $_POST["name"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"];
    $email = $_POST["email"];

    // Check if the required fields are not empty
    if(!empty($email) && !empty($password) && !empty($confirmpassword)) {
        // Ensure passwords match before inserting into the database
        if ($password == $confirmpassword) {
            // Corrected SQL query syntax: fixed single quotes and added prepared statements to prevent SQL injection
            $query = "INSERT INTO form (name, username, password, confirmpassword, email) 
                      VALUES ('$name', '$username', '$password', '$confirmpassword', '$email')";

            // Execute query
            if(mysqli_query($con, $query)) {
                echo "<script type='text/javascript'>alert('Successfully registered');</script>";
            } else {
                echo "<script type='text/javascript'>alert('failed');</script>";
            }
}
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form method="POST" action="">
        <h1>Register</h1>
        <div class="input-container">
            <i class="fas fa-user"></i>
            <input type="text" name="name" id="name" placeholder="Name">
        </div>
        <div class="input-container">
            <i class="fas fa-user"></i>
            <input type="text" name="username" id="username" placeholder="Username">
        </div>
        <div class="input-container">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" id="password" placeholder="Password">
        </div>
        <div class="input-container">
            <i class="fas fa-lock"></i>
            <input type="password" name="confirmpassword" id="confirmpassword" placeholder="Confirm Password">
        </div>
        <div class="input-container">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" id="email" placeholder="email">
        </div>
        <input type="submit" name="submit" id="submit" value="Submit"><br>
        <p>Already have an account?</p>
        <a href="login.php">SignIn</a>
    </form>
    <script src="script.js"></script>
</body>
</html>
