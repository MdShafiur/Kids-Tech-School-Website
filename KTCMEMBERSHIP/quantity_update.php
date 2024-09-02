<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $programName = $_POST['programName'];
    $newQuantity = $_POST['newQuantity'];
    $newSubtotal = $_POST['newSubtotal'];
    $newPoints = $_POST['newPoints'];

    if (!isset($_SESSION['cart_items'])) {
        $_SESSION['cart_items'] = [];
    }

    foreach ($_SESSION['cart_items'] as &$item) {
        if (is_array($item) && $item['program'] === $programName) {
            // Update quantity, subtotal, and points
            $item['quantity'] = $newQuantity;
            $item['subtotal'] = $newSubtotal;
            $item['points'] = $newPoints;
            break;
        }
    }

    echo 'Quantity updated successfully.';
}
?>
