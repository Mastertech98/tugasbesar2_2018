<?php
if (isset($_COOKIE['id'])) {
    header("Location: /search-books/");
    exit;
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        break;
    case 'POST':
        require_once $_SERVER['DOCUMENT_ROOT'] . "/register/check-availability.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";

        $name = $mysqli->real_escape_string($_POST['name']);
        $username = $mysqli->real_escape_string($_POST['username']);
        $email = $mysqli->real_escape_string($_POST['email']);
        $password = $mysqli->real_escape_string($_POST['password']);
        $address = $mysqli->real_escape_string($_POST['address']);
        $phone_number = $mysqli->real_escape_string($_POST['phone_number']);

        if (!is_available("username", $username) || !is_available("email", $email)) {
            http_response_code(409);
            exit;
        }
        
        $register_query = "INSERT INTO user (name, username, email, password, address, phone_number) VALUES ('$name', '$username', '$email', '$password', '$address', '$phone_number')";

        if (!$result = $mysqli->query($register_query)) {
            echo "Failed to run query: (" . $mysqli->errno . ") " . $mysqli->error;
            exit;
        }

        http_response_code(201);
        echo "User successfully registered!";

        exit;
    default:
        http_response_code(405);
        exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
</head>

<body>
    <main>
        <h1>Register</h1>
        <form method="post">
            <div class="input">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" />
            </div>
            <div class="input">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" />
                <img src="available.png" alt="availability" />
            </div>
            <div class="input">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" />
                <img src="available.png" alt="availability" />
            </div>
            <div class="input">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" />
            </div>
            <div class="input">
                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" name="confirm_password" />
            </div>
            <div class="input">
                <label for="address">Address</label>
                <textarea id="address" name="address"></textarea>
            </div>
            <div class="input">
                <label for="phone-number">Phone Number</label>
                <input type="tel" id="phone-number" name="phone_number" />
            </div>
            <div class="hyperlink">
                <a href="/login/">Already have an account?</a>
            </div>
            <div class="button">
                <button>Register</button>
            </div>
        </form>
        <script src="availability-validation.js"></script>
    </main>
</body>

</html>