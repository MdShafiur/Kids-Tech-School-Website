<?php
// reset-password.php

$token = $_POST['token'];

$token_hash = hash("sha256", $token);

$pdo = require __DIR__ . "/db_conn.php";

// Verify token against the database and check if it's not expired
$sql = "SELECT * FROM tbl_member WHERE reset_token_hash = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$token_hash]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result === false) {
    die("Token not found");
}

if (strtotime($result["reset_token_expires_at"]) <= time()) {
    die("Token has expired");
}

if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters");
}

if (!preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}

if (!preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain at least one number");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords must match");
}

$password = $_POST["password"];

$sql = "UPDATE tbl_member
        SET password = ?,
            reset_token_hash = NULL,
            reset_token_expires_at = NULL
        WHERE id = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$password, $result["id"]]);

// Display success message with CSS styles
echo '<div style="text-align: center; padding: 20px; background-color: #e6f7ff; border-radius: 5px;">
        <p style="font-size: 18px; color: #008ae6;">Password updated. You can now login.</p>
        <form action="index.php">
          <button type="submit" style="padding: 10px 20px; background-color: #008ae6; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Go to Login</button>
        </form>
      </div>';
?>
