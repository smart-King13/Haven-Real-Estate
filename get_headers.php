<?php
$url = 'https://iaptqzvkebjplpadabtx.supabase.co/rest/v1/profiles?select=id&limit=1';
$apiKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImlhcHRxenZrZWJqcGxwYWRhYnR4Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3Njk1MjM2NzIsImV4cCI6MjA4NTA5OTY3Mn0.hCVG7jVNWmdpH2HqsphlpgKS8R0LJpA5Y6FnIWU2694';

$opts = [
    'http' => [
        'method' => 'GET',
        'header' => "apikey: $apiKey\r\n" .
                    "Authorization: Bearer $apiKey\r\n"
    ]
];

$context = stream_context_create($opts);
$h = get_headers($url, 1, $context);
print_r($h);
?>
