<?php
require_once '../vendor/autoload.php';

// Set up Twig
// Twig Environment setup
$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/templates');
$twig = new \Twig\Environment($loader);

include("../connection/connect.php");
error_reporting(0);
session_start();

$error = '';
$success = '';

if(isset($_POST['submit'])) {
    if(empty($_POST['c_name'])) {
        $error = 'Field Required!';
    } else {
        $check_cat = mysqli_query($db, "SELECT c_name FROM res_category WHERE c_name = '".$_POST['c_name']."' ");
        if(mysqli_num_rows($check_cat) > 0) {
            $error = 'Category already exists!';
        } else {
            $mql = "INSERT INTO res_category(c_name) VALUES('".$_POST['c_name']."')";
            mysqli_query($db, $mql);
            $success = 'New Category Added Successfully.';
        }
    }
}

$sql = "SELECT * FROM res_category ORDER BY c_id DESC";
$query = mysqli_query($db, $sql);
$categories = mysqli_fetch_all($query, MYSQLI_ASSOC);

// Render the Twig template
echo $twig->render('add_category.twig', [
    'error' => $error,
    'success' => $success,
    'categories' => $categories
]);
?>
