<?php
// Check if the 'url' parameter is provided
if (isset($_GET['url'])) {
    $url = $_GET['url'];

    // Initialize a cURL session
    $ch = curl_init($url);

    // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_NOBODY, false);

    // Execute the cURL request and get the response
    $response = curl_exec($ch);

    // Extract the header from the response
    $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $header = substr($response, 0, $headerSize);
    $body = substr($response, $headerSize);

    // Get content type from the header
    $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

    // Close the cURL session
    curl_close($ch);

    // Check if the content type indicates a file (you can adjust this to match expected file types)
    $validContentTypes = ['application/octet-stream', 'application/pdf', 'image/jpeg', 'image/png', 'application/zip', 'text/plain'];
    if (in_array($contentType, $validContentTypes)) {
        header("Content-Type: " . $contentType);
        echo $body;
    } else {
        // Content type is not valid or not a file; return nothing
        http_response_code(204); // No Content
    }
} else {
    echo 'No URL specified.';
}
?>
