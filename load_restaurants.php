<?php
include("connection/connect.php"); 

// Fetching restaurants from the database
$query = "SELECT * FROM restaurant"; 
$result = mysqli_query($db, $query);

$restaurants = array();
while($row = mysqli_fetch_assoc($result)) {
    $restaurants[] = array(
        'id' => $row['rs_id'],
        'name' => $row['title'] 
    );
}

// Returning the result as JSON
header('Content-Type: application/json');
echo json_encode($restaurants);
?>
