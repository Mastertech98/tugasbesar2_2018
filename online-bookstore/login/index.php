<?php
define('COOKIE_EXPIRY_TIME', 1800);

if (isset($_COOKIE['id'])) {
    header("Location: /search-books/");
    exit;
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        break;
    case 'POST':
        require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";

        $username = $mysqli->real_escape_string($_POST['username']);
        $password = $mysqli->real_escape_string($_POST['password']);

        $login_query = "SELECT id FROM user WHERE username = '$username' and password = '$password'";

        if (!$ids = $mysqli->query($login_query)) {
            echo "Failed to run query: (" . $mysqli->errno . ") " . $mysqli->error;
            exit;
        }

        if ($ids->num_rows === 0) {
            echo "Your Login Username or Password is invalid";
            exit;
        }

        $id = $ids->fetch_assoc();
        
        setcookie("id", $id['id'], time() + COOKIE_EXPIRY_TIME, "/");

        header("Location: /search-books/");
        exit;
    default:
        http_response_code(405);
        exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
</head>

<body>
    <main>
        <h1>Login</h1>
        <form method="post">
            <div class="input">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" />
            </div>
            <div class="input">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" />
            </div>
            <div class="hyperlink">
                <a href="/register/">Don't have an account?</a>
            </div>
            <div class="button">
                <button>Login</button>
            </div>
        </form>
    </main>
</body>

</html>