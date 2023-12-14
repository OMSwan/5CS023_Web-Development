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

if(isset($_POST['submit'])) {
    // Extract and sanitize input
    $c_name = mysqli_real_escape_string($db, $_POST['c_name']);
    $res_name = mysqli_real_escape_string($db, $_POST['res_name']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $phone = mysqli_real_escape_string($db, $_POST['phone']);
    $url = mysqli_real_escape_string($db, $_POST['url']);
    $o_hr = mysqli_real_escape_string($db, $_POST['o_hr']);
    $c_hr = mysqli_real_escape_string($db, $_POST['c_hr']);
    $o_days = mysqli_real_escape_string($db, $_POST['o_days']);
    $address = mysqli_real_escape_string($db, $_POST['address']);
    
    // Perform validations
    if(empty($c_name) || empty($res_name) || empty($email) || empty($phone) || empty($url) || empty($o_hr) || empty($c_hr) || empty($o_days) || empty($address)) {
        $error = 'All fields must be filled up!';
    } else {
        // Process file upload
        if(isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
            $allowed_extensions = ['jpg', 'png', 'gif'];
            $max_size = 1024 * 1024; // 1MB
            $extension = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
            $fnew = uniqid().'.'.$extension;
            $store = "Res_img/".basename($fnew); 

            if(!in_array($extension, $allowed_extensions)) {
                $error = 'Invalid file extension! Only png, jpg, gif are accepted.';
            } else if ($_FILES['file']['size'] > $max_size) {
                $error = 'Max Image Size is 1024kb! Try a different Image.';
            } else {
                // If file is valid, move the uploaded file and insert into database
                if(move_uploaded_file($_FILES['file']['tmp_name'], $store)) {
                    $sql = "INSERT INTO restaurant (c_id, title, email, phone, url, o_hr, c_hr, o_days, address, image) VALUES ('$c_name', '$res_name', '$email', '$phone', '$url', '$o_hr', '$c_hr', '$o_days', '$address', '$fnew')";
                    if(mysqli_query($db, $sql)) {
                        $success = 'New Restaurant Added Successfully.';
                    } else {
                        $error = 'Database insertion failed!';
                    }
                } else {
                    $error = 'Failed to move uploaded file!';
                }
            }
        } else {
            $error = 'Please select an image to upload.';
        }
    }
}

// Fetch categories for the dropdown
$categories = [];
$ssql = "SELECT * FROM res_category";
$res = mysqli_query($db, $ssql);
while($row = mysqli_fetch_assoc($res)) {
    $categories[] = $row;
}

// Render the Twig template
echo $twig->render('add_restaurant.twig', [
    'error' => $error,
    'success' => $success,
    'categories' => $categories
]);
?>
