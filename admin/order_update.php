<?php
require_once '../vendor/autoload.php';

// Set up Twig
$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/templates');
$twig = new \Twig\Environment($loader);

include("../connection/connect.php"); 
error_reporting(0);
session_start();

if(strlen($_SESSION['user_id'])==0) { 
    header('location:../login.php');
} else {
    if(isset($_POST['update'])) {
        $form_id = $_GET['form_id'];
        $status = $_POST['status'];
        $remark = $_POST['remark'];

        $query = mysqli_query($db, "INSERT INTO remark(frm_id,status,remark) VALUES('$form_id','$status','$remark')");
        $sql = mysqli_query($db, "UPDATE users_orders SET status='$status' WHERE o_id='$form_id'");

        // Pass data to Twig
        echo $twig->render('update_order.twig', [
            'success_message' => 'Form Details Updated Successfully',
            'form_id' => $form_id,
        ]);
    } else {
        // Display the form
        echo $twig->render('update_order.twig', [
            'form_id' => $_GET['form_id'],
        ]);
    }
}
?>
