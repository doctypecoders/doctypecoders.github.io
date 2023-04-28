<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $latitude = $_POST["latitude"];
    $longitude = $_POST["longitude"];
    date_default_timezone_set('America/Santo_Domingo');
    $dateTime = date('Y-m-d H:i:s');
    
    $url = "https://nominatim.openstreetmap.org/reverse?lat=$latitude&lon=$longitude&format=jsonv2&accept-language=en";

    // Set headers with API key
    //https://developer.mapquest.com/ : get your api there
    $headers = array(
        'User-Agent: My Application',
        'Authorization: Bearer 5deOWzSlNuLS4nr2XFDAZVyklQanA7ue'
    );

    // Initialize cURL
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    // Execute cURL request
    $response = curl_exec($ch);

    // Close cURL
    curl_close($ch);

    // Decode JSON response into PHP array
    $data = json_decode($response, true);

    // Check if required fields exist before assigning to variables
    if (isset($data['address']['town'])) {
        $city = $data['address']['town'];
    } else {
        $city = "Unknown";
    }
    if (isset($data['address']['country'])) {
        $country = $data['address']['country'];
    } else {
        $country = "Unknown";
    }
    if (isset($data['address']['road'])) {
        $street = $data['address']['road'];
    } else {
        $street = "Unknown";
    }

    $file = fopen("locations.csv", "a") or die("Unable to open file!");
    $data = array($latitude, $longitude, $city, $country, $street, $dateTime);
    fputcsv($file, $data);
    fclose($file);

    echo "Location saved successfully!";
}
?>
