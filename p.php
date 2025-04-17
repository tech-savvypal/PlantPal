<?php
$conn = new mysqli('localhost', 'root', '', 'plantpal');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
$plantName = 'p';
$sql = "SELECT * FROM info WHERE AccSpeciesName = '$plantName' LIMIT 1";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data for $plantName</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f5f5;
            padding: 30px;
            color: #333;
        }
        h2 {
            color: #2e7d32;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0px 2px 8px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px 15px;
            border: 1px solid #ccc;
            text-align: left;
        }
        th {
            background-color: #4caf50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f0f0f0;
        }
        .no-data {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
<h2>Data for '$plantName'</h2>
<?php
if ($result && $result->num_rows > 0) {
    echo "<table><tr>";
    while ($field = $result->fetch_field()) {
        echo "<th>{$field->name}</th>";
    }
    echo "</tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>" . htmlspecialchars($value) . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p class='no-data'>No data found for this plant.< /p>";
}
$conn->close();
?>
</body>
</html>