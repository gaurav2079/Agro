<?php
// cancel.php
$q = $_GET['q'];

if ($q == 'fu') {
    // This confirms that the transaction failed or was canceled
    echo "<h2>Payment Failed or Canceled</h2>";
    echo "<p>Unfortunately, your payment could not be processed. Please try again.</p>";
} else {
    echo "<h2>Invalid Request</h2>";
}
?>
