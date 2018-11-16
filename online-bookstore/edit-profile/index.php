<?php
if (!isset($_COOKIE['id'])) {
    header("Location: /login/");
    exit;
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";

        $id = $mysqli->real_escape_string($_COOKIE['id']);

        $profile_query = "SELECT name, address, phone_number FROM user WHERE id = '$id'";

        if (!$profiles = $mysqli->query($profile_query)) {
            echo "Failed to run query: (" . $mysqli->errno . ") " . $mysqli->error;
            exit;
        }

        $profile = $profiles->fetch_assoc();

        break;
    case 'POST':
        require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";

        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . "/profile/pictures/";
        $upload_file = $_COOKIE['id'] . '.' . pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);

        if ($_FILES['picture']['error'] === UPLOAD_ERR_OK) {
            array_map('unlink', glob($upload_dir . "$id.*"));
            move_uploaded_file($_FILES['picture']['tmp_name'], $upload_dir . $upload_file);
        }
        
        $name = $mysqli->real_escape_string($_POST['name']);
        $address = $mysqli->real_escape_string($_POST['address']);
        $phone_number = $mysqli->real_escape_string($_POST['phone_number']);
        
        $register_query = "UPDATE user SET name = '$name', address = '$address', phone_number = '$phone_number'";

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
</head>

<body>
    <main>
        <h1>Edit Profile</h1>
        <form method="post" enctype="multipart/form-data">
            <div class="input">
                <img src="<?= $profile['picture'] ?>" />
                <label for="picture">Update profile picture</label>
                <input type="file" id="picture" name="picture" accept="image/*" />
            </div>
            <div class="input">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="<?= $profile['name'] ?>" />
            </div>
            <div class="input">
                <label for="address">Address</label>
                <textarea id="address" name="address"><?= $profile['address'] ?></textarea>
            </div>
            <div class="input">
                <label for="phone-number">Phone Number</label>
                <input type="tel" id="phone-number" name="phone_number" value="<?= $profile['phone_number'] ?>" />
            </div>
            <div class="button">
                <button class="secondary" type="button">Back</button>
                <button class="primary">Save</button>
            </div>
        </form>
        <script src="availability-validation.js"></script>
    </main>
</body>

</html>