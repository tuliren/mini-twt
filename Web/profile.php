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

if (!empty($_POST['password']) || !empty($_POST['first_name']) || !empty($_POST['last_name']) || !empty($_POST['gender']) || !empty($_POST['email'])) {
    // to use encryption, use the following statement
    // $password = md5(mysql_real_escape_string($_POST['password']));
    if (!empty($_POST['password'])) {
        $password = mysql_real_escape_string($_POST['password']);
    } else {
        $password = $_SESSION['password'];
    }
    if (!empty($_POST['email'])) {
        $email = mysql_real_escape_string($_POST['email']);
    } else {
        $email = $_SESSION['email'];
    }
    if (!empty($_POST['first_name'])) {
        $first_name = mysql_real_escape_string($_POST['first_name']);
    } else {
        $first_name = $_SESSION['first_name'];
    }
	if (!empty($_POST['gender'])) {
		$gender = mysql_real_escape_string($_POST['gender']);
	} else {
		$gender = $_SESSION['gender'];
	}
    if (!empty($_POST['last_name'])) {    
        $last_name = mysql_real_escape_string($_POST['last_name']);
    } else {
        $last_name = $_SESSION['last_name'];
    }
    $username = $_SESSION['username'];
    
    $checkemail = mysql_query("SELECT * FROM Users WHERE email = '".$email."'");
    
    if (!empty($_POST['email']) && $_POST['email'] != $_SESSION['email'] && mysql_num_rows($checkemail) > 0) {
        echo "<h1>Mini-Twitter Four</h1>";
        echo "<br />";
        echo "<p>Modification failed. This email has been taken. Please <a href=\"profile.php\">try another one</a>.</p>";
        echo "<br / >";
    } else {
        $modifyquery = mysql_query("UPDATE Users SET password='".$password."', first_name='".$first_name."', last_name='".$last_name."', gender='".$gender."', email='".$email."' WHERE username='".$username."'");
        if ($modifyquery) {
            echo "<h1>Mini-Twitter Four</h1>";
            echo "<br />";
            echo "<p>Modification succeeded.";
        } else {
            echo "<h1>Mini-Twitter Four</h1>";
            echo "<br />";
            echo "<p>Modification failed.";
        }
        echo "&nbsp;<a href=\"profile.php\">Go back</a>.</p>";
        
        // retrieve the new information
        $checklogin = mysql_query("SELECT * FROM Users WHERE Username = '".$username."' AND Password = '".$password."'");
        $row = mysql_fetch_array($checklogin);
        $email = $row['email'];
        $password = $row['password'];
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $gender = $row['gender'];		
        $user_id = $row['user_id'];
        $created_date = date("M Y", strtotime($row['created_date']));
        
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['loggedin'] = 1;
        $_SESSION['first_name'] = $first_name;
        $_SESSION['last_name'] = $last_name;
        $_SESSION['gender'] = $gender;		
        $_SESSION['user_id'] = $user_id;
        $_SESSION['password'] = $password;
        $_SESSION['created_date'] = $created_date;        
    }
    
    
} else if (!empty($_SESSION['loggedin']) && !empty($_SESSION['username'])) {
    ?>
    <h1>Mini-Twitter Four</h1>    
    <p><a href="main.php">Main page</a>&nbsp;<a href="logout.php">Logout</a></p>    
    <br />
    <p>Personal profile for <b><?php echo $_SESSION['username']; ?></b> (joined since <?php echo $_SESSION['created_date']; ?>)</p>
    <br />
    <form method="post" action="profile.php" name="modifyform" id="modifyform">  
    <fieldset>        
        <label for="first_name">First name</label><label><?php echo $_SESSION['first_name']; ?></label>
        <input type="text" name="first_name" id="first_name" maxlength=<?php echo $maxlength_first_name; ?> placeholder="new first name"/><br />
        
        <label for="last_name">Last name</label><label><?php echo $_SESSION['last_name']; ?></label>
        <input type="text" name="last_name" id="last_name" maxlength=<?php echo $maxlength_last_name; ?> placeholder="new last name"/><br />
        
        <label for="gender">Gender</label><label><?php echo $_SESSION['gender']; ?></label>
        <input type="text" name="gender" id="gender" maxlength=<?php echo $maxlength_gender; ?> placeholder="new gender"/><br />
                
        <label for="email">Email</label><label><?php echo $_SESSION['email']; ?></label>
        <input type="email" name="email" id="email" maxlength=<?php echo $maxlength_email; ?> placeholder="new email"/><br />
        
        <label for="password">Password</label><label>******</label>
        <input type="password" name="password" id="password" maxlength=<?php echo $maxlength_password; ?> placeholder="new password"/><br />
        
        <br />
        <input type="submit" name="modify" id="modify" value="Modify" />
        
    </fieldset>
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