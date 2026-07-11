<?php
// Test staff logout
$jarFile = tempnam(sys_get_temp_dir(), 'cookie');

// Login as staff
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => 'http://127.0.0.1:8000/login',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_COOKIEJAR => $jarFile,
]);
$html = curl_exec($ch);
preg_match('/name="_token"\s+value="([^"]+)"/', $html, $m);
curl_close($ch);

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => 'http://127.0.0.1:8000/login',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query([
        '_token' => $m[1],
        'email' => 'staff@otorent.com',
        'password' => 'password',
    ]),
    CURLOPT_COOKIEJAR => $jarFile,
    CURLOPT_COOKIEFILE => $jarFile,
    CURLOPT_FOLLOWLOCATION => true,
]);
$html = curl_exec($ch);
$url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
curl_close($ch);
echo "Login result: $url\n";

// Verify logged in
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => 'http://127.0.0.1:8000/admin',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_COOKIEFILE => $jarFile,
]);
$html = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
echo "Dashboard: $code\n";

// Load page to get fresh CSRF
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => 'http://127.0.0.1:8000/admin',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_COOKIEFILE => $jarFile,
]);
$html = curl_exec($ch);
preg_match('/name="_token"\s+value="([^"]+)"/', $html, $m2);
// Also find the form action
preg_match('/action="([^"]*logout[^"]*)"/', $html, $actionMatch);
curl_close($ch);
echo "CSRF token: " . substr($m2[1], 0, 10) . "...\n";
echo "Logout action: " . ($actionMatch[1] ?? 'NOT FOUND') . "\n";

// Logout
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => 'http://127.0.0.1:8000/logout',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query(['_token' => $m2[1]]),
    CURLOPT_COOKIEJAR => $jarFile,
    CURLOPT_COOKIEFILE => $jarFile,
    CURLOPT_FOLLOWLOCATION => false,
]);
$result = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
curl_close($ch);
echo "\nLogout: HTTP $code -> $url\n";

if ($code == 419) {
    echo "GOT 419! Checking response...\n";
    echo substr($result, 0, 500) . "\n";
}

unlink($jarFile);
