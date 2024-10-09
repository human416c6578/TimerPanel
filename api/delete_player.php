<?php
// Include your database connection and db class
require_once './db.php';

// Create an instance of the db class
$db = new \api\db();

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $headers = getallheaders();
    $token = $headers['Authorization'];
    
    
    if($db->login_token($token) === false) {
        http_response_code(403);
        echo json_encode(array('error' => 'Access Denied'));
    }
    
    $postData = json_decode(file_get_contents("php://input"));

    // Check if all required search criteria are provided
    if (isset($_POST['id'])) {
        echo json_encode($db->delete_player($_POST['id']));
    }
    else{
        http_response_code(405);
        echo json_encode(array("error"=> $_POST['id']));
    }
    
} else {
    // If the request is not a POST request, return an error response
    http_response_code(405);
    echo json_encode(array('error' => 'Method not allowed'));
}
?>
