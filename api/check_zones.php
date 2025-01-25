<?php

// Include your database connection and db class
require_once 'db.php';

// Create an instance of the db class
$db = new \api\db();

// Check if the request is a POST request
// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get the search criteria from the POST data

    if (!isset($_GET["hash"])) {
        http_response_code(400);
        echo json_encode(array('error' => 'Invalid request: missing hash.'));
        exit;
    }

    $hash = $_GET["hash"];

    $last_modified_time = filemtime("zones.txt");
    $last_update = $db->get_zones_last_update();

    if($last_update > $last_modified_time)
        $db->update_zones_file();

    $zones_hash = md5_file("zones.txt");

    $result = $zones_hash === $postData->$hash?"1":"0";

    $response = array(
        'match' => $result === "1",
        'server_hash' => $zones_hash
    );

    // Send the records as JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // If the request is not a POST request, return an error response
    http_response_code(405);
    echo json_encode(array('error' => 'Method not allowed'));
}
