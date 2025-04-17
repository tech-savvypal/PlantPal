<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $plantName = preg_replace("/[^a-zA-Z0-9]/", "", $_POST['plantName']);
    $escapedPlantName = $_POST['plantName'];

    $filename = __DIR__ . "/$plantName.php";

    $template = <<<EOD
<?php
\$conn = new mysqli('localhost', 'root', '', 'plant');
if (\$conn->connect_error) {
    die('Connection failed: ' . \$conn->connect_error);
}
\$plantName = '$escapedPlantName';
\$sql = "SELECT * FROM info WHERE AccSpeciesName = '\$plantName' LIMIT 1";
\$result = \$conn->query(\$sql);
?>
<!DOCTYPE html>
<html>
<head><title>Data for \$plantName</title></head>
<body>
<h2>Data for '\$plantName'</h2>
<?php
if (\$result && \$result->num_rows > 0) {
    \$row = \$result->fetch_assoc();
    echo "<table border='1'>";
    echo "<tr><th>DatasetID</th><td>{\$row['DatasetID']}</td></tr>";
    echo "<tr><th>AccSpeciesName</th><td>{\$row['AccSpeciesName']}</td></tr>";
    echo "<tr><th>TraitName</th><td>{\$row['TraitName']}</td></tr>";
    echo "<tr><th>DataName</th><td>{\$row['DataName']}</td></tr>";
    echo "<tr><th>OriglName</th><td>{\$row['OriglName']}</td></tr>";
    echo "<tr><th>Soil_Moisture</th><td>{\$row['Soil_Moisture']}</td></tr>";
    echo "<tr><th>Ambient_Temperature</th><td>{\$row['Ambient_Temperature']}</td></tr>";
    echo "<tr><th>Soil_Temperature</th><td>{\$row['Soil_Temperature']}</td></tr>";
    echo "<tr><th>Humidity</th><td>{\$row['Humidity']}</td></tr>";
    echo "<tr><th>Light_Intensity</th><td>{\$row['Light_Intensity']}</td></tr>";
    echo "<tr><th>Plant_Health_Status</th><td>{\$row['Plant_Health_Status']}</td></tr>";
    echo "</table>";
} else {
    echo "No data found for this plant.";
}
\$conn->close();
?>
</body></html>
EOD;

EOD;

    // Save the file and redirect
    file_put_contents($filename, $template);
    header("Location: $safeFileName.php");
    exit();
}
?>
