<?php
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "ktcwebsite";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the submitted data
$quantities = $_POST['quantity'];
$productIds = $_POST['product_id'];

// Prepare and execute the insert statement for each product
$stmt = $conn->prepare("INSERT INTO productpurchase (product_ID, quantity) VALUES (?, ?)");
$stmt->bind_param("ii", $productId, $quantity);

for ($i = 0; $i < count($quantities); $i++) {
    $productId = $productIds[$i];
    $quantity = $quantities[$i];

    // Insert the product into the database
    $stmt->execute();
}

$stmt->close();
$conn->close();
?>