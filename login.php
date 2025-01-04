<?php
// Connection to the database
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // User data from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert query
    $sql = "INSERT INTO login (username, password) VALUES ('$username', '$hashed_password')";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        // Success: show popup and redirect
        echo "<script>
                alert('Your login was successful!');
                window.location.href = 'index.html'; // Redirect to homepage
              </script>";
    } else {
        // Error: show an alert with the error message
        echo "<script>
                alert('Error: " . $conn->error . "');
              </script>";
    }

    // Close the connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Odhani Store - Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: url('bg1.png') no-repeat center center fixed;
            background-size: cover;
            color: #333;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(90deg, #1ebacc, #3b5998);
            padding: 15px 30px;
            color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            height: 60px;
            margin-right: 10px;
            border-radius: 50%;
        }

        .logo h1 {
            font-size: 1.5rem;
            margin: 0;
        }

        .back-button {
            position: absolute;
            top: 50%;
            right: 30px;
            transform: translateY(-50%);
            background-color: #ffcc00;
            color: #4e73df;
            text-decoration: none;
            font-weight: bold;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        .back-button:hover {
            background-color: #ffd54f;
            color: #3a5bbd;
        }

        .login-container {
            max-width: 350px;
            margin: 50px auto;
            padding: 20px;
            background: rgba(245, 245, 220, 0.8);
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #4e73df;
        }

        .login-container form {
            display: flex;
            flex-direction: column;
        }

        .login-container label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        .login-container input {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .login-container button {
            padding: 10px;
            background-color: #4e73df;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.3s, transform 0.3s;
        }

        .login-container button:hover {
            background-color: #3a5bbd;
            transform: scale(1.05);
        }

        .register-link {
            text-align: center;
            margin-top: 15px;
        }

        .register-link a {
            color: #4e73df;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }

        .register-link a:hover {
            color: #3a5bbd;
        }

        footer {
            background: linear-gradient(90deg, #1ebacc, #3b5998);
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        footer p {
            margin: 5px 0;
        }

        footer a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            transition: color 0.3s;
        }

        footer a:hover {
            color: #ffcc00;
        }

        .footer-icons {
            margin-top: 10px;
        }

        .footer-icons a {
            font-size: 20px;
            margin: 0 15px;
            color: white;
            transition: color 0.3s;
        }

        .footer-icons a:hover {
            color: #ffcc00;
        }
    </style>
</head>

<body>

    <header>
        <div class="logo">
            <img src="logo1.png" alt="Odhani Store Logo">
            <h1>Odhani Store</h1>
        </div>
        <a href="index.html" class="back-button">Back</a>
    </header>

    <div class="login-container">
        <h2>LOGIN</h2>
        <form action="" method="POST">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
        <div class="register-link">
            <p>Haven't registered? <a href="register.php">Register here</a></p>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Odhani.in. All Rights Reserved.</p>
        <p>Address: Chhatrapati Sambhajinagar | <a href="mailto:info@odhanistore.com">info@odhani.in.com</a></p>
        <div class="social-icons">
            <a href="https://www.facebook.com/odhani.store" target="_blank" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
            <a href="https://www.instagram.com/odhaniii/" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
            <a href="https://twitter.com/odhani_store" target="_blank" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
        </div>
    </footer>

</body>

</html>
