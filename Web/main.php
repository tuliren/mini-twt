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
    <p>My Page&nbsp;
       <a href="profile.php">My Profile</a>&nbsp;
       <a href="members.php">All Users</a>&nbsp;
       <a href="logout.php">Logout</a>
    </p>
    <br />
    <p>Welcome, <b><?php echo $_SESSION['first_name']; ?></b>.</p>    
    
    <br />
    <form method="post" action="main.php" name="tweetform" id="tweetform">
        <fieldset>
            <label for="new_tweet_label">Write a new tweet</label><br />
            <textarea name="new_tweet" id="new_tweet" maxlength=<?php echo $maxlength_tweet; ?> style="resize: none;" rows=5 cols=80 placeholder="max 140 characters" required></textarea>
            <br />
            <input type="submit" name="tweet" id="tweet" value="Tweet" />
        </fieldset>
    </form>
    <br />
    <br />
    <form method="post" action="main.php" name="showtweets">
        <input type="submit" name="showtweets" value="Newer">
        <input type="submit" name="showtweets" value="Older">
    </form>
    
    <?php
    // display tweets
    $tweets = mysql_query("SELECT tweet_id, tweet_date, tweet_text FROM Tweets
                           WHERE Users_user_id=".$user_id."
                           ORDER BY tweet_date DESC
                           LIMIT ".$tweet_limit."
                           OFFSET ".$_SESSION['user_tweet_offset']."");
    while($row = mysql_fetch_array($tweets)){
        $tweet_id = (int) $row['tweet_id'];
        ?>
        <form method="post" action="main.php" name="tweet" id="tweet">
        <fieldset>
            <label><?php echo $row['tweet_date']; ?></label>&nbsp;<a href="delete.php?tweet_id=<?php echo $tweet_id; ?>">Delete</a>
            <br />
            <textarea name="tweet" id="tweet" disabled rows=2 cols=80 align=left style="resize: none;"><?php echo $row['tweet_text']; ?></textarea>
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