<?php
include("connection/connect.php");
require_once 'vendor/autoload.php';
error_reporting(0);
session_start();

$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/templates');
$twig = new \Twig\Environment($loader);


// Query to fetch restaurants
$query = "SELECT rs_id, title FROM restaurant";
$result = mysqli_query($db, $query);
include_once 'product-action.php';



// Render Twig template with the fetched data
echo $twig->render('menu.twig', [
    'user_id' => $_SESSION['user_id'], 
    
]);
?>
