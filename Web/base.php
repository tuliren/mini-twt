<?php  
    session_start();
  
    $dbhost = "localhost";           // this will ususally be 'localhost', but can sometimes differ  
    $dbname = "twitter_group_four";  // the name of the database that you are going to use for this project  
    $dbuser = "root";                // the username that you created, or were given, to access your database  
    $dbpass = "root";                // the password that you created, or were given, to access your database  
    
    $maxlength_username = 10;
    $maxlength_first_name = 10;
    $maxlength_last_name = 10;
    $maxlength_password = 10;
    $maxlength_email = 50;    
    $maxlength_tweet = 140;
    
    mysql_connect($dbhost, $dbuser, $dbpass) or die("MySQL Error: " . mysql_error());  
    mysql_select_db($dbname) or die("MySQL Error: " . mysql_error());  
?>