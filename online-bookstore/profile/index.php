<?php
if (!isset($_COOKIE['id'])) {
    header("Location: /login/");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    exit;
}

require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";

$id = $mysqli->real_escape_string($_COOKIE['id']);

$profile_query = "SELECT name, username, email, address, phone_number AS 'phone number' FROM user WHERE id = '$id'";

if (!$profiles = $mysqli->query($profile_query)) {
    echo "Failed to run query: (" . $mysqli->errno . ") " . $mysqli->error;
    exit;
}

$profile = $profiles->fetch_assoc();

$name = $profile['name'];
unset($profile['name']);

$profile_picture = glob("pictures/$id.*");
$profile_picture = $profile_picture ? $profile_picture[0] : "pictures/0.jpg";
?>

<!DOCTYPE html>
<html>

<head>
    <title>Profile</title>
</head>

<body>
    <main>
        <div class="profile-head">
            <div class="edit-profile"><img src="edit.png" /></div>
            <div class="profile-picture"><img src="/profile/<?= $profile_picture ?>" /></div>
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