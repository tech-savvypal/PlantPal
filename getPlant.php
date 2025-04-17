<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');


if (!isset($_GET['plant'])) {
    echo json_encode(['error' => 'Plant name is required']);
    exit;
}

$plantName = strtolower(trim($_GET['plant']));
$filename = 'combined_data.csv';

if (!file_exists($filename)) {
    echo json_encode(['error' => 'CSV file not found']);
    exit;
}

if (($handle = fopen($filename, 'r')) !== false) {
    $headers = fgetcsv($handle); // Skip header row

    while (($data = fgetcsv($handle)) !== false) {
        $name = strtolower($data[0]); // assuming plant name is in the first column

        if ($name === $plantName) {
            fclose($handle);
            echo json_encode([
                'name' => $data[0],
                'emoji' => $data[1],
                'care' => $data[2]
            ]);
            exit;
        }
    }
    fclose($handle);
    echo json_encode(['error' => 'Plant not found']);
} else {
    echo json_encode(['error' => 'Unable to open file']);
}

?>
