<?php
// Database connection
$servername = "localhost";  // Your server name, change if necessary
$username = "root";         // Your MySQL username, default is 'root'
$password = "";             // Your MySQL password, default is an empty string
$dbname = "odhani";         // Your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $full_name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $message = $conn->real_escape_string($_POST['message']);

    // SQL query to insert data into the 'contact' table
    $sql = "INSERT INTO contact (full_name, email, message, created_at) 
            VALUES ('$full_name', '$email', '$message', NOW())";

    if ($conn->query($sql) === TRUE) {
        // Display the popup message upon successful submission
        echo "
        <script>
            alert('Message Sent Successfully');
            window.location.href = 'contact.html'; // Redirect to the contact page or a custom success page
        </script>";
    } else {
        // Display an error message if the query fails
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Odhni Store - Contact Us</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('bg1.png'); /* Set background image */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100%;
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

        nav {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        nav a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        nav a:hover {
            background: #ffcc00;
            color: #4e73df;
        }

        .container {
            max-width: 600px;  /* Decreased max width to make the container narrower */
            margin: 50px auto;
            padding: 20px;
            background-color: rgba(245, 245, 220, 0.7); /* Transparent beige */
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"], input[type="email"], textarea {
            width: 100%; /* Ensure it fits the container */
            padding: 8px; /* Reduced padding */
            font-size: 14px; /* Decreased font size */
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        textarea {
            resize: vertical; /* Allow vertical resize but not horizontal */
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .contact-info {
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }

        .contact-info h3 {
            color: #007bff;
        }

        .popup {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .popup-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }

        .close-btn {
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        footer {
            background: linear-gradient(90deg, #1ebacc, #3b5998);
            color: white;
            padding: 20px 0;
            margin-top: 20px;
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
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>

<header>
    <div class="logo">
        <img src="logo1.png" alt="Odhni Store Logo">
        <h1>Odhni Store</h1>
    </div>
    <nav>
        <a href="index.html">Home</a>
        <a href="login.php">Login</a>
        <a href="products.html">Products</a>
        <a href="about.html">About Us</a>
    </nav>
</header>

<div class="container">
    <h2>Contact Us</h2>
    <form action="message_sent.html" method="post">
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="message">Message</label>
            <textarea id="message" name="message" rows="5" required></textarea>
        </div>

        <input type="submit" value="Send Message">
    </form>

    <div class="contact-info">
        <h3>Our Contact Information</h3>
        <p><strong>Email:</strong> support@odhnistore.com</p>
        <p><strong>Phone:</strong> +91 123 456 7890</p>
        <p><strong>Address:</strong> Odhni Store, Chhatrapati Sambhajinagar</p>
    </div>
</div>

<div class="popup" id="popup">
    <div class="popup-content">
        <h3>Message Sent Successfully</h3>
        <p>Thank you for reaching out! We will get back to you shortly.</p>
        <button class="close-btn" onclick="window.location.href='index.html'">Close</button>
    </div>
</div>

<script>
    document.querySelector('form').onsubmit = function() {
        document.getElementById('popup').style.display = 'flex';
        return false;
    }
</script>

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
