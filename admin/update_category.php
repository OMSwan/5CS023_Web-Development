<?php
require_once '../vendor/autoload.php';

// Set up Twig
$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/templates');
$twig = new \Twig\Environment($loader);

include("../connection/connect.php"); 
error_reporting(0);
session_start();

$error = '';
$success = '';
$categoryName = '';

if (isset($_POST['submit'])) {
    if (empty($_POST['c_name'])) {
        $error = 'Field Required!';
    } else {
        $mql = "update res_category set c_name ='".mysqli_real_escape_string($db, $_POST['c_name'])."' where c_id='".mysqli_real_escape_string($db, $_GET['cat_upd'])."'";
        mysqli_query($db, $mql);
        $success = 'Updated! Successfully.';
    }
}

if (isset($_GET['cat_upd'])) {
    $ssql = "select * from res_category where c_id='".mysqli_real_escape_string($db, $_GET['cat_upd'])."'";
    $res = mysqli_query($db, $ssql); 
    $row = mysqli_fetch_array($res);
    $categoryName = $row['c_name'];
}

echo $twig->render('update_category.twig', [
    'error' => $error,
    'success' => $success,
    'categoryName' => $categoryName
]);
?>
