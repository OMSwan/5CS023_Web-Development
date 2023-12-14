<?php
require_once '../vendor/autoload.php';

// Set up Twig
$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/templates');
$twig = new \Twig\Environment($loader);

include("../connection/connect.php"); 
error_reporting(0);
session_start();
// Fetch data, process it
$sql = "SELECT * FROM restaurant order by rs_id desc";
$query = mysqli_query($db, $sql);
$restaurants = [];
while ($rows = mysqli_fetch_array($query)) {
    // Fetch category name
    $mql = "SELECT * FROM res_category where c_id='".$rows['c_id']."'";
    $res = mysqli_query($db, $mql);
    $row = mysqli_fetch_array($res);

    // Process each row and add to the $restaurants array
    $restaurants[] = [
        'category' => $row['c_name'],
        'name' => $rows['title'],
        'email' => $rows['email'],
        'phone' => $rows['phone'],
        'url' => $rows['url'],
        'open_hours' => $rows['o_hr'],
        'close_hours' => $rows['c_hr'],
        'open_days' => $rows['o_days'],
        'address' => $rows['address'],
        'image' => 'Res_img/' . $rows['image'],
        'date' => $rows['date'],
        'delete_link' => 'delete_restaurant.php?res_del=' . $rows['rs_id'],
        'update_link' => 'update_restaurant.php?res_upd=' . $rows['rs_id']
    ];
}

// Render the template with the data
echo $twig->render('all_restaurant.twig', ['restaurants' => $restaurants]);