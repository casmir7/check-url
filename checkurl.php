<?php
function checkSecurityWarning($url) {
    $headers = @get_headers($url);

    if ($headers === false) {
        return -1; // Couldn't fetch headers
    }

    // Look for suspicious HTTP status codes
    foreach ($headers as $header) {
        if (strpos($header, '403') !== false || strpos($header, '451') !== false) {
            return 1; // Possible restriction or censorship
        }
    }

    $pageContent = @file_get_contents($url);

    if ($pageContent === false) {
        return -1; // Couldn't fetch page content
    }

    // Common phrases in browser security warnings
    $warnings = [
        "Deceptive site ahead",
        "Attackers on",
        "Security risk",
        "Phishing site",
        "Malware warning"
    ];

    foreach ($warnings as $warning) {
        if (stripos($pageContent, $warning) !== false) {
            return 1; // Security issue detected
        }
    }

    return 0; // No issues found
}

function sendTelegramMessage($chat_id, $message) {
    $bot_token = getenv('TELEGRAM_BOT_TOKEN'); // Use environment variable for security
    if (!$bot_token) {
        return "Telegram bot token not set.";
    }

    $url = "https://api.telegram.org/bot$bot_token/sendMessage";

    $post_fields = [
        'chat_id' => $chat_id,
        'text' => $message
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

// 🔍 List of websites to scan
$websites = [
    "https://p.com/",
    "https://example.com/",
    "https://anotherwebsite.com/"
];

// 📢 Telegram group/chat to notify
$chat_id = "@checkmyurlout"; // Replace with your actual chat ID or username

foreach ($websites as $website) {
    $result = checkSecurityWarning($website);

    if ($result === 1) {
        sendTelegramMessage($chat_id, "⚠️ Security Warning Detected on $website!");
    } elseif ($result === 0) {
        sendTelegramMessage($chat_id, "✅ $website appears safe.");
    } else {
        sendTelegramMessage($chat_id, "❌ Error checking $website.");
    }
}
?>
