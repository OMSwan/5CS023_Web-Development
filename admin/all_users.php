<?php
require_once '../vendor/autoload.php';

// Set up Twig
$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/templates');
$twig = new \Twig\Environment($loader);

include("../connection/connect.php"); 
error_reporting(0);
session_start();

$sql = "SELECT * FROM users ORDER BY u_id DESC";
$query = mysqli_query($db, $sql);
$users = [];

if (mysqli_num_rows($query) > 0) {
    while ($row = mysqli_fetch_assoc($query)) {
        $users[] = $row;
    }
}

echo $twig->render('all_users.twig', ['users' => $users]);
?>
