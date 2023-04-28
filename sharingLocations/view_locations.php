<?php
// Read the CSV file and create a table to display the list of locations
$file = fopen("./locations.csv", "r") or die("Unable to open file!");
$locations = array();

while (($data = fgetcsv($file)) !== false) {
    array_push($locations, $data);
}
fclose($file);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Lis kote</title>
    <link rel="stylesheet" type="text/css" href="./view.css">
</head>
<body>
    <div id="map"></div>

    <h1>Lis denye kote imigrasyon te ye</h1>
    <?php if (empty($locations)) { ?>
        <p>No locations saved yet.</p>
    <?php } else { ?>
        <table>
            <tr>
                <th>Latitid</th>
                <th>Longiti</th>
                <th>ki vil</th>
                <th>ki peyi</th>
                <th>ki riyel ou avni</th>
                <th>ki dat ak lè</th>
                <th>gadel nan kat la</th>
            </tr>
            <?php foreach ($locations as $location) { ?>
                <tr>
                    <td><?php echo $location[0]; ?></td>
                    <td><?php echo $location[1]; ?></td>
                    <td><?php echo $location[2]; ?></td>
                    <td><?php echo $location[3]; ?></td>
                    <td><?php echo $location[4]; ?></td>
                    <td><?php echo $location[5]; ?></td>
                    <td><button class="view-button" data-lat="<?php echo $location[0]; ?>" data-lng="<?php echo $location[1]; ?>">View</button></td>

                </tr>
            <?php } ?>
        </table>
    <?php } ?>
    <br>
    <a href="index.html">retounen</a>
<script>
    // Get the map element and the view buttons
    const mapElement = document.getElementById("map");
    const viewButtons = document.querySelectorAll(".view-button");

    // Listen for the click event on the view buttons
    viewButtons.forEach(button => {
        button.addEventListener("click", () => {
            // Get the latitude and longitude from the data attributes
            const lat = button.dataset.lat;
            const lng = button.dataset.lng;

            // Create the URL for the Google Maps Embed API
            const url = `https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3785.7746077866775!2d${lng}!3d${lat}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8eaf86e73d555555%3A0xa0352f74ee99a192!2s${lat}%2C%20${lng}!5e0!3m2!1sen!2sng!4v1621309121289!5m2!1sen!2sng`;

            // Set the iframe source to the Google Maps Embed URL
            mapElement.innerHTML = `<iframe width="100%" height="400" frameborder="0" style="border:0" src="${url}" allowfullscreen></iframe>`;
        });
    });
</script>

</body>
</html>