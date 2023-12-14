$(document).ready(function() {
    // Function to load restaurants dynamically
    function loadRestaurants() {
        $.ajax({
            url: 'load_restaurants.php', // PHP file to load restaurants
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                // Populate restaurant filter options
            },
            error: function(error) {
                // Handle errors
            }
        });
    }

    // Function to handle filter change
    function applyFilters() {
        let restaurant = $('#restaurantFilter').val();
        let foodType = $('#foodTypeFilter').val();
        let spiciness = $('#spicinessFilter').val();
        let searchQuery = $('#searchBar').val();

        // Store filters in cookies
        document.cookie = `restaurant=${restaurant};max-age=${30*24*60*60}`;
        document.cookie = `foodType=${foodType};max-age=${30*24*60*60}`;
        document.cookie = `spiciness=${spiciness};max-age=${30*24*60*60}`;
        document.cookie = `searchQuery=${searchQuery};max-age=${30*24*60*60}`;

        $.ajax({
            url: 'filter_foods.php', // PHP file to process filters
            type: 'POST',
            data: {
                restaurant: restaurant,
                foodType: foodType,
                spiciness: spiciness,
                searchQuery: searchQuery
            },
            success: function(data) {
                $('#foodList').html(data);
            },
            error: function(error) {
                // Handle errors
            }
        });
    }

    // Event Listeners
    $('#restaurantFilter, #foodTypeFilter, #spicinessFilter').change(applyFilters);
    $('#searchBar').on('input', applyFilters);

    // Load initial data
    loadRestaurants();
    applyFilters(); // Load last used filters if they exist in cookies
});
