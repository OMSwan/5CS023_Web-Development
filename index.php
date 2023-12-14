
<?php
include("connection/connect.php");
require_once 'vendor/autoload.php';
error_reporting(0);
session_start();

$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/templates');
$twig = new \Twig\Environment($loader);

// Prepare data to pass to the Twig template




$res = mysqli_query($db, "select * from res_category");
$categories = [];
while ($row = mysqli_fetch_array($res)) {
    $categories[] = $row['c_name'];
}

$query_res = mysqli_query($db, "SELECT * FROM dishes LIMIT 6");
$dishes = [];

while ($row = mysqli_fetch_array($query_res)) {
    $dishes[] = $row;
}

$restaurants = [];
$ress = mysqli_query($db, "SELECT * FROM restaurant");

while ($rows = mysqli_fetch_array($ress)) {
    $query = mysqli_query($db, "SELECT * FROM res_category WHERE c_id='" . $rows['c_id'] . "'");
    $rowss = mysqli_fetch_array($query);

    $restaurants[] = [
        'category_name' => $rowss['c_name'],
        'restaurant_logo' => 'admin/Res_img/' . $rows['image'],
        'restaurant_id' => $rows['rs_id'],
        'title' => $rows['title'],
        'address' => $rows['address']
    ];
}



echo $twig->render('index.twig', [
    'user_id' => $_SESSION['user_id'], 
    'categories' => $categories,
    'restaurants' => $restaurants,
    'dishes' => $dishes,

]);

?>
