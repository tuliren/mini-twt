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
    
    if ($user_id == $friend_id) {
        ?>
        <h1>Mini-Twitter Four</h1>
        <br />
        <p>You cannot add yourself as a friend. <a href="members.php">Go back</a>.</p>
        <?php
        return;
    }
    
    $user_to_add = mysql_query("SELECT username, friends FROM Users WHERE user_id= ".$user_id."");
    if ($row = mysql_fetch_assoc($user_to_add)) {
        $friends = $row['friends'];
        $friend_list = explode(";", $friends);
    }
    $friend_count = count($friend_list);

    if ($friend_count >= $friend_limit) {
        echo "<h1>Mini-Twitter Four</h1>";
        echo "<br />";
        echo "<p>You have friended $friend_limit users and cannot add more friends. <a href=\"members.php\">Go back</a>.</p>";
    } else {
        $friend_already = false;
        foreach ($friend_list as $friend) {
            if ((int) $friend == $friend_id) {
                $friend_already = true;
                break;
            }
        }
        if ($friend_already) {
            ?>
            <h1>Mini-Twitter Four</h1>
            <br />
            <p>This user is already your friend. <a href="members.php">Go back</a>.</p>
            <br />
            <?php
        } else {
            if (!empty($friends)) $friends = $friends . ";";
            $friends = $friends . $_GET['friend_id'];
            $add_new_friend = mysql_query("UPDATE Users SET friends = '".$friends."' WHERE user_id = ".$user_id."");
            if ($add_new_friend) {
                ?>
                <h1>Mini-Twitter Four</h1>
                <br />
                <p>You have a new friend. <a href="members.php">Go back</a>.</p>
                <br />
                <?php
            } else {
                ?>
                <h1>Mini-Twitter Four</h1>
                <br />
                <p>Adding friend failed. Please <a href="members.php">go back</a> and try again.</p>
                <br />
                <?php
            }
        }        
    }
?>