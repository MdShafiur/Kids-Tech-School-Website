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
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve form data
  $quantityProgram = $_POST["quantity-schoolholiday-program"];
  $quantityProgramDay2 = $_POST["quantity-schoolholiday-program-day2"];
  $quantityProgramDay3 = $_POST["quantity-schoolholiday-program-day3"];

  $conn = new PDO("mysql:host=localhost:3307;dbname=ktcwebsite", "root", "");

  if ($quantityProgram >= 1) {
    $stmtDay1 = $conn->prepare("INSERT INTO school_holiday_program (program_name, quantity, total_price, total_points, email) VALUES (?, ?, ?, ?, ?)");
    $stmtDay1->execute(["School Holiday Program (1 Days)", $quantityProgram, $quantityProgram * 120, $quantityProgram * 120, $email]);
  }

  if ($quantityProgramDay2 >= 1) {
    $stmtDay2 = $conn->prepare("INSERT INTO school_holiday_program (program_name, quantity, total_price, total_points, email) VALUES (?, ?, ?, ?, ?)");
    $stmtDay2->execute(["School Holiday Program (2 Days)", $quantityProgramDay2, $quantityProgramDay2 * 240, $quantityProgramDay2 * 240, $email]);
  }

  if ($quantityProgramDay3 >= 1) {
    $stmtDay3 = $conn->prepare("INSERT INTO school_holiday_program (program_name, quantity, total_price, total_points, email) VALUES (?, ?, ?, ?, ?)");
    $stmtDay3->execute(["School Holiday Program (3 Days)", $quantityProgramDay3, $quantityProgramDay3 * 360, $quantityProgramDay3 * 360, $email]);
  }

}
header("Location: steamprogram.php");
    exit;
?>
