<?php
require("autoload.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('memory_limit', '-1');
$weather = new Weather();
$egyptionCities = $weather->get_cities();
if (isset($_POST["submit"])) {
    $weatherData = $weather->get_weather($_POST["cities"]);
    $cityName = $weatherData->name;
    $timestamp = $weatherData->dt;
    $currentTime = date('l, H:i:s, F jS Y', $timestamp);
    $description = $weatherData->weather[0]->description;
    $humidity = $weatherData->main->humidity;
    $temp = $weatherData->main->temp;
    $windSpeed = $weatherData->wind->speed;
}
?>
<html>

<head>
    <meta charset="UTF-8">
    <title></title>
</head>

<body>
    <div>
        <?php
        if (!empty($weatherData)) {

            echo "<h1>$cityName Weather Status</h1>";
            echo "<p>$currentTime</p>";
            echo "<p>$description</p>";
            echo "<p>Temp: $temp F</p>";
            echo "<p>Humidity: $humidity %</p>";
            echo "<p>Wind: $windSpeed km/h</p>";


        }
        ?>
    </div>
    <form method="POST" action="index.php">
        <select name="cities" id="cities" de>
            <?php
            foreach ($egyptionCities as $key => $cityInfo) {
                echo "<option value='" . $cityInfo["id"] . "'>" . $cityInfo["name"] . "</option>";
            }
            ?>
        </select>
        <input id="submit" name="submit" type="submit" value="Get Weather Data" />
    </form>
</body>

</html>