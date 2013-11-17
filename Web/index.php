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
if (!empty($_POST['username']) && !empty($_POST['password'])) {
    $username = mysql_real_escape_string($_POST['username']);
    // for encryption, use the following statement:
    // $password = md5(mysql_real_escape_string($_POST['password']));
    $password = mysql_real_escape_string($_POST['password']);
    $checklogin = mysql_query("SELECT * FROM users WHERE Username = '".$username."' AND Password = '".$password."'");

    if (mysql_num_rows($checklogin) == 1) {
        $row = mysql_fetch_array($checklogin);  
        $email = $row['email'];
        $password = $row['password'];
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $user_id = $row['user_id'];
        
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['loggedin'] = 1;
        $_SESSION['first_name'] = $first_name;
        $_SESSION['last_name'] = $last_name;
        $_SESSION['user_id'] = $user_id;
        $_SESSION['password'] = $password;
        
        echo "<h1>Mini-Twitter Four</h1>";
        echo "<br />";
        echo "<p>You have successfully logged in, and will be redirected to the member area.</p>";
        echo "<meta http-equiv='refresh' content='2;main.php' />";
    } else {
        echo "<h1>Mini-Twitter Four</h1>";
        echo "<br />";
        echo "<p>Incorrect username or password. Please <a href=\"index.php\">try again</a>, or <a href=\"register.php\">register</a> a new account.</p>";
    }
} else {
    ?>

    <h1>Mini-Twitter Four</h1>
    <br />
    <p>Please login below, or <a href="register.php">register</a> a new account.</p>
    <br>
    <form method="post" action="index.php" name="loginform" id="loginform">
    <fieldset>
        <label for="username">Username</label><input type="text" name="username" id="username" /><br />
        <label for="password">Password</label><input type="password" name="password" id="password" /><br />
        <br>
        <input type="submit" name="login" id="login" value="Login" />  
    </fieldset>
    </form>
    
    <?php
}
?>

</div>
</body>
</html>