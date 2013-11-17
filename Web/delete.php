<?php
    include('base.php');
    
    $id = (int) $_GET['tweet_id'];
    $tweetdelete = mysql_query("DELETE FROM tweets WHERE tweet_id= ".$id."");
     
    // if the above query execute without a glitch, then we’ll redirect the user to the / // previous page
    if ($tweetdelete) {
        $user_id = $_SESSION['user_id'];
        // these code can be simplified by using a $_SESSION['tweet_count'] to track the number of tweets
        $tweetcount = mysql_query("SELECT tweet_date, tweet_text FROM tweets
                                   WHERE Users_user_id=".$user_id."
                                   ORDER BY tweet_date DESC
                                   LIMIT ".$tweet_limit."
                                   OFFSET ".$_SESSION['user_tweet_offset']."");
        $count = mysql_num_rows($tweetcount);
        if ($count == 0) {
            if ($_SESSION['user_tweet_offset'] - $tweet_limit >= 0) {
                $_SESSION['user_tweet_offset'] = $_SESSION['user_tweet_offset'] - $tweet_limit;
            } else {
                $_SESSION['user_tweet_offset'] = 0;
            }
        }
        echo "<meta http-equiv='refresh' content='0;main.php' />";
        
    }else {
        echo "<h1>Mini-Twitter Four</h1>";
        echo "<br />";
        echo "<p>Tweet deletion failed. Please <a href=\"main.php\">try again</a>.</p>";
    }
?>