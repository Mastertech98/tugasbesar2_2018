<?php
$mysqli = new mysqli("127.0.0.1:3307", "root", "", "online_bookstore");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
return $mysqli;