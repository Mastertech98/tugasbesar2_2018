<?php
define('COOKIE_EXPIRY_TIME', 2000);

function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {               // check ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   // to check ip is pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    return $ip;
}

function getUserBrowser() {
    return $_SERVER['HTTP_USER_AGENT'];
}

date_default_timezone_set("Asia/Jakarta");

function getCurrentTime() {
    return date("Y-m-d H:i:s");
}

function generateExpiryTime() {
    return date("Y-m-d H:i:s", strtotime("+30 minutes"));
}

function generateAccessToken() {
    return rand(1, 10000000);
}

function getAccessToken($access_token, $mysqli) {
    if (!$del_result = $mysqli->query("DELETE FROM access_info WHERE NOW() > expiry_time")) {
        echo "Failed to run query: (" . $mysqli->errno . ") " . $mysqli->error;
        exit;
    }
    
    $user_browser = getUserBrowser();
    $user_ip = getUserIP();

    if (!$result = $mysqli->query("SELECT * FROM access_info WHERE user_browser = '$user_browser' AND user_ip = '$user_ip' AND token = $access_token")) {
        echo "Failed to run query: (" . $mysqli->errno . ") " . $mysqli->error;
        exit;
    }
    
    return $result;
}

function deleteAccessToken($access_token) {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";
    
    if (!$del_result = $mysqli->query("DELETE FROM access_info WHERE token = $access_token")) {
        echo "Failed to run query: (" . $mysqli->errno . ") " . $mysqli->error;
        exit;
    }
}
