
<?php
include("connection/connect.php");
require_once 'vendor/autoload.php';
error_reporting(0);
session_start();

$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/templates');
$twig = new \Twig\Environment($loader);


$restaurants = []; // Initialize an empty array to store restaurant data
$ress = mysqli_query($db, "SELECT * FROM restaurant");

while ($rows = mysqli_fetch_array($ress)) {
    $restaurants[] = [
        'rs_id' => $rows['rs_id'],
        'image' => $rows['image'],
        'title' => $rows['title'],
        'address' => $rows['address']
    ];
}



// Rendering the Twig template with the data
echo $twig->render('restaurants.twig', [
    'user_id' => $_SESSION['user_id'], 
    'restaurants' => $restaurants
]);
?>
