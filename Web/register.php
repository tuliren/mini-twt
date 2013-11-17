<?php
    include "base.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">  
<html xmlns="http://www.w3.org/1999/xhtml">    
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />    

<title>User Management System (Tom Cameron for NetTuts)</title>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>
<div id="main">

<?php
if (!empty($_POST['username']) &&
    !empty($_POST['password']) &&
    !empty($_POST['first_name'])&&
    !empty($_POST['last_name']) &&
    !empty($_POST['email'])) {
    $username = mysql_real_escape_string($_POST['username']);
    // to use encryption, use the following statement
    // $password = md5(mysql_real_escape_string($_POST['password']));
    $password = mysql_real_escape_string($_POST['password']);
    $email = mysql_real_escape_string($_POST['email']);
    $first_name = mysql_real_escape_string($_POST['first_name']);
    $last_name = mysql_real_escape_string($_POST['last_name']);
    
    $checkusername = mysql_query("SELECT * FROM users WHERE username = '".$username."'");
    $checkemail = mysql_query("SELECT * FROM users WHERE email = '".$email."'");

    if (mysql_num_rows($checkusername) > 0) {
        echo "<h1>Mini-Twitter Four</h1>";
        echo "<br />";
        echo "<p>Registration failed. This username has been taken. Please <a href=\"register.php\">try again</a>.</p>";
        echo "<br / >";
    } else if (mysql_num_rows($checkemail) > 0) {
        echo "<h1>Mini-Twitter Four</h1>";
        echo "<br />";
        echo "<p>Registration failed. This email has been taken. Please <a href=\"register.php\">try again</a>.</p>";
        echo "<br / >";
    } else {
        $registerquery = mysql_query("INSERT INTO users (username, password, first_name, last_name, email) VALUES('".$username."', '".$password."', '".$first_name."', '".$last_name."','".$email."')");  
        if ($registerquery) {
            echo "<h1>Mini-Twitter Four</h1>";
            echo "<br />";
            echo "<p>Registration succeeded. Please <a href=\"index.php\">go back</a> to login.</p>";  
        } else {
            echo "<h1>Mini-Twitter Four</h1>";
            echo "<br />";
            echo "<p>Registration failed. Please <a href=\"register.php\">try again</a>.</p>";
        }
    }
} else {
    ?>

    <h1>Mini-Twitter Four</h1>
    <br />
    <p>Please complete the following to register, or go back to <a href="index.php">login</a>.</p>
    <br />
    <form method="post" action="register.php" name="registerform" id="registerform">  
    <fieldset>
        <label for="first_name">First name</label><input type="text" name="first_name" id="first_name" /><br />
        <label for="last_name">Last name</label><input type="text" name="last_name" id="last_name" /><br />
        <label for="username">Username</label><input type="text" name="username" id="username" /><br />
        <label for="password">Password</label><input type="password" name="password" id="password" /><br />
        <label for="email">Email</label><input type="text" name="email" id="email" /><br />
        <br />
        <input type="submit" name="register" id="register" value="Register" />  
    </fieldset>
    </form>

    <?php
}
?>

</div>
</body>
</html>


