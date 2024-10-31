<?php
session_start();

if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Find the index of the product in the cart
    $index = array_search($product_id, $_SESSION['cart']);

    // If the product is in the cart, remove it
    if ($index !== false) {
        unset($_SESSION['cart'][$index]);

        // Re-index the array
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
}
header('Location: cart.php')
?>