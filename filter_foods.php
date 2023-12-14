<?php
include("connection/connect.php"); 
error_reporting(0);

$restaurantId = mysqli_real_escape_string($db, $_POST['restaurant']);
$foodType = mysqli_real_escape_string($db, $_POST['foodType']);
$spiciness = mysqli_real_escape_string($db, $_POST['spiciness']);
$searchQuery = mysqli_real_escape_string($db, $_POST['searchQuery']);

$query = "SELECT * FROM dishes WHERE 1"; 

// Adding conditions to the query based on filters
if (!empty($restaurantId)) {
    $query .= " AND rs_id = '$restaurantId'";
}
if (!empty($foodType)) {
    $query .= " AND dietary_type = '$foodType'"; 
if (!empty($spiciness)) {
    $query .= " AND spiciness_level = '$spiciness'"; 
}
if (!empty($searchQuery)) {
    $query = "SELECT * FROM dishes WHERE title LIKE '%" . $searchQuery . "%'"; 
}


$result = mysqli_query($db, $query);
$htmlContent = "";

while ($row = mysqli_fetch_assoc($result)) {
    $htmlContent .= "<div class='col-md-4 col-sm-6 mb-3'>";
    $htmlContent .= "<div class='card h-100'>";
        // Image
        $htmlContent .= "<img class='card-img-top img-fluid' src='admin/Res_img/dishes/" . $row['img'] . "' alt='" . htmlspecialchars($row['title'], ENT_QUOTES) . "'>";
        // Card Body
        $htmlContent .= "<div class='card-body'>";
            $htmlContent .= "<h5 class='card-title'>" . htmlspecialchars($row['title'], ENT_QUOTES) . "</h5>";
            $htmlContent .= "<p class='card-text'>" . htmlspecialchars($row['slogan'], ENT_QUOTES) . "</p>";
        $htmlContent .= "</div>";
        // Card Footer for price and Add to Cart button
        $htmlContent .= "<div class='card-footer d-flex justify-content-between'>";
            $htmlContent .= "<span class='text-muted'>$" . htmlspecialchars($row['price'], ENT_QUOTES) . "</span>";
            // Form for Add to Cart
            $htmlContent .= "<form action='add-to-cart.php' method='post'>";
                $htmlContent .= "<input type='hidden' name='dish_id' value='" . $row['d_id'] . "'>";
                $htmlContent .= "<button type='submit' class='btn btn-primary'>Add to Cart</button>";
            $htmlContent .= "</form>";
        $htmlContent .= "</div>"; // End of card footer
    $htmlContent .= "</div>"; // End of card
    $htmlContent .= "</div>"; // End of column
}
echo $htmlContent;
?>
