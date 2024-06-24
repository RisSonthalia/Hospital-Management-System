<?php
session_start();
include('include/config.php');
include('include/checklogin.php');
check_login();

if (isset($_GET['billid'])) {
    $billId = $_GET['billid'];

    // SQL to update the bill status

    $sql = mysqli_query($con, "SELECT * FROM bill WHERE bill_id = '$billId'");
    $row = mysqli_fetch_assoc($sql);
    $amnt = $row['amount_to_be_paid'];
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Gateway with OTP Verification</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .payment-form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .form-group,
        .otp-group {
            margin-bottom: 15px;
        }

        label,
        input,
        select,
        button {
            display: block;
            width: 100%;
            margin-top: 5px;
        }

        input,
        select,
        button {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #007bff;
            color: white;
            cursor: pointer;
            border: none;
            margin-top: 20px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .hide {
            display: none;
        }

        .processing,
        .success-message {
            text-align: center;
            margin-top: 20px;
        }

        .fa-circle-notch {
            font-size: 24px;
            /* Increase size of the loading icon */
        }

        .fa-check {
            font-size: 48px;
            /* Make the check larger */
            display: none;
            /* Initially hidden */
            color: #4CAF50;
            /* Success color */
        }

        @keyframes pop {
            0% {
                transform: scale(0.5);
                opacity: 0;
            }

            50% {
                transform: scale(1.2);
                opacity: 1;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .success-animation {
            text-align: center;
            animation: pop 0.5s forwards;
        }
    </style>
</head>

<body>

    <div class="payment-form">
        <h2>Payment Gateway</h2>
        <div class="form-group">
            <label for="paymentMethod">Payment Method</label>
            <select id="paymentMethod">
                <option value="cash">Cash</option>
                <option value="card">Card</option>
                <option value="upi">UPI</option>

            </select>
        </div>
        <div class="form-group hide" id="cardDetails">
            <label for="cardNumber">Card Number</label>
            <input type="text" id="cardNumber" placeholder="Card Number">
        </div>
        <div class="form-group hide" id="cvvDetails">
            <label for="cardNumber">CVV</label>
            <input type="text" id="cardNumber" placeholder="Card Number">
        </div>
        <div class="form-group hide" id="upiDetails">
            <label for="upiId">UPI ID</label>
            <input type="text" id="upiId" placeholder="UPI ID">
        </div>
        <div class="form-group" id="amountDetails">
            <label for="amount">Amount</label>
            <input type="number" id="amount" placeholder="Enter amount" value="<?php echo $amnt;
                                                                                ?>" readonly="true">
        </div>
        <button onclick="requestOTP()">Submit Payment</button>
        <div class="otp-group hide">
            <label for="otp">Enter OTP</label>
            <input type="text" id="otp" placeholder="OTP">
            <button onclick="verifyOTP(); updatestatus()">Verify OTP</button>
        </div>
        <div class="processing hide"><i class="fas fa-circle-notch"></i> Processing...</div>
        

    </div>

    <script>
        document.getElementById("paymentMethod").addEventListener("change", function() {
            const method = this.value;
            document.getElementById("cardDetails").style.display = method === 'card' ? 'block' : 'none';
            document.getElementById("cvvDetails").style.display = method === 'card' ? 'block' : 'none';
            document.getElementById("upiDetails").style.display = method === 'upi' ? 'block' : 'none';
        });

        function requestOTP() {
            const paymentMethod = document.getElementById("paymentMethod").value;

           
                // For card and UPI, request OTP as before
                document.querySelector('.payment-form > button').style.display = 'none'; // Hide the first button
                document.querySelector('.otp-group').classList.remove('hide');
            
        }


        function verifyOTP() {
            const otpInput = document.getElementById('otp').value;
            // Simulate OTP verification
            if (otpInput.trim() === '') {
                alert('Please enter the OTP.');
                return;
            }
            // Simulate OTP verification process
            document.querySelector('.otp-group').style.display = 'none'; // Hide OTP input
            document.querySelector('.processing').style.display = 'block'; // Show processing

            // Simulate an AJAX call to update the bill status
            setTimeout(() => {
                // After processing, simulate receiving a response
                document.querySelector('.processing').style.display = 'none'; // Hide processing
                const successIcon = document.createElement('i');
                successIcon.className = 'fas fa-check success-animation';
                document.querySelector('.payment-form').appendChild(successIcon); // Show success icon
                successIcon.style.display = 'block'; // Make sure the success icon is visible

                // Redirect after showing the success message
                setTimeout(() => {
                    window.location.href = 'view_bills.php'; // Redirect to view_bill.php
                }, 2000); // Adjust time as needed
            }, 2000); // Simulate a delay for the processing
            // If OTP verification is simulated successfully, proceed with the AJAX request to update the bill status
            const billId = '<?php echo $billId; ?>'; // PHP variable in JS, ensure this script block is inside PHP file

            fetch('updatebill.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `billId=${billId}`
                })
                .then(response => response.text())
                .then(data => {
                    console.log(data); // Log response from the server
                    // Show success message or handle the response appropriately
                    document.querySelector('.processing').classList.add('hide');
                    document.querySelector('.success-message').classList.remove('hide');
                })
                .catch(error => console.error('Error:', error));
        }
    </script>

</body>

</html>