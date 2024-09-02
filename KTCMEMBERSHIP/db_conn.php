<?php
$db_username = 'root';
$db_password = '';

try {
    $conn = new PDO('mysql:host=localhost;dbname=id19727041_ktcwebsite', $db_username, $db_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Fatal Error: Connection Failed! " . $e->getMessage());
}

return $conn;
?>
