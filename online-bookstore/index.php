<?php
if (isset($_COOKIE['access_token'])) {
    header("Location: /search-books/");
} else {
    header("Location: /login/");
}
exit;