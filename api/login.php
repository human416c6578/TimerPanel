<?php
// Include your database connection and db class
require_once './db.php';

// Create an instance of the db class
$db = new \api\db();

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $headers = getallheaders();
    
    if(isset($headers['Authorization'])) {
        $token = $headers['Authorization'];
        if($db->login_token($token) === false) {
            http_response_code(403);
            echo json_encode(array('error' => 'Access Denied'));
        }
          
        // Send the records as JSON response
        echo json_encode(array('token' => $token));
    }
    else if(isset($_POST['email']) && isset($_POST['password'])){
        $email = $_POST['email'];
        $pass = $_POST['password'];
        $response = $db->login($email, $pass);
        if($response !== -1) {
            echo json_encode($response);
        }
        else{
            http_response_code(403);
            echo json_encode(array('error' => 'Access Denied'));
        }
    }
    
} else {
    // If the request is not a POST request, return an error response
    http_response_code(405);
    echo json_encode(array('error' => 'Method not allowed'));
}
?>
