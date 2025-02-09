<?php
// Include your database connection and db class
require_once './db.php';

// Create an instance of the db class
$db = new \api\db();

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $headers = getallheaders();
    $token = isset($headers['Authorization']) ? $headers['Authorization'] : null;

    // Check if the token is valid
    if (!$token || $db->login_token($token) === false) {
        http_response_code(403);
        echo json_encode(['error' => 'Access Denied']);
        exit;
    }

    // Get JSON input
    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, true);

    if (isset($input['player']) && isset($input['strafes']) && isset($input['overlaps'])) {
        $playerName = trim($input['player']);
        $playerStrafes = (int) $input['strafes'];
        $playerOverlaps = (int) $input['overlaps'];

        // Fetch data from database
        $result = $db->get_nulls($playerName, $playerStrafes, $playerOverlaps);

        // Return the result as a JSON response
        echo $result;
    } else {
        http_response_code(400); // Bad Request
        $errors = [];
        if (!isset($input['player'])) {
            $errors[] = "Player name is missing";
        }
        if (!isset($input['strafes'])) {
            $errors[] = "Strafes are missing";
        }
        if (!isset($input['overlaps'])) {
            $errors[] = "Overlaps are missing";
        }
        echo json_encode(["error" => $errors]);
    }
} else {
    // If the request is not a POST request, return an error response
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Method not allowed']);
}
?>
