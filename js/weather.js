// Use your own OpenWeatherMap API Key below
const apiKey = 'b72cc5f21d93d8317baf904470f0a6ff';

const weatherContainer = document.getElementById("weather");
const error = document.getElementById('error');

async function fetchWeather() {
    try {
        weatherContainer.innerHTML = '';
        error.innerHTML = '';

        const cnt = 1; // Only need the current weather
        const city = 'Valletta';

        const apiUrl = `https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${apiKey}&units=metric`;

        const response = await fetch(apiUrl);
        const data = await response.json();

        // Display error if there is an issue with the API call
        if (data.cod !== 200) {
            error.innerHTML = `Error retrieving weather data: ${data.message}`;
            return;
        }

        const temp = data.main.temp;
        let message = '';

        if (temp > 25) {
            message = 'The Weather is hot today, it\'s a great day to order food.';
        } else if (temp > 15) {
            message = 'The weather is great today, not a better time to order.';
        } else {
            message = 'The weather is cold today, it\'s a good day to order food in the comfort of your home.';
        }

        weatherContainer.innerHTML = message;

    } catch (error) {
        console.error(error);
        weatherContainer.innerHTML = 'Failed to fetch weather data.';
    }
    document.getElementById('currentTemperature').innerHTML = `Current Temperature: ${temp}°C`;

}

// Call the function to display the weather information
fetchWeather();
