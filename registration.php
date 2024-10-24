<?php
require('./Database.php');

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Use prepared statements for security
    $queryCreate = "INSERT INTO tbreg1 (username, email, password) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($connection, $queryCreate);
    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $password);
    
    if (mysqli_stmt_execute($stmt)) {
        echo '<script>alert("Successfully Registered")</script>';
        echo '<script>window.location.href = "login.php"</script>'; // Redirect to login after registration
    } else {
        echo '<script>alert("Error: ' . mysqli_error($connection) . '")</script>';
    }
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        body {
            background-color: #1a1a1a; /* Dark background for a sleek look */
            color: #e0e0e0; /* Light gray text for better contrast */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            height: 100vh;
            margin: 0;
        }

        /* Navigation Bar */
        .navbar {
            background-color: #333; /* Dark gray for navbar */
            width: 220px; /* Width of the sidebar */
            height: 100%; /* Full height of the viewport */
            padding: 15px 0; /* Padding for top and bottom */
            position: fixed; /* Fixed positioning */
            display: flex;
            flex-direction: column; /* Stack links vertically */
        }

        .navbar a {
            color: #e0e0e0;
            text-decoration: none;
            padding: 12px 20px;
            font-weight: 500;
            text-transform: uppercase;
            transition: background 0.3s ease;
            display: block; /* Block-level for full width */
        }

        .navbar a:hover {
            background-color: #444; /* Lighter gray on hover */
            border-radius: 5px;
        }

        .container {
            margin-left: 240px; /* Margin to avoid overlap with navbar */
            max-width: 500px; /* Adjusted width */
            margin: 100px auto; /* Center the container */
            padding: 20px;
            background-color: #444; /* Darker gray for the form */
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(255, 255, 255, 0.1); /* Light shadow */
            flex-grow: 1; /* Take remaining space */
        }

        h1, h2 {
            color: white; /* White text for headers */
            text-align: center;
            font-weight: bold;
        }

        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #e0e0e0; /* Light gray border for inputs */
            border-radius: 5px;
            background-color: #555; /* Dark gray for input fields */
            color: white; /* White text */
        }

        input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus {
            border-color: white; /* White border on focus */
            outline: none;
            background-color: #666; /* Slightly lighter on focus */
        }

        .registerbtn {
            background-color: royalblue; /* Blue for create button */
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
        }

        .registerbtn:hover {
            background-color: darkblue; /* Darker blue on hover */
        }

        .signin {
            text-align: center;
            margin-top: 15px;
        }

        .signin a {
            color: royalblue; /* Blue for sign-in link */
            text-decoration: none;
        }
    </style>
</head>
<body>

<!-- Navigation Bar -->
<div class="navbar">
    <a href="index.php">Home</a>
    <a href="sms.php">SMS</a>
    <a href="Email.php">Email</a>
    <a href="registration.php">Register</a>
    <a href="Welcome.php">Welcome</a>
</div>

<div class="container">
    <h1>Register</h1>
    <form action="registration.php" method="post">  
        <h2>Create an Account</h2>
        <input type="text" name="username" placeholder="Enter your username" required />
        <input type="email" name="email" placeholder="Enter your email" required />
        <input type="password" name="password" placeholder="Enter your password" required />
        <input type="submit" name="register" value="REGISTER" class="registerbtn">
    </form>
    <div class="signin">
        <p>Already have an account? <a href="login.php">Log in</a>.</p>
    </div>
</div>

</body>
</html>
