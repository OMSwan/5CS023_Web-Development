<?php
include("connection/connect.php");
require_once 'vendor/autoload.php';
error_reporting(0);
session_start();
include_once 'product-action.php';

// Twig Environment setup
$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/templates');
$twig = new \Twig\Environment($loader);

// Logic to fetch cart items and other necessary data
$cart_items = $_SESSION["cart_item"];
$res_id = $_GET['res_id']; 
$item_total = 0;

foreach ($cart_items as $item) {
    $item_total += ($item["price"] * $item["quantity"]);
}

// Render Twig template with data
echo $twig->render('cash.twig', [
    'cart_items' => $cart_items,
    'item_total' => $item_total,
    'res_id' => $res_id,
    
]);
?>
