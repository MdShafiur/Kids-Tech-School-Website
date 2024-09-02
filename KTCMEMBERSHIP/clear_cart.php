<?php
session_start();

// Clear the cart
unset($_SESSION['cart_items']);

// Return a response indicating success
echo 'Cart cleared successfully.';
?>
