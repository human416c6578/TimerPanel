<?php
// Include your database connection and db class
require_once 'db.php';

// Create an instance of the db class
$db = new \api\db();

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the search criteria from the POST data
    $postData = json_decode(file_get_contents("php://input"));
    // Check if all required search criteria are provided
    if (isset($postData->id)) {
        // Call the get_records function with the search criteria
        $activity_dr = $db->get_player_activity($postData->id, "played_time_info");
        $activity_bhop = $db->get_player_activity($postData->id, "played_time_info_bhop");
        $activity_br = $db->get_player_activity($postData->id, "played_time_info_br");
        $activity_br_dr = $db->get_player_activity($postData->id, "played_time_info_br_dr");

        // Send the records as JSON response
        header('Content-Type: application/json');

        
        $response = array(
            'activity_dr' => json_decode($activity_dr),
            'activity_bhop' => json_decode($activity_bhop),
            'activity_br' => json_decode($activity_br),
            'activity_br_dr' => json_decode($activity_br_dr)
        );

        echo json_encode($response);
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
?>
