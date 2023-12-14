<?php
include("../connection/connect.php");
require_once '../vendor/autoload.php';

error_reporting(0);
session_start();

$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/templates');
$twig = new \Twig\Environment($loader);



// Initialize variables
$username = '';
$password = '';
$error = '';


if(isset($_POST['submit']))
{
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	if(!empty($_POST["submit"])) 
     {
	$loginquery ="SELECT * FROM admin WHERE username='$username' && password='$password'";
	$result=mysqli_query($db, $loginquery);
	$row=mysqli_fetch_array($result);
	
	                        if(is_array($row))
								{
                                    	$_SESSION["adm_id"] = $row['adm_id'];
										header("refresh:1;url=dashboard.php");
	                            } 
							else
							    {
                                    $error = 'Invalid username or password';
                                }
	 }
	
	
}
// Render Twig Template
echo $twig->render('index.twig', [
        
    'error' => $error
]);
