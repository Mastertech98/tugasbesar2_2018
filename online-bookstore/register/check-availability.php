<?php
function is_available($attribute, $value) {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";
    global $mysqli;

    $sql = "SELECT id FROM `user` WHERE $attribute = '$value'";

    if (!$result = $mysqli->query($sql)) {
        echo "Failed to run query: (" . $mysqli->errno . ") " . $mysqli->error;
        exit;
    }

    return $result->num_rows === 0;
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";

        if (isset($_GET['username'])) {
            $is_available = is_available('username', $mysqli->real_escape_string($_GET['username']));
        }
        
        if (isset($_GET['email'])) {
            $is_available = is_available('email', $mysqli->real_escape_string($_GET['email']));
        }
        
        echo $is_available;
        
        http_response_code(isset($is_available) ? 200 : 400);
        break;
    default:
        http_response_code(405);
        break;
}