<?php
session_start();
if (isset($_SESSION["adminemail"])) {
    $email = $_SESSION["adminemail"];
} else {
    session_unset();
    session_write_close();
    $url = "./validateadmin.php";
    header("Location: $url");
}

require 'db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $programType = $_POST["program_type"];
    $programName = $_POST["program_name"];
    $price = $_POST["price"];
    $point = $_POST["point"];

    // Prepare the SQL statement
    $sql = "INSERT INTO updatesteamprogrampage (programtype, program_name, price, point) VALUES (:program_type, :program_name, :price, :point)";
    $stmt = $conn->prepare($sql);

    // Bind the parameters
    $stmt->bindParam(':program_type', $programType);
    $stmt->bindParam(':program_name', $programName);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':point', $point);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New product added successfully.";
    } else {
        echo "Error adding new program: " . $stmt->errorInfo()[2];
    }
    header("Location: adminsteamprogram.php");
    exit;
}

$conn = null;
?>
