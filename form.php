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
        echo "Order placed successfully!";
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
    <title>Product Purchase Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('bg1.png') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
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

        .form-container {
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 400px;
            margin: 50px auto;
        }

        .form-container h2 {
            margin-bottom: 20px;
            color: #232f3e;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-size: 14px;
            color: #555;
            margin-bottom: 5px;
        }

        input, select, textarea {
            width: 380px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        textarea {
            resize: none;
            height: 80px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #4e73df;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #3a5bbd;
        }

        .error {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }

        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="logo1.png" alt="Odhani Store Logo">
            <h1>Odhani.in</h1>
        </div>
    </header>

    <div class="form-container">
        <h2>Purchase Product</h2>
        <form id="purchaseForm" action="" method="POST">
            <div class="form-group">
                <label for="fullName">Full Name</label>
                <input type="text" id="fullName" name="fullName" placeholder="Enter your full name" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="mobile">Mobile Number</label>
                <input type="text" id="mobile" name="mobile" placeholder="Enter your mobile number" maxlength="10" required>
            </div>
            <div class="form-group">
                <label for="address">Delivery Address</label>
                <textarea id="address" name="address" placeholder="Enter your complete address" required></textarea>
            </div>
            <div class="form-group">
                <label for="pincode">Pincode</label>
                <input type="text" id="pincode" name="pincode" placeholder="Enter your area pincode" maxlength="6" required>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" id="quantity" name="quantity" placeholder="Enter quantity" required min="1">
            </div>
            <div class="form-group">
                <label for="payment">Payment Method</label>
                <select id="payment" name="payment" required>
                    <option value="" disabled selected>Select a payment method</option>
                    <option value="cod">Cash on Delivery</option>
                    <option value="card">Credit/Debit Card</option>
                    <option value="upi">UPI</option>
                </select>
            </div>

            <div id="cardDetails" class="hidden">
                <div class="form-group">
                    <label for="cardNumber">Card Number</label>
                    <input type="text" id="cardNumber" name="cardNumber" placeholder="Enter your card number" maxlength="16">
                </div>
                <div class="form-group">
                    <label for="expiry">Expiry Date</label>
                    <input type="text" id="expiry" name="expiry" placeholder="MM/YY">
                </div>
                <div class="form-group">
                    <label for="cvv">CVV</label>
                    <input type="text" id="cvv" name="cvv" placeholder="Enter CVV" maxlength="3">
                </div>
            </div>

            <div id="upiDetails" class="hidden">
                <div class="form-group">
                    <label for="upiId">UPI ID</label>
                    <input type="text" id="upiId" name="upiId" placeholder="Enter your UPI ID">
                </div>
            </div>

            <button type="submit">Place Order</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Odhani Store. All Rights Reserved.</p>
    </footer>

    <script>
        const paymentSelect = document.getElementById('payment');
        const cardDetails = document.getElementById('cardDetails');
        const upiDetails = document.getElementById('upiDetails');

        paymentSelect.addEventListener('change', function () {
            if (this.value === 'card') {
                cardDetails.classList.remove('hidden');
                upiDetails.classList.add('hidden');
            } else if (this.value === 'upi') {
                upiDetails.classList.remove('hidden');
                cardDetails.classList.add('hidden');
            } else {
                cardDetails.classList.add('hidden');
                upiDetails.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
