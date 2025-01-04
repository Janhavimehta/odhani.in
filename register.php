<?php
$servername = "localhost"; // Your database server
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "odhani"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data to prevent SQL injection
    $fullName = $conn->real_escape_string($_POST['fullName']);
    $email = $conn->real_escape_string($_POST['email']);
    $mobile = $conn->real_escape_string($_POST['mobile']);
    $address = $conn->real_escape_string($_POST['address']);
    $pincode = $conn->real_escape_string($_POST['pincode']);
    $quantity = (int)$_POST['quantity'];
    $payment = $conn->real_escape_string($_POST['payment']);

    // Handle different payment methods
    $cardNumber = $payment == 'card' && isset($_POST['cardNumber']) ? $conn->real_escape_string($_POST['cardNumber']) : null;
    $expiry = $payment == 'card' && isset($_POST['expiry']) ? $conn->real_escape_string($_POST['expiry']) : null;
    $cvv = $payment == 'card' && isset($_POST['cvv']) ? $conn->real_escape_string($_POST['cvv']) : null;
    $upiId = $payment == 'upi' && isset($_POST['upiId']) ? $conn->real_escape_string($_POST['upiId']) : null;

    // Prepare the SQL query to insert data
    $sql = "INSERT INTO purchase (full_name, email, mobile, address, pincode, quantity, payment_method, card_number, expiry, cvv, upi_id)
            VALUES ('$fullName', '$email', '$mobile', '$address', '$pincode', $quantity, '$payment', 
                    ". ($cardNumber ? "'$cardNumber'" : "NULL") .", 
                    ". ($expiry ? "'$expiry'" : "NULL") .", 
                    ". ($cvv ? "'$cvv'" : "NULL") .", 
                    ". ($upiId ? "'$upiId'" : "NULL") .")";

    // Execute the query and check for success
    if ($conn->query($sql) === TRUE) {
        // Redirect to buy.html after successful order
        header("Location: buy.html");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
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
    <title>Odhani Store - Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('bg1.png') no-repeat center center fixed;
            background-size: cover;
            color: #333;
        }

        header {
            background: linear-gradient(90deg, #1ebacc, #3b5998);
            color: white;
            padding: 10px 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
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
            color: white;
            text-decoration: none;
            font-weight: bold;
            padding: 10px 15px;
            border-radius: 5px;
            background: #4e73df;
            transition: background-color 0.3s, color 0.3s;
        }

        .back-button:hover {
            background: #ffcc00;
            color: #4e73df;
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

        .social-icons {
            margin-top: 10px;
        }

        .social-icons a {
            color: white;
            font-size: 1.5rem;
            margin: 0 10px;
            transition: color 0.3s;
        }

        .social-icons a:hover {
            color: #ffcc00;
        }

        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #4e73df;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            background-color: #4e73df;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #3a5bbd;
        }

        .error {
            color: red;
            font-size: 14px;
            display: none;
        }
    </style>
    <script>
        function validateForm(event) {
            event.preventDefault(); // Prevent default form submission

            // Fields
            const name = document.getElementById("name");
            const email = document.getElementById("email");
            const mobile = document.getElementById("mobile");
            const password = document.getElementById("password");
            const confirmPassword = document.getElementById("confirm-password");

            // Error elements
            const nameError = document.getElementById("name-error");
            const emailError = document.getElementById("email-error");
            const mobileError = document.getElementById("mobile-error");
            const passwordError = document.getElementById("password-error");

            // Reset error messages
            nameError.style.display = "none";
            emailError.style.display = "none";
            mobileError.style.display = "none";
            passwordError.style.display = "none";

            let isValid = true;

            // Name validation
            if (!/^[A-Za-z\s]+$/.test(name.value)) {
                nameError.style.display = "block";
                isValid = false;
            }

            // Email validation
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
                emailError.style.display = "block";
                isValid = false;
            }

            // Mobile validation
            if (!/^\d{10}$/.test(mobile.value)) {
                mobileError.style.display = "block";
                isValid = false;
            }

            // Password match validation
            if (password.value !== confirmPassword.value) {
                passwordError.style.display = "block";
                isValid = false;
            }

            // If form is valid, show success popup and redirect
            if (isValid) {
                alert("You have registered with us successfully!");
                window.location.href = "index.html";
            }
        }
    </script>
</head>

<body>
    <header>
        <div class="logo">
            <img src="logo1.png" alt="Odhani Store Logo">
            <h1>Odhani.in</h1>
        </div>
        <a href="index.html" class="back-button">Back</a>
    </header>

    <div class="container">
        <h2>Register</h2>
        <form onsubmit="validateForm(event)">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" required>
                <div id="name-error" class="error">Name should only contain letters.</div>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
                <div id="email-error" class="error">Please enter a valid email address.</div>
            </div>
            <div class="form-group">
                <label for="mobile">Mobile Number</label>
                <input type="tel" id="mobile" name="mobile" required>
                <div id="mobile-error" class="error">Mobile number must be exactly 10 digits.</div>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" name="confirm-password" required>
                <div id="password-error" class="error">Passwords do not match.</div>
            </div>
            <input type="submit" value="Register">
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Odhani Store. All Rights Reserved.</p>
        <p>Address: Chhatrapati Sambhajinagar | <a href="mailto:info@odhanistore.com">info@odhanistore.com</a></p>
        <div class="social-icons">
            <a href="https://www.facebook.com/odhani.store" target="_blank" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
            <a href="https://www.instagram.com/odhaniii/" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
            <a href="https://twitter.com/odhani_store" target="_blank" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
        </div>
    </footer>
</body>

</html>

