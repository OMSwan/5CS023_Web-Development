<?php
include("connection/connect.php");
require_once 'vendor/autoload.php';
error_reporting(0);
session_start();

$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/templates');
$twig = new \Twig\Environment($loader);

$message = '';
$success = '';

if(isset($_POST['submit'])) {
    $username = $_POST['username'];  
    $password = $_POST['password'];

    if(!empty($_POST["submit"])) {
        $loginquery = "SELECT * FROM users WHERE username='$username' AND password='".md5($password)."'";
        $result = mysqli_query($db, $loginquery);
        $row = mysqli_fetch_array($result);

        if(is_array($row)) {
            $_SESSION["user_id"] = $row['u_id'];
            $success = "Login successful. Redirecting..."; 
            header("refresh:1;url=index.php");
            exit;
        } else {
            $message = "Invalid Username or Password!";
        }
    }
}


echo $twig->render('login.twig', [
	'user_id' => $_SESSION['user_id'],
	'username' => $username,
	'password' => $password,
    'message' => $message,
	'success' => $success
]);
?>