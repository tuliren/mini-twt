<?php
    /* References
     * login / registration: http://net.tutsplus.com/tutorials/php/user-membership-with-php/
     * tweet deletion:       http://webdesignpeeps.com/delete-records-from-mysql-database-using-php/
     *
     *
     * To use PHP variable in HTML, there are two ways:
     * <?php echo $variable; ?>
     * <?=$variable?>
     * To use the second shorter version, "short_open_tag" should be set to "on"
     *
     */
    
    session_start();
  
    $dbhost = "localhost";
    $dbname = "Twitter_Group_Four";
    $dbuser = "root";
    $dbpass = "group4";
    
    $maxlength_username = 15;
    $maxlength_first_name = 10;
    $maxlength_last_name = 10;
    $maxlength_password = 15;
    $minlength_password = 6;
    $maxlength_email = 50;    
    $maxlength_tweet = 140;
    
    $tweet_limit = 5;
    $user_limit = 10;
    $friend_tweet_limit = 5;
    
    $friend_limit = 20;
    
    mysql_connect($dbhost, $dbuser, $dbpass) or die("MySQL Error: " . mysql_error());  
    mysql_select_db($dbname) or die("MySQL Error: " . mysql_error());  
?>