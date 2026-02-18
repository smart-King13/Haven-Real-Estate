<?php
$apiKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImlhcHRxenZrZWJqcGxwYWRhYnR4Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3Njk1MjM2NzIsImV4cCI6MjA4NTA5OTY3Mn0.hCVG7jVNWmdpH2HqsphlpgKS8R0LJpA5Y6FnIWU2694';
$url = 'https://iaptqzvkebjplpadabtx.supabase.co/rest/v1/';

$opts = [
    'http' => [
        'method' => 'GET',
        'header' => "apikey: $apiKey\r\n" .
                    "Authorization: Bearer $apiKey\r\n"
    ]
];

$context = stream_context_create($opts);
$content = file_get_contents($url, false, $context);
if ($http_response_header) {
    echo implode("\n", $http_response_header);
}
?>
