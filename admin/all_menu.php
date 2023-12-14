<?php
require_once '../vendor/autoload.php';

// Set up Twig
$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/templates');
$twig = new \Twig\Environment($loader);

include("../connection/connect.php"); 
error_reporting(0);
session_start();

$sql = "SELECT * FROM dishes ORDER BY d_id DESC";
$query = mysqli_query($db, $sql);

$menus = [];
if (mysqli_num_rows($query) > 0) {
    while ($row = mysqli_fetch_assoc($query)) {
        $mql = "SELECT * FROM restaurant WHERE rs_id='".$row['rs_id']."'";
        $newquery = mysqli_query($db, $mql);
        $fetch = mysqli_fetch_assoc($newquery);

        $menus[] = [
            'restaurant' => $fetch['title'],
            'dish' => $row['title'],
            'description' => $row['slogan'],
            'price' => $row['price'],
            'image' => $row['img'],
            'd_id' => $row['d_id']
        ];
    }
}

echo $twig->render('all_menu.twig', ['menus' => $menus]);
?>
