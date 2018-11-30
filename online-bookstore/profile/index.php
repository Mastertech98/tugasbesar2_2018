<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/at-config.php';

if (!isset($_COOKIE['access_token'])) {
    header("Location: /login/");
    exit;
}

$access_token = $_COOKIE['access_token'];
if (getAccessToken($access_token, $mysqli)->num_rows == 0) {
    header("Location: /login/");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    exit;
}

$id = $mysqli->query("SELECT * FROM access_info WHERE token = '$access_token'");
$id = $id->fetch_assoc();
$id = $id['user_id'];

$profile_query = "SELECT name, username, email, address, phone_number AS 'phone number', card AS 'card number' FROM `user` WHERE id = '$id'";

if (!$profiles = $mysqli->query($profile_query)) {
    echo "Failed to run query: (" . $mysqli->errno . ") " . $mysqli->error;
    exit;
}

$profile = $profiles->fetch_assoc();

$name = $profile['name'];
unset($profile['name']);

$profile_picture = glob($_SERVER['DOCUMENT_ROOT'] . "/profile/pictures/$id.*");
$profile_picture = $profile_picture ? basename($profile_picture[0]) : "0.jpg";
?>

<!DOCTYPE html>
<html>

<head>
    <title>Profile</title>
    <link rel="stylesheet" href ="/header.css" type="text/css"/>
    <link rel="stylesheet" href="/profile/profile.css" type="text/css" />
</head>

<body class="profile">
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/header.php' ?>
    <main>    
        <div class="profile-head">
            <div class="edit-profile"><a href="/edit-profile/"><img src="/profile/edit-icon.png" /></a></div>
            <div class="profile-picture"><img src="/profile/pictures/<?= $profile_picture ?>" /></div>
            <div class="profile-name"><?= $name ?></div>
        </div>
        <div class="profile-body">
            <h1>My Profile</h1>
            <?php foreach ($profile as $key => $value) { ?>
            <div class="profile-element">
                <span class="profile-icon"><img src="<?= $key ?>.png" /></span>
                <span class="profile-label"><?= ucwords($key) ?></span>
                <span class="profile-value"><?= $value ?></span>
            </div>
            <?php } ?>
        </div>
    </main>
</body>

</html>