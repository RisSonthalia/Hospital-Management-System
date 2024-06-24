<?php
session_start();
include('include/config.php');
include('include/checklogin.php');
check_login();

if (isset($_POST['billId'])) {
    $billId = $_POST['billId'];

    // Assuming you've already validated the OTP in your JavaScript and are ready to mark the bill as paid
    $query = mysqli_query($con, "UPDATE bill SET status='paid' , amount_to_be_paid = 0.00 WHERE bill_id = '$billId'");

    if ($query) {
        echo "Bill status updated successfully.";
    } else {
        echo "Error updating bill status.";
    }
} else {
    echo "Invalid request.";
}
?>
