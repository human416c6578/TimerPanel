<?php

// Include your database connection and db class
require_once 'db.php';

// Create an instance of the db class
$db = new \api\db();

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

	$last_modified_time = filemtime("zones.txt");
    $last_update = $db->get_zones_last_update();
	

    if($last_update > $last_modified_time)
        $db->update_zones_file();
	
    // Send the records as JSON response
	header("Location: zones.txt");
	die();
} else {
    // If the request is not a POST request, return an error response
    http_response_code(405);
    echo json_encode(array('error' => 'Method not allowed'));
}

