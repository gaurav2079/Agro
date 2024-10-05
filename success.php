<?php
session_start();
include('includes/config.php');

// Get the query string from eSewa
$q = isset($_GET['q']) ? $_GET['q'] : '';
$pid = isset($_GET['pid']) ? $_GET['pid'] : '';
$tAmt = isset($_GET['amt']) ? $_GET['amt'] : '';

// Validate inputs (ensure these are not empty)
if (empty($q) || empty($pid) || empty($tAmt)) {
    echo "<h2>Invalid Payment Request</h2>";
    exit;
}

// Check if payment was successful
if ($q == 'su') {
    // Check if user is logged in
    if (!isset($_SESSION['login'])) {
        echo "<h2>Error</h2>";
        echo "<p>You need to be logged in to complete the booking.</p>";
        exit;
    }

    $useremail = $_SESSION['login'];

    // Retrieve necessary details from session
    $fromdate = isset($_SESSION['fromdate']) ? $_SESSION['fromdate'] : null;
    $todate = isset($_SESSION['todate']) ? $_SESSION['todate'] : null;
    $comment = isset($_SESSION['comment']) ? $_SESSION['comment'] : '';

    // Ensure necessary session details are present
    if (!$fromdate || !$todate) {
        echo "<h2>Error</h2>";
        echo "<p>Booking information is missing. Please try again.</p>";
        exit;
    }

    // Prepare SQL query to insert the booking data into tblBooking
    $status = 1; // Payment successful
    $sql = "INSERT INTO tblbooking(PackageId, UserEmail, FromDate, ToDate, Comment, RegDate, status)
            VALUES(:pid, :useremail, :fromdate, :todate, :comment, NOW(), :status)";
    
    // Prepare the query
    $query = $dbh->prepare($sql);
    $query->bindParam(':pid', $pid, PDO::PARAM_STR);
    $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
    $query->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
    $query->bindParam(':todate', $todate, PDO::PARAM_STR);
    $query->bindParam(':comment', $comment, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_STR);

    // Execute the query and check if booking was successful
    if ($query->execute()) {
        // Display success message and details
        echo "<h2>Payment and Booking Successful!</h2>";
        echo "<p>Your booking has been successfully recorded. Thank you for your payment!</p>";
        echo "<p>Booking Details:</p>";
        echo "<ul>
                <li>Package ID: $pid</li>
                <li>From Date: $fromdate</li>
                <li>To Date: $todate</li>
                <li>Total Amount Paid: $tAmt</li>
              </ul>";
    } else {
        // Handle database insert failure
        echo "<h2>Error</h2>";
        echo "<p>There was an issue recording your booking. Please contact support.</p>";
    }
} else {
    // Handle invalid or failed payment requests
    echo "<h2>Invalid Payment Request</h2>";
}
?>
