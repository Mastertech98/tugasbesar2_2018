<?php // Logout function
    require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";
    $access_token = $_COOKIE['access_token'];
    $currentid = $mysqli->query("SELECT id FROM user WHERE access_token = '$access_token'");
    $currentid = $currentid->fetch_assoc();
    $currentid = $currentid['id'];
    $query = $mysqli->query("SELECT username FROM user WHERE id = '$currentid'");
    $result = $query->fetch_assoc();
?>
<header class="top-menu">
    <div class="container-top-bar">
        <span class="pro logo">Pro</span>
        <span class="book logo">-Book</span>
        <a class="logout" href="/logout.php"><img src="/powerlogo.png" /></a>
        <a class="greetings" href="/profile/">Hi, <?= $result['username'] ?></a>
    </div>
    <nav>
        <a class="browse" href="/search-books/">Browse</a>
        <a class="history" href="/history/">History</a>
        <a class="profile" href="/Profile/">Profile</a>
    </nav>
</header>