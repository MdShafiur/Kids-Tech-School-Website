<?php
session_start();

if (isset($_SESSION["email"])) {
  $email = $_SESSION["email"];
} else {
  session_unset();
  session_write_close();
  $url = "./index.php";
  header("Location: $url");
  exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $conn = new PDO("mysql:host=localhost:3307;dbname=ktcwebsite", "root", "");

  // Retrieve form data for each product
  $quantity1 = $_POST["quantity1"];
  $quantity2 = $_POST["quantity2"];
  $quantity3 = $_POST["quantity3"];
  // Add more quantities for other products if needed

  // Store the product details in the database
  if ($quantity1 >= 1) {
    $stmt1 = $conn->prepare("INSERT INTO productpurchase (product_name, quantity, price, points, email) VALUES (?, ?, ?, ?, ?)");
    $stmt1->execute(["KidzTechCentre Button Badge", $quantity1, $quantity1 * 3, $quantity1 * 3, $email]);
  }

  if ($quantity2 >= 1) {
    $stmt2 = $conn->prepare("INSERT INTO productpurchase (product_name, quantity, price, point, email) VALUES (?, ?, ?, ?, ?)");
    $stmt2->execute(["Bionic Worm Crawling Robot", $quantity2, $quantity2 * 15, $quantity2 * 15, $email]);
  }

  if ($quantity3 >= 1) {
    $stmt3 = $conn->prepare("INSERT INTO productpurchase (product_name, quantity, price, point, email) VALUES (?, ?, ?, ?, ?)");
    $stmt3->execute(["Geared Mobile Robot", $quantity3, $quantity3 * 18, $quantity3 * 18, $email]);
  }
  
  // Add more if statements for other products if needed

  // Redirect to a success page or display a success message
  header("Location: product.php");
  exit;
}
?>