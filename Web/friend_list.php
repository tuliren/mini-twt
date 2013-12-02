<?php
    include "base.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mini-Twitter Four</title>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>
<div id="main">

<?php



if (!empty($_SESSION['loggedin'])) {
    
    $_SESSION['search_username'] = "";
    $user_id = (int) $_SESSION['user_id'];
    
    ?>
    <h1>Mini-Twitter Four</h1>
    <p><a href="main.php">My Tweets</a>&nbsp;
       <a href="profile.php">My Profile</a>&nbsp;
       <i>My Friends</i>&nbsp;
       <a href="friend_tweets.php">Friend Tweets</a>&nbsp;
       <a href="members.php">All Users</a>&nbsp;
       <a href="logout.php">Logout</a>
    </p>    
    <br />

    <?php
    $friend_attribute_query = mysql_query("SELECT username, friends FROM Users WHERE user_id= ".$user_id."");
    $friends = "";
    if ($row = mysql_fetch_assoc($friend_attribute_query)) {
        $friends = $row['friends'];
        $friend_list = explode(";", $friends);
    }
    $friend_count = 0;
    foreach($friend_list as $friend_id_string) {
        if (!empty($friend_id_string)) ++$friend_count;
    }
    
    if ($friend_count == 0) {
        echo "<p>You have not added any friend</p>";
    } else if ($friend_count == 1) {
        echo "<p>You have one friend</p>";
    } else {
        echo "<p>You have $friend_count friends</p>";
    }
    echo "<br />";
    
    // list all friends
    foreach ($friend_list as $friend_id_string) {
        $friend_id = (int) $friend_id_string;
        $friend_query = mysql_query("SELECT user_id, username, first_name, last_name, gender, email FROM Users WHERE user_id= ".$friend_id."");
        if ($row = mysql_fetch_assoc($friend_query)) {
            $friend_id = $row['user_id'];
            $friend_name = $row['username'];
            $friend_first_name = $row['first_name'];
            $friend_last_name = $row['last_name'];
            $friend_email = $row['email'];
            ?>
            <a href="friend_delete.php?user_id=<?php echo $user_id; ?>&friend_id=<?php echo $friend_id; ?>">Remove</a>
            <b><?php echo $friend_first_name; ?> <?php echo $friend_last_name; ?></b> (@<?php echo $friend_name; ?></b>)
            <?php echo $friend_email; ?>
            <br /><br />
            <?php
        }
    }
    
    if ($friend_count > 0) {
        ?>
        <a href="friend_delete.php?user_id=<?php echo $user_id; ?>&friend_id=all">Remove all</a>
        <br />
        <br />
        <?php
    }
    
} else {
    ?>

    <h1>Mini-Twitter Four</h1>
    <br />
    <p>You have not logged in yet. Please go to <a href="index.php">login</a>, or <a href="register.php">register</a> a new account.</p>
    <br />
    
    <?php
}
?>

</div>
</body>
</html>