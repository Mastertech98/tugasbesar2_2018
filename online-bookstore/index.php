<?php
if (isset($_COOKIE['id'])) {
    header("Location: /search-books/");
} else {
    header("Location: /login/");
}
exit;