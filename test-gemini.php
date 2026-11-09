<?php

$key = getenv('GEMINI_API_KEY');

$url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-3.8-flash:generateContent';

$ch = curl_init($url);

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'x-goog-api-key: ' . $key,
    ],
    CURLOPT_POSTFIELDS => json_encode([
        'contents' => [
            [
                'parts' => [
                    ['text' => 'Olá! Responde em português.']
                ]
            ]
        ]
    ]),
]);

$response = curl_exec($ch);
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

echo "HTTP Status: $status\n";
echo $response;

curl_close($ch);