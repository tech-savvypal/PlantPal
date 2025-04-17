<!DOCTYPE html>
<html>
<head>
    <title>Info Table</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Data from 'info' table</h2>

    <?php
    // Connect to database
    $conn = new mysqli("localhost", "root", "", "plantdb");  // <-- Replace 'plantdb' with your DB name

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query the info table
    $sql = "SELECT ObsDataID, DatasetID, ObservationID, AccSpeciesID, AccSpeciesName, TraitID, TraitName, DataID, DataName FROM info LIMIT 20";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr>
                <th>ObsDataID</th>
                <th>DatasetID</th>
                <th>ObservationID</th>
                <th>AccSpeciesID</th>
                <th>AccSpeciesName</th>
                <th>TraitID</th>
                <th>TraitName</th>
                <th>DataID</th>
                <th>DataName</th>
              </tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['ObsDataID']}</td>
                    <td>{$row['DatasetID']}</td>
                    <td>{$row['ObservationID']}</td>
                    <td>{$row['AccSpeciesID']}</td>
                    <td>{$row['AccSpeciesName']}</td>
                    <td>{$row['TraitID']}</td>
                    <td>{$row['TraitName']}</td>
                    <td>{$row['DataID']}</td>
                    <td>{$row['DataName']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "No data found.";
    }

    $conn->close();
    ?>
</body>
</html>
