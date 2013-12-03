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
    <br />
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
        <h2>You have not added any friend</h2><br />
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
    
    // get all friend tweets
    $friend_tweet_query_string = $friend_tweet_query_string . "\nORDER BY tweet_date DESC";
    $all_friend_tweets = mysql_query($friend_tweet_query_string);
    $total_friend_tweet = mysql_num_rows($all_friend_tweets);
    
    // display prev or next tweets
    if (!empty($_POST['show_friend_tweets'])) {
        switch ($_POST['show_friend_tweets']) {
            case 'Newer':
                $_SESSION['friend_tweet_offset'] = max(0, $_SESSION['friend_tweet_offset']-$friend_tweet_limit);
            break;
            case 'Older':
                if ($_SESSION['friend_tweet_offset'] + $friend_tweet_limit < $total_friend_tweet) {
                    $_SESSION['friend_tweet_offset'] = $_SESSION['friend_tweet_offset'] + $friend_tweet_limit;
                }
            break;
            default:
            break;
        }
    }
    
    // get current friend tweets
    $friend_tweet_limited_str = $friend_tweet_query_string." LIMIT ".$friend_tweet_limit." OFFSET ".$_SESSION['friend_tweet_offset'];
    $friend_tweets = mysql_query($friend_tweet_limited_str);
    $curr_friend_tweet = mysql_num_rows($friend_tweets);
    
    $first_friend_tweet = $_SESSION['friend_tweet_offset'] + 1;
    $last_friend_tweet = min($_SESSION['friend_tweet_offset']+$curr_friend_tweet, $total_friend_tweet);
    
    if ($total_friend_tweet == 0) {
        echo "<h2>None of your friend has posted any tweet</h2>";
    } else if ($total_friend_tweet == 1) {
        echo "<h2>There is one tweet from your friend(s)</p></h2>";
    } else {
        if ($curr_friend_tweet == 1) {
            echo "<h2>Listing tweet $first_friend_tweet of all $total_friend_tweet tweets from your friend(s)</h2>";
        } else {
            echo "<h2>Listing tweet $first_friend_tweet - $last_friend_tweet of all $total_friend_tweet tweets from your friend(s)</h2>";
        }
    }
    
    // display tweets
    while($row = mysql_fetch_array($friend_tweets)){
        ?>
        <p><b><?php echo $row['first_name']; ?> <?php echo $row['last_name']; ?></b> (@<?php echo $row['username']; ?>)</p>
        <p><?php echo $row['tweet_date']; ?></p>
        <textarea disabled rows=2 cols=80><?php echo $row['tweet_text']; ?></textarea>
        <br /><br />     
        <?php    
    }
    
    ?>  
    <form method="post" action="friend_tweets.php" name="show_friend_tweets">
        <input type="submit" name="show_friend_tweets" value="Newer">
        <input type="submit" name="show_friend_tweets" value="Older">
    </form>
    
    <?php
    
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