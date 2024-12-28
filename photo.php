<?php

if (isset($_GET['prompt'])) {
    $content = $_GET['prompt'];
} else {
    $response = [
        'error' => 'Missing content parameter',
        'status' => 400
    ];
    echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    exit;
}

$url = 'https://www.blackbox.ai/api/chat';

$headers = [
    'authority: www.blackbox.ai',
    'accept: */*',
    'accept-language: en-IN,en-GB;q=0.9,en-US;q=0.8,en;q=0.7',
    'cache-control: no-cache',
    'content-type: application/json',
    'cookie: sessionId=3033c7d1-cff1-434c-99e1-2230eb4082df; intercom-id-jlmqxicb=bb00e518-0266-4b82-943a-e06982f73b3b; intercom-device-id-jlmqxicb=3911161f-8755-4a5a-a4dc-2f4071616805; render_session_affinity=0ab0fdad-f89e-4d58-8bef-167e551c35a1; __Host-authjs.csrf-token=3a76ae241a217c8c3fe0791be8e6944fe0b462d379829b04549a39ce6233024d%7C56a6d420eb6ec3f12ce3aec9667f4a4c1bca144f476ded304583f2110a992f74; __Secure-authjs.callback-url=https%3A%2F%2Fwww.blackbox.ai; intercom-session-jlmqxicb=',
    'origin: https://www.blackbox.ai',
    'pragma: no-cache',
    'referer: https://www.blackbox.ai/agent/ImageGenerationLV45LJp',
    'sec-ch-ua: "Not-A.Brand";v="99", "Chromium";v="124"',
    'sec-ch-ua-mobile: ?1',
    'sec-ch-ua-platform: "Android"',
    'sec-fetch-dest: empty',
    'sec-fetch-mode: cors',
    'sec-fetch-site: same-origin',
    'user-agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Mobile Safari/537.36'
];
header('Content-Type: application/json');

$data = [
    "messages" => [
        [
            "id" => "yZjbCSe-y3wrUW-ytNA1l",
            "content" => $content,
            "role" => "user"
        ]
    ],
    "id" => "yZjbCSe-y3wrUW-ytNA1l",
    "previewToken" => null,
    "userId" => null,
    "codeModelMode" => true,
    "agentMode" => [
        "mode" => true,
        "id" => "ImageGenerationLV45LJp",
        "name" => "Image Generation"
    ],
    "trendingAgentMode" => new stdClass(),
    "isMicMode" => false,
    "userSystemPrompt" => null,
    "maxTokens" => 1024,
    "playgroundTopP" => null,
    "playgroundTemperature" => null,
    "isChromeExt" => false,
    "githubToken" => "",
    "clickedAnswer2" => false,
    "clickedAnswer3" => false,
    "clickedForceWebSearch" => false,
    "visitFromDelta" => false,
    "mobileClient" => false,
    "userSelectedModel" => null,
    "validated" => "00f37b34-a166-4efb-bce5-1312d87f2f94",
    "imageGenerationMode" => false,
    "webSearchModePrompt" => false,
    "deepSearchMode" => false
];

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);

if ($response === false) {
    echo json_encode([
        'error' => 'cURL Error: ' . curl_error($ch),
        'status' => 500
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    exit;
}

$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);

if ($http_code === 200) {
    if (preg_match('/!\[.*?\]\((https:\/\/storage\.googleapis\.com[^\)]+)\)/', $response, $matches)) {
        $result = [
            'image_url' => $matches[1],
            'status' => 200,
            'owner' => '@USERNAME'
        ];
    } else {
        $result = [
            'error' => 'No image URL found.',
            'status' => 404
        ];
    }
} else {
    $result = [
        'error' => 'Request failed with status code ' . $http_code,
        'status' => $http_code
    ];
}

echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

?>