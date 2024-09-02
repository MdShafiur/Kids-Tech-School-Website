<?php
session_start();

$servername = "localhost";
$username = "id19727041_ktcmembership";
$password = "Ktcmembership123$";
$dbname = "id19727041_ktcwebsite";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST["update_status"]) && isset($_POST["purchase_id"])) {
    $purchaseId = $_POST["purchase_id"];
    $tableName = $_POST["table_name"]; // Add this line to get the table name

    // Update the payment status to 'complete'
    $updateSql = "UPDATE $tableName SET payment_status = 'complete' WHERE id = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("i", $purchaseId);
    $stmt->execute();
    $stmt->close();

    // Redirect back to the appropriate page based on the table name
    if ($tableName === 'productpurchase') {
        header("Location: adminpaymenthistory.php");
    } elseif ($tableName === 'classpurchase') {
        header("Location: adminpaymenthistory.php"); // Change to the appropriate page
    }elseif ($tableName === 'schoolprogrampurchase') {
        header("Location: adminpaymenthistory.php"); // Change to the appropriate page
    }elseif ($tableName === 'exhibition_purchase') {
        header("Location: adminpaymenthistory.php"); // Change to the appropriate page
    }
    exit();
}

$conn->close();
?>
