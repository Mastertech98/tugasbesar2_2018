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

$id = $mysqli->query("SELECT * FROM access_info WHERE token = $access_token");
$id = $id->fetch_assoc();
$id = $id['user_id'];

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $profile_query = "SELECT name, address, phone_number, card FROM `user` WHERE id = '$id'";

        if (!$profiles = $mysqli->query($profile_query)) {
            echo "Failed to run query: (" . $mysqli->errno . ") " . $mysqli->error;
            exit;
        }

        $profile = $profiles->fetch_assoc();

        $profile_picture = glob($_SERVER['DOCUMENT_ROOT'] . "/profile/pictures/$id.*");
        $profile_picture = $profile_picture ? basename($profile_picture[0]) : "0.jpg";
        break;
    case 'POST':
        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . "/profile/pictures/";
        $upload_file = $id . '.' . pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);

        if ($_FILES['picture']['error'] === UPLOAD_ERR_OK) {
            array_map('unlink', glob($upload_dir . "$id.*"));
            move_uploaded_file($_FILES['picture']['tmp_name'], $upload_dir . $upload_file);
        }
        
        $name = $mysqli->real_escape_string($_POST['name']);
        $address = $mysqli->real_escape_string($_POST['address']);
        $phone_number = $mysqli->real_escape_string($_POST['phone_number']);
        $card_number = $mysqli->real_escape_string($_POST['card_number']);
        
        $card_response = file_get_contents('http://localhost:7000/card/check?cardNumber=' . $card_number);
        $card_res_obj = json_decode($card_response);
        if (!$card_res_obj->exist) {
			http_response_code(409);
			echo "Card is invalid";
			echo '<br/><button type="button" onclick="window.history.back()">Back</button>';
			exit;
		}

        $register_query = "UPDATE user SET name = '$name', address = '$address', phone_number = '$phone_number', card = $card_number WHERE id = '$id'";

        if (!$result = $mysqli->query($register_query)) {
            echo "Failed to run query: (" . $mysqli->errno . ") " . $mysqli->error;
            exit;
        }

        header("Location: /profile/");
        exit;
    default:
        http_response_code(405);
        exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Profile</title>
    <link rel="stylesheet" href ="/header.css" type="text/css"/>
    <link rel="stylesheet" href ="edit-profile.css" type="text/css"/>
</head>

<body class="profile">
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/header.php' ?>
    <main>
        <h1>Edit Profile</h1>
        <form method="post" enctype="multipart/form-data">
            <div class="inputimage">
                <img class ="profileimage" src="/profile/pictures/<?= $profile_picture ?>" />
                <div class="container">
                    <div class="updatetitle"> Update profile picture </div>   
                    <span class= "preview">No file selected</span>
                    <span><label class="updatebutton" for="picture">Browse...</label></span>
                    <input type="file" id="picture" name="picture" accept="image/*" />
                </div>
            </div>
            <div class="input">
                <label for="name">Name</label>
                <span>
                    <input type="text" id="name" name="name" value="<?= $profile['name'] ?>" /><br />
                    <span id="name-error"></span>
                </span>
            </div>
            <div class="inputaddress">
                <label for="address">Address</label>
                <span>
                    <textarea id="address" name="address"><?= $profile['address'] ?></textarea><br />
                    <span id="address-error"></span>
                </span>
            </div>
            <div class="input">
                <label for="phone-number">Phone Number</label>
                <span>
                    <input type="tel" id="phone-number" name="phone_number" value="<?= $profile['phone_number'] ?>" /><br />
                    <span id="phone-number-error"></span>
                </span>
            </div>
            <div class="input">
                <label for="card-number">Card Number</label>
                <span>
                    <input type="tel" id="card-number" name="card_number" value="<?= $profile['card'] ?>" /><br />
                    <span id="phone-number-error"></span>
                </span>
            </div>
            <div class="button">
                <button class="secondary" type="button" onclick="window.history.back()">Back</button>
                <button class="primary">Save</button>
            </div>
        </form>
    </main>
    <script src="validation.js" type="module"></script>
    <script src="preview-input.js"></script>
</body>

</html>