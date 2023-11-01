<?php
// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture the request date and time
    $requestDateTime = date('Y-m-d H:i:s');

    // Retrieve and process the response data
    $merchantKey = $_POST['Merchant_Key'];
    $merchantId = $_POST['Revpay_Merchant_ID'];
    $referenceNumber = $_POST['Reference_Number'];
    $amount = $_POST['Amount'];
    $currency = $_POST['Currency'];
    $transactionDescription = $_POST['Transaction_Description'];
    $customerIP = $_POST['Customer_IP'];
    $returnURL = $_POST['Return_URL'];
    $keyIndex = $_POST['Key_Index'];
    $signature = $_POST['Signature'];
    $responseCode = $_POST['Response_Code']; 

    // Check if Transaction ID and Payment ID are part of the response
    $transactionId = isset($_POST['Transaction_ID']) ? $_POST['Transaction_ID'] : "N/A";
    $paymentId = isset($_POST['Payment_ID']) ? $_POST['Payment_ID'] : "N/A";

    // Perform validation checks
    $isValidPayment = true; // Assume the payment is valid by default

    // Example: Check if the payment amount is zero
    if ($amount == 0 && $signature == "") {
        $isValidPayment = false;
    }

    // Capture the response date and time
    $responseDateTime = date('Y-m-d H:i:s');

    if ($isValidPayment) {
        // Payment is valid, display the response
        echo "<h1>Payment Response Received Successfully!</h1>";
        echo "<p>Request Date and Time: $requestDateTime</p>";
        echo "<p>Response Date and Time: $responseDateTime</p>";
        echo "<p>Response Code: $responseCode</p>"; // Display the response code
        echo "<p>Transaction ID: $transactionId</p>";
        echo "<p>Payment ID: $paymentId</p>";
        echo "<p>Signature: $signature</p>";

        // Database connection details
        $servername = "127.0.0.1";
        $username = "root";
        $password = "root";
        $dbname = "payments";

        // Create a database connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check if the connection was successful
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        echo "Connection successful";

        // SQL query to insert the response data into the database
      
        $sql = "INSERT INTO transactions (Revpay_Merchant_ID, Reference_Number, Amount, Currency, Transaction_Description, Key_Index, Signature, Response_Code, Transaction_ID, Payment_ID, Request_DateTime, Response_DateTime)
        VALUES ('$merchantId', '$referenceNumber', $amount, '$currency', '$transactionDescription', $keyIndex, '$signature', '$responseCode', '$transactionId', '$paymentId', '$requestDateTime', '$responseDateTime')";

        if ($conn->query($sql) === TRUE) {
            echo "Payment Response has been stored in Database.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close the database connection
        $conn->close();
    } else {
        // Payment is not valid, display an error message
        echo "<h1>Payment Response - Invalid Payment</h1>";
        echo "<p>The payment request is not valid. Please contact support for assistance.</p>";
    }
} else {
    // Handle invalid request methods or other errors
    echo "<h1>Payment Response Received Failed.</h1>";
    echo "<p>Invalid request method.</p>";
}
?>
