<?php
include("../connection/connect.php");
require_once '../vendor/autoload.php';

error_reporting(0);
session_start();

$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/templates');
$twig = new \Twig\Environment($loader);

if(empty($_SESSION["adm_id"])) {
    header('location:index.php');
} else {

    
    $firstSectionCards = [
        ['sql' => "SELECT * FROM restaurant", 'title' => 'Restaurants', 'icon' => 'fa fa-home'],
        ['sql' => "SELECT * FROM dishes", 'title' => 'Dishes', 'icon' => 'fa fa-cutlery'],
        ['sql' => "SELECT * FROM users", 'title' => 'Users', 'icon' => 'fa fa-users'],
        ['sql' => "SELECT * FROM users_orders", 'title' => 'Total Orders', 'icon' => 'fa fa-shopping-cart'],


    ];

    // Second section cards
    $secondSectionCards = [
        ['sql' => "SELECT * FROM res_category", 'title' => 'Restro Categories', 'icon' => 'fa fa-th-large'],
        ['sql' => "SELECT * FROM users_orders WHERE status = 'in process'", 'title' => 'Processing Orders', 'icon' => 'fa fa-spinner'],
        ['sql' => "SELECT * FROM users_orders WHERE status = 'closed'", 'title' => 'Delivered Orders', 'icon' => 'fa fa-check'],

    ];

    // Third section cards
    $thirdSectionCards = [
        ['sql' => "SELECT * FROM users_orders WHERE status = 'rejected'", 'title' => 'Cancelled Orders', 'icon' => 'fa fa-times'],
        ['sql' => "SELECT SUM(price) AS value_sum FROM users_orders WHERE status = 'closed'", 'title' => 'Total Earnings', 'icon' => 'fa fa-usd'],
    ];

    // Function to process cards
    function processCards($db, $queries) {
        $cards = [];
        foreach ($queries as $query) {
            $result = mysqli_query($db, $query['sql']);
            $count = ($query['title'] == 'Total Earnings') ? mysqli_fetch_assoc($result)['value_sum'] : mysqli_num_rows($result);
            $cards[] = ['count' => $count, 'title' => $query['title'], 'icon' => $query['icon']];
        }
        return $cards;
    }

    $firstSectionData = processCards($db, $firstSectionCards);
    $secondSectionData = processCards($db, $secondSectionCards);
    $thirdSectionData = processCards($db, $thirdSectionCards);

    echo $twig->render('dashboard.twig', [
        'firstSection' => $firstSectionData,
        'secondSection' => $secondSectionData,
        'thirdSection' => $thirdSectionData
    ]);
}
?>
