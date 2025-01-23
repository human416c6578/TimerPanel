<?php

// Include your database connection and db class
require_once 'db.php';

// Create an instance of the db class
$db = new \api\db();

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get the search criteria from the POST data
    $map = $_GET['map'];

    // Check if all required search criteria are provided
    if (isset($map)) {
        // Call the get_maps function
        $logs = $db->get_map_logs($map);

        // Send the records as JSON response
        header('Content-Type: application/json');

        echo $logs;
    } else {
        // If any required criteria are missing, return an error response
        http_response_code(400);
        echo json_encode(array('error' => 'Missing search criteria'));
    }
} else {
    // If the request is not a POST request, return an error response
    http_response_code(405);
    echo json_encode(array('error' => 'Method not allowed'));
}

