
<?php
include("connection/connect.php");
require_once 'vendor/autoload.php';
include_once 'product-action.php';
error_reporting(0);
session_start();

$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/templates');
$twig = new \Twig\Environment($loader);





function function_alert() { 
      

    echo "<script>alert('Thank you. Your Order has been placed!');</script>"; 
    echo "<script>window.location.replace('your_orders.php');</script>"; 
} 
$orderPlaced = false;
if(empty($_SESSION["user_id"]))
{
	header('location:login.php');
}
else{

										  
	    foreach ($_SESSION["cart_item"] as $item)
		    {
											
		        $item_total += ($item["price"]*$item["quantity"]);
												
		        if($_POST['submit'])
				    {
						
				        $SQL="insert into users_orders(u_id,title,quantity,price) values('".$_SESSION["user_id"]."','".$item["title"]."','".$item["quantity"]."','".$item["price"]."')";
						
						mysqli_query($db,$SQL);
														
                                                        
                        unset($_SESSION["cart_item"]);
                        unset($item["title"]);
                        unset($item["quantity"]);
                        unset($item["price"]);
                        $orderPlaced = true;
						$success = "Thank you. Your order has been placed!";

                        function_alert();

														
														
						}
				}
    }
echo $twig->render('checkout.twig', [
    'user_id' => $_SESSION['user_id'],
    'orderPlaced' => $orderPlaced,
    'item_total' => $item_total
]);
?>