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
    // Assign POST data to variables and sanitize input
    $d_name = mysqli_real_escape_string($db, $_POST['d_name']);
    $about = mysqli_real_escape_string($db, $_POST['about']);
    $price = mysqli_real_escape_string($db, $_POST['price']);
    $res_name = mysqli_real_escape_string($db, $_POST['res_name']);
    $dietary_type = mysqli_real_escape_string($db, $_POST['dietary_type']);
    $spiciness_level = mysqli_real_escape_string($db, $_POST['spiciness_level']);

    // Validation
    if(empty($d_name) || empty($about) || empty($price) || empty($res_name)) {
        $error = 'All fields must be filled up!';
    } else {
        // File upload logic
        if(isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
            $max_size = 1024 * 1024; // 1MB
            $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

            if(!in_array(strtolower($extension), $allowed_extensions)) {
                $error = 'Invalid file extension!';
            } else if ($_FILES['file']['size'] > $max_size) {
                $error = 'File size is too large!';
            } else {
                $fnew = uniqid() . '.' . $extension;
                $store = "Res_img/dishes/" . $fnew;
                if(move_uploaded_file($_FILES['file']['tmp_name'], $store)) {
                    // Insert into database
                    $sql = "INSERT INTO dishes (rs_id, title, slogan, price, img, dietary_type, spiciness_level) VALUES (
                        '{$res_name}', '{$d_name}', '{$about}', '{$price}', '{$fnew}', '{$dietary_type}', '{$spiciness_level}'
                    )";
                    if(mysqli_query($db, $sql)) {
                        $success = 'New Dish Added Successfully.';
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

// Fetch restaurants for the dropdown
$restaurants = [];
$ssql = "SELECT * FROM restaurant";
$res = mysqli_query($db, $ssql);
while($row = mysqli_fetch_assoc($res)) {
    $restaurants[] = $row;
}

// Render the Twig template
echo $twig->render('add_menu.twig', [
    'error' => $error,
    'success' => $success,
    'restaurants' => $restaurants
]);
?>
