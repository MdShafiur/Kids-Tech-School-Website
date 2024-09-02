<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['program'])) {
        $program = $_POST['program'];

        // Find the index of the item in the cart
        $index = array_search($program, array_column($_SESSION['cart_items'], 'program'));

        // Remove the item from the cart array
        if ($index !== false) {
            array_splice($_SESSION['cart_items'], $index, 1);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Item not found in cart.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>