<?php
$mysqli = new mysqli("localhost", "root", "", "online_bookstore");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
return $mysqli;