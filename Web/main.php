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
if (!empty($_SESSION['loggedin']) && !empty($_SESSION['username'])) {
    ?>
    <h1>Mini-Twitter Four</h1>
    <p><a href="profile.php">Profile</a>&nbsp;<a href="logout.php">Logout</a></p>
    <br />
    <p>Welcome, <b><?=$_SESSION['first_name']?></b>.</p>    
    <br />

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