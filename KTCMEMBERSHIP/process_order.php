<?php
session_start();
if (isset($_SESSION["email"])) {
    $email = $_SESSION["email"];
} else {
    session_unset();
    session_write_close();
    $url = "./index.php";
    header("Location: $url");
    exit(); // Add exit after redirecting to prevent further execution
}

$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "ktcwebsite";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productid = $_POST['product_ID'];
    $productname = $_POST['product_name'];
    $price = $_POST['price'];

    $sql = "INSERT INTO productpurchase (email, product_ID, , product_name, price)
            VALUES ('$email', '$productid', '$productname', '$points')";

    if ($conn->query($sql) === TRUE) {
        // Data inserted successfully. Redirect to another page.
        $url = "redeempoint.php";
        header("Location: $url");
        exit(); // Add exit after redirecting to prevent further execution
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$sql = "SELECT * FROM productpurchase WHERE email = '$email'";
$result = $conn->query($sql);
?>
