<?php
require_once '../vendor/autoload.php';

// Set up Twig
$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/templates');
$twig = new \Twig\Environment($loader);

include("../connection/connect.php"); 
error_reporting(0);
session_start();

$sql = "SELECT users.*, users_orders.* FROM users INNER JOIN users_orders ON users.u_id=users_orders.u_id";
$query = mysqli_query($db, $sql);
$orders = [];

if (mysqli_num_rows($query) > 0) {
    while ($row = mysqli_fetch_assoc($query)) {
        // Add status-specific data
        switch ($row['status']) {
            case "":
            case "NULL":
                $row['status_class'] = 'info';
                $row['status_text'] = 'Dispatch';
                break;
            case "in process":
                $row['status_class'] = 'warning';
                $row['status_text'] = 'On The Way!';
                break;
            case "closed":
                $row['status_class'] = 'primary';
                $row['status_text'] = 'Delivered';
                break;
            case "rejected":
                $row['status_class'] = 'danger';
                $row['status_text'] = 'Cancelled';
                break;
        }
        $orders[] = $row;
    }
}

echo $twig->render('all_orders.twig', ['orders' => $orders]);
?>
