<?php
session_start();
include("connection/connect.php");

if(isset($_POST['dish_id'])) {
    $dish_id = $_POST['dish_id'];
    // Fetch dish details from the database
    $query = "SELECT * FROM dishes WHERE d_id = '$dish_id'";
    $result = mysqli_query($db, $query);
    $dish = mysqli_fetch_assoc($result);

    $cartItem = array(
        'd_id' => $dish['d_id'],
        'title' => $dish['title'],
        'price' => $dish['price'],
        'quantity' => 1 // Default quantity
    );

    if(!isset($_SESSION['cart_item'])) {
        $_SESSION['cart_item'] = array();
    }

    $_SESSION['cart_item'][$dish['d_id']] = $cartItem;

    header("Location: menu.php"); // Redirect back to the food listing page
}
?>
