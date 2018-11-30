<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";
require_once $_SERVER['DOCUMENT_ROOT'] . '/at-config.php';

//If user is logged in, redirect to search-books page
if (isset($_COOKIE['access_token'])) {
    $access_token = $_COOKIE['access_token'];
    if (getAccessToken($access_token, $mysqli)->num_rows != 0) {
        header("Location: /search-books/");
        exit;
    }
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
		$card_number = $mysqli->real_escape_string($_POST['card_number']);

		//Error if username or email is already exists
		if (!is_available("username", $username) || !is_available("email", $email)) {
			http_response_code(409);
			echo "User or email already exists!";
            echo '<br/><button type="button" onclick="window.history.back()">Back</button>';
			exit;
		}
		
		// Error if card does not exist
		$card_response = file_get_contents('http://localhost:7000/card/check?cardNumber=' . $card_number);
		$card_res_obj = json_decode($card_response);
		if (!$card_res_obj->exist) {
			http_response_code(409);
			echo "Card is invalid";
			echo '<br/><button type="button" onclick="window.history.back()">Back</button>';
			exit;
		}
		
		//Register insert user data into the database
		$register_query = "INSERT INTO user (name, username, email, password, address, phone_number, card) VALUES ('$name', '$username', '$email', '$password', '$address', '$phone_number', $card_number)";

		if (!$result = $mysqli->query($register_query)) {
			echo "Failed to run query: (" . $mysqli->errno . ") " . $mysqli->error;
			exit;
		}
		
		//Login
		$login_query = "SELECT id FROM `user` WHERE username = '$username' and password = '$password'";

        if (!$ids = $mysqli->query($login_query)) {
            echo "Failed to run query: (" . $mysqli->errno . ") " . $mysqli->error;
            exit;
        }

        $id = $ids->fetch_assoc();
        
        $id = $id['id'];
        $access_token = generateAccessToken();
        $user_browser = getUserBrowser();
        $user_ip = getUserIP();
        $expiry_time = generateExpiryTime();
        
        // $update_access_token_query = "UPDATE `user` SET access_token = '$access_token' WHERE id = '$id'";
        $insert_access_token_query = "INSERT INTO access_info (token, user_id, user_browser, user_ip, expiry_time) VALUES ($access_token, $id, '$user_browser', '$user_ip', '$expiry_time')";
        
        while (!$mysqli->query($insert_access_token_query)) {
            $access_token = generateAccessToken();
		}
		
		setcookie("access_token", $access_token, time() + COOKIE_EXPIRY_TIME, "/");
		
		//Redirect to search-books page
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
	<title>Register</title>
	<link rel="stylesheet" href="./register.css" type="text/css" />
</head>

<body>
	<main>
		<h1>Register</h1>
		<form method="post">
			<div class="input">
				<label for="name">Name</label>
				<span>
					<input type="text" id="name" name="name" /><br />
					<span id="name-error"></span>
				</span>
			</div>
			<div class="input">
				<label for="username">Username</label>
				<span>
					<input type="text" id="username" name="username" />
					<span id="username-error"></span>
				</span>
				<img class="availability" id="available-username" src="available.png" alt="availability" /><br />
			</div>
			<div class="input">
				<label for="email">Email</label>
				<span>
					<input type="email" id="email" name="email" /><br />
					<span id="email-error"></span>
				</span>
				<img class="availability" id="available-email" src="available.png" alt="availability" />
			</div>
			<div class="input">
				<label for="password">Password</label>
				<span>
					<input type="password" id="password" name="password" /><br />
					<span id="password-error"></span>
				</span>
			</div>
			<div class="input">
				<label for="confirm-password">Confirm Password</label>
				<span>
					<input type="password" id="confirm-password" name="confirm_password" /><br />
					<span id="confirm-password-error"></span>
				</span>
			</div>
			<div class="input">
				<label for="address">Address</label>
				<span>
					<textarea id="address" name="address" rows="3"></textarea><br />
					<span id="address-error"></span>
				</span>
			</div>
			<div class="input">
				<label for="phone-number">Phone Number</label>
				<span>
					<input type="tel" id="phone-number" name="phone_number" /><br />
					<span id="phone-number-error"></span>
				</span>
			</div>
			<div class="input">
				<label for="card-number">Card Number</label>
				<span>
					<input type="tel" id="card-number" name="card_number" /><br />
					<span id="card-number-error"></span>
				</span>
			</div>
			<div class="hyperlink">
				<a href="/login/">Already have an account?</a>
			</div>
			<div class="button">
				<button>Register</button>
			</div>
		</form>
	</main>
	<script src="availability-validation.js"></script>
	<script src="validation.js" type="module"></script>
</body>

</html>