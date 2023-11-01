<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
    <!-- Set CSS Style for Table -->
    <style>
        table {
            width: 160%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1.5px solid black;
        }

        th, td {
            padding: 6px;
            text-align: center;
            
        }
        .approved {
            color : green;
        }
        .pending {
            color : orange;    
        }
        .failed {
            color : red;
        }
    </style>
</head>
<body>
    <!-- Retrive database to display on the table -->
    <?php
// Set the connection parameters
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

// Function to get the status based on Response_Code
// Function to get the status based on Response_Code
function getStatus($responseCode) {
    $pendingCodes = ["09"];
    if (in_array($responseCode, $pendingCodes)) {
        return "Pending";
    } elseif ($responseCode === "00") {
        return "Approved";
    } else {
        return "Failed";
    }
}

// Query to retrieve transactions
$sql = "SELECT * FROM transactions";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h1>Transaction History</h1>";
    echo "<table>"; 
    echo "<tr><th>ID</th>
        <th>Merchant ID</th>
        <th>Reference Number</th>
        <th>Amount</th>
        <th>Currency</th>
        <th>Transaction Description</th>
        <th>Key Index</th>
        <th>Signature</th>
        <th>Response Code</th>
        <th>Transaction ID</th>
        <th>Payment ID</th>
        <th>Request Date Time</th>
        <th>Response Date Time</th>
        <th>Status</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["Revpay_Merchant_ID"] . "</td>";
        echo "<td>" . $row["Reference_Number"] . "</td>";
        echo "<td>" . $row["Amount"] . "</td>";
        echo "<td>" . $row["Currency"] . "</td>";
        echo "<td>" . $row["Transaction_Description"] . "</td>";
        echo "<td>" . $row["Key_Index"] . "</td>";
        echo "<td>" . $row["Signature"] . "</td>";
        echo "<td>" . $row["Response_Code"] . "</td>"; 
        echo "<td>" . $row["Transaction_ID"] . "</td>";
        echo "<td>" . $row["Payment_ID"] . "</td>";
        echo "<td>" . $row["Request_DateTime"] . "</td>";
        echo "<td>" . $row["Response_DateTime"] . "</td>";
        echo "<td class='" . strtolower(getStatus($row["Response_Code"])) . "'>" . getStatus($row["Response_Code"]) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No transactions found.</p>";
}

// Close the database connection
$conn->close();
?>
</body>
</html>