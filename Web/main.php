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

$_SESSION['search_username'] = "";

if (!empty($_SESSION['loggedin']) && !empty($_POST['tweet'])) { 
    $user_id = (int) $_SESSION['user_id'];
    
    // post new tweets
    $tweet_text = mysql_real_escape_string($_POST['new_tweet']);
    //var_dump($user_id);
    //var_dump($tweet_text);
    $newtweet = mysql_query("INSERT INTO Tweets (Users_user_id, tweet_text) VALUES(".$user_id.", '".$tweet_text."')");  
        if ($newtweet) {
            $_SESSION['user_tweet_offset'] = 0;
            echo "<meta http-equiv='refresh' content='0;main.php' />";
        } else {
            echo "<h1>Mini-Twitter Four</h1>";
            echo "<br />";
            echo "<p>Tweet failed. Please <a href=\"main.php\">try again</a>.</p>";
        }
        
} else if (!empty($_SESSION['loggedin']) && empty($_POST['tweet'])) {
    $user_id = (int) $_SESSION['user_id'];
    
    // display prev or next tweets    
    if (!empty($_POST['showtweets'])) {        
        switch ($_POST['showtweets']) {
            case 'Newer':
                if ($_SESSION['user_tweet_offset'] - $tweet_limit >= 0) {
                    $_SESSION['user_tweet_offset'] = $_SESSION['user_tweet_offset'] - $tweet_limit;
                } else {
                    $_SESSION['user_tweet_offset'] = 0;
                }                
            break;
            case 'Older':
                $new_offset = $_SESSION['user_tweet_offset'] + $tweet_limit;
                $tweetcount = mysql_query("SELECT tweet_date, tweet_text FROM Tweets
                                           WHERE Users_user_id=".$user_id."
                                           ORDER BY tweet_date DESC
                                           LIMIT ".$tweet_limit."
                                           OFFSET ".$new_offset."");
                if (mysql_num_rows($tweetcount) > 0) {
                    $_SESSION['user_tweet_offset'] = $new_offset;
                }
            break;
            default:
            break;
        }
    }
    ?>    
    <h1>Mini-Twitter Four</h1>
    
    <p><i>My Tweets</i>&nbsp;
       <a href="profile.php">My Profile</a>&nbsp;
       <a href="friend_list.php">My Friends</a>&nbsp;
       <a href="friend_tweets.php">Friend Tweets</a>&nbsp;
       <a href="members.php">All Users</a>&nbsp;
       <a href="logout.php">Logout</a>
    </p>
    <br />
    <h2>Welcome, <?php echo $_SESSION['first_name']; ?></h2>    
    
    <br />
    <form method="post" action="main.php" name="tweetform" id="tweetform">
        <fieldset>
            <h2>Write a new tweet</h2>
            <textarea name="new_tweet" id="new_tweet" maxlength=<?php echo $maxlength_tweet; ?> rows=3 cols=80 placeholder="max 140 characters" required></textarea>
            <br />
            <input type="submit" name="tweet" id="tweet" value="Tweet" />
        </fieldset>
    </form>
    <br />
    <?php
    
    $all_tweets = mysql_query("SELECT tweet_id, tweet_date, tweet_text FROM Tweets
                               WHERE Users_user_id=".$user_id."");
    
    $tweets = mysql_query("SELECT tweet_id, tweet_date, tweet_text FROM Tweets
                           WHERE Users_user_id=".$user_id."
                           ORDER BY tweet_date DESC
                           LIMIT ".$tweet_limit."
                           OFFSET ".$_SESSION['user_tweet_offset']."");
    
    $total_tweet_count = mysql_num_rows($all_tweets);
    $current_tweet_count = mysql_num_rows($tweets);
    $first_tweet_count = $_SESSION['user_tweet_offset'] + 1;
    $last_tweet_count = $_SESSION['user_tweet_offset'] + $current_tweet_count;
    $search_string = $_SESSION['search_username'];    
    if ($total_tweet_count == 0) {
        echo "<h2>No tweet has been posted</h2>";
    } else if ($total_tweet_count == 1) {
        echo "<h2>Listing the only posted tweet</p></h2>";
    } else {
        if ($current_tweet_count == 1) {
            echo "<h2>Listing tweet $first_tweet_count of all $total_tweet_count tweets</h2>";
        } else {
            echo "<h2>Listing tweet $first_tweet_count - $last_tweet_count of all $total_tweet_count tweets</h2>";
        }
    }
    
    
    // display tweets
    
    while($row = mysql_fetch_array($tweets)){
        $tweet_id = (int) $row['tweet_id'];
        ?>
        <form method="post" action="main.php" name="tweet" id="tweet">
        <fieldset>
            <label><?php echo $row['tweet_date']; ?></label>&nbsp;<a href="delete.php?tweet_id=<?php echo $tweet_id; ?>">Delete</a>
            <br />
            <textarea disabled rows=2 cols=80><?php echo $row['tweet_text']; ?></textarea>
            <br /><br />
        </fieldset>
        </form>    
        <?php
    }
    
    ?>    
    <form method="post" action="main.php" name="showtweets">
        <input type="submit" name="showtweets" value="Newer">
        <input type="submit" name="showtweets" value="Older">
    </form>    
    <?php
    
} else {
    ?>

    <h1>Mini-Twitter Four</h1>
    <br />
    <p>You have not logged in yet. Please go to <a href="index.php">login</a>, or <a href="register.php">register</a> a new account.</p>
    <br>
    
    <?php
}
?>

</div>
</body>
</html>