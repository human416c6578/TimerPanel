<?php
// Include your database connection and db class
require_once './db.php';

// Create an instance of the db class
$db = new \api\db();

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $headers = getallheaders();
    $token = $headers['Authorization'];
    
    // Check if the token is valid
    if ($db->login_token($token) === false) {
        http_response_code(403);
        echo json_encode(array('error' => 'Access Denied'));
        exit;
    }
    
    // Get the raw POST data and decode it
    $postData = json_decode(file_get_contents("php://input"), true);

    // Check if the 'id' parameter is provided
    if (isset($_POST['id'])) {
        $playerId = $_POST['id'];
        $rank1Records = isset($_POST['rank1Records']) ? json_decode($_POST['rank1Records'], true) : [];

        // Pass the rank1Records to the delete_player function
        $result = $db->delete_player($playerId, $rank1Records);

        // Return the result as a JSON response
        echo json_encode($result);
    } else {
        http_response_code(400); // Bad Request
        echo json_encode(array("error" => "Player ID is missing"));
    }
    
} else {
    // If the request is not a POST request, return an error response
    http_response_code(405); // Method Not Allowed
    echo json_encode(array('error' => 'Method not allowed'));
}
?>
