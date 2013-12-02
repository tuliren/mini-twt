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
       <a href="friend_list.php">My Friends</a>&nbsp;
       <i>Friend Tweets</i>&nbsp;
       <a href="members.php">All Users</a>&nbsp;
       <a href="logout.php">Logout</a>
    </p>
    <br />
    <?php
    
    // get friend list
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
        ?>
        <p>You do not have any friend.</p><br />
        <?php
        return;
    }
    
    // list all friends
    $friend_tweet_query_string = "";
    foreach ($friend_list as $friend_id_string) {
        if (empty($friend_id_string)) break;
        $friend_id = (int) $friend_id_string;
        if (!empty($friend_tweet_query_string)) {
            $friend_tweet_query_string = $friend_tweet_query_string . "\nUNION";
        }
        $friend_tweet_query_string = $friend_tweet_query_string .
         "\n(SELECT tweet_date, tweet_text, username, first_name, last_name
          FROM Tweets JOIN Users
          ON Users.user_id = Tweets.Users_user_id
          WHERE Users_user_id=".$friend_id.")";
    }
    $friend_tweet_query_string = $friend_tweet_query_string . "\nORDER BY tweet_date DESC";
    
    $friend_tweets = mysql_query($friend_tweet_query_string);
    
    //var_dump($friend_list);
    //var_dump($friend_tweet_query_string);
    //var_dump($friend_tweets);
    
    // display tweets
    while($row = mysql_fetch_array($friend_tweets)){
        ?>
        <p><b><?php echo $row['first_name']; ?> <?php echo $row['last_name']; ?></b> (@<?php echo $row['username']; ?>)</p>
        <p><?php echo $row['tweet_date']; ?></p>
        <textarea disabled rows=2 cols=80><?php echo $row['tweet_text']; ?></textarea>
        <br /><br />     
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