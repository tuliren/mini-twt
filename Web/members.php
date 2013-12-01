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
    $user_id = (int) $_SESSION['user_id'];
    
    // display prev or next tweets    
    if (!empty($_POST['showusers'])) {
        switch ($_POST['showusers']) {
            case 'Prev':
                if ($_SESSION['username_offset'] - $user_limit >= 0) {
                    $_SESSION['username_offset'] = $_SESSION['username_offset'] - $user_limit;
                } else {
                    $_SESSION['username_offset'] = 0;
                }
            break;
            case 'Next':
                $new_user_offset = $_SESSION['username_offset'] + $user_limit;
                $usercount = mysql_query("SELECT user_id, username, first_name, last_name, gender FROM Users                                          
                                          ORDER BY username ASC
                                          LIMIT ".$user_limit."
                                          OFFSET ".$new_user_offset."");
                if (mysql_num_rows($usercount) > 0) {
                    $_SESSION['username_offset'] = $new_user_offset;
                }
            break;
            default:
            break;
        }
    }
    ?>    
    <h1>Mini-Twitter Four</h1>
    <p><a href="Main.php">My Page</a>&nbsp;
       <a href="profile.php">My Profile</a>&nbsp;
       All Users&nbsp;
       <a href="logout.php">Logout</a>
    </p>
    <br />
    <p>Search username</p>
    <br />
    <form method="post" action="members.php" name="searchuser" id="searchuser">
        <fieldset>            
            <input type="text" name="username" id="username" maxlength=<?php echo $maxlength_username; ?> placeholder="username"/>
            <input type="submit" name="search" id="search" value="Search" />
        </fieldset>
    </form>
    <br />
    <br />
    <p>Registered users</p>
    <br />
    <?php
    // display tweets
    $allusers = mysql_query("SELECT user_id, username, first_name, last_name, created_date FROM Users                                          
                           ORDER BY username ASC
                           LIMIT ".$user_limit."
                           OFFSET ".$_SESSION['username_offset']."");
    while($row = mysql_fetch_array($allusers)){
        $friend_id = $row['user_id'];
        $username = $row['username'];
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $created_date = date("M Y", strtotime($row['created_date']));
        
        ?>
        <a href="friend_add.php?user_id=<?php echo $user_id; ?>&friend_id=<?php echo $friend_id; ?>">Add to Friend</a>
        <b><?php echo $username; ?></b>, <?php echo $first_name; ?> <?php echo $last_name; ?>, joined since <?php echo $created_date; ?>
        <br /><br />
        <?php
    }
    ?>
    
    <form method="post" action="members.php" name="showtweets">
        <input type="submit" name="showusers" value="Prev">
        <input type="submit" name="showusers" value="Next">
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