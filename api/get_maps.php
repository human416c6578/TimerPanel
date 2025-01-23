<?php

// Include your database connection and db class
require_once 'db.php';

// Create an instance of the db class
$db = new \api\db();

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Call the get_maps function
    $maps = $db->get_maps();

    // Send the records as JSON response
    header('Content-Type: application/json');

    echo $maps;
} else {
    // If the request is not a POST request, return an error response
    http_response_code(405);
    echo json_encode(array('error' => 'Method not allowed'));
}

