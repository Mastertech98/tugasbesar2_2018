<?php // Logout function
    $access_token = $_COOKIE['access_token'];

    if (!$currentid = $mysqli->query("SELECT * FROM access_info WHERE token = $access_token")) {
        echo "Failed to run query: (" . $mysqli->errno . ") " . $mysqli->error;
        exit;
    }
    
    $currentid = $currentid->fetch_assoc();
    $currentid = $currentid['user_id'];

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