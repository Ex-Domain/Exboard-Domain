<?php
function translate($text, $targetLang) {
    $settings = json_decode(file_get_contents('data/settings.json'), true);
    $apiKey = $settings['deeplx_api_key'];
    $url = 'https://api.deeplx.com/v2/translate';

    $data = [
        'auth_key' => $apiKey,
        'text' => $text,
        'target_lang' => strtoupper($targetLang)
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ]
    ];

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result === FALSE) {
        die('Error');
    }

    $response = json_decode($result, true);
    return $response['translations'][0]['text'];
}
?>
