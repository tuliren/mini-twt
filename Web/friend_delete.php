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
    
    $user_id = (int) $_GET['user_id'];
    $friend_id = (int) $_GET['friend_id'];
    
    $new_friends = "";
    
    if ($friend_id != "all") {
        $user_to_add = mysql_query("SELECT username, friends FROM Users WHERE user_id= ".$user_id."");
        if ($row = mysql_fetch_assoc($user_to_add)) {
            $friends = $row['friends'];
            $friend_list = explode(";", $friends);
        }        

        foreach ($friend_list as $friend) {
            if ((int) $friend != $friend_id) {
                if (empty($new_friends)) $new_friends = $new_friends . $friend;
                else $new_friends = $new_friends . ";" . $friend;
            }
        }
    }

    $remove_friend = mysql_query("UPDATE Users SET friends = '".$new_friends."' WHERE user_id = ".$user_id."");
    
    if ($remove_friend) {
        ?>
        <h1>Mini-Twitter Four</h1>
        <br />
        <p>You have removed <?php echo ($friend_id == "all" ? "all friends" : "a friend") ?> <a href="friend_list.php">Go back</a>.</p>
        <br />
        <?php
    } else {
        ?>
        <h1>Mini-Twitter Four</h1>
        <br />
        <p>Removing friend failed. Please <a href="friend_list.php">go back</a> and try again.</p>
        <br />
        <?php
    }
?>