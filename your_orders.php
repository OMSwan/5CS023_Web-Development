<?php
include("connection/connect.php");

require_once 'vendor/autoload.php'; 
error_reporting(0);
session_start();

$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/templates');
$twig = new \Twig\Environment($loader);


// Fetching orders
$query_res = mysqli_query($db, "select * from users_orders where u_id='" . $_SESSION['user_id'] . "'");
$orders = [];

while ($row = mysqli_fetch_array($query_res)) {
    $orders[] = $row;
}

// Passing the orders to the Twig template
echo $twig->render('your_orders.twig', [
	'user_id' => $_SESSION['user_id'],
	'orders' => $orders
]);
?>
