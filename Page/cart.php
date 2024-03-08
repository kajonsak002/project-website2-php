<?php
session_start();
include "../Database/connectDB.php";

if (!empty($_GET['menu_id'])) {
    if (!empty($_SESSION['cart'][$_GET['menu_id']])) {
        $_SESSION['cart'][$_GET['menu_id']] += 1;
    } else {
        $_SESSION['cart'][$_GET['menu_id']] = 1;
    }
}

$cartCount = count($_SESSION['cart']);
echo $cartCount;
?>
