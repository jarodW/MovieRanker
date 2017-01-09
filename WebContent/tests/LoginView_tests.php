<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Basic tests for Login View</title>
</head>
<body>
<h1>Login view tests</h1>

<?php
include_once("../views/LoginView.class.php");
include_once("../models/UserData.class.php");
include_once("../views/MasterView.class.php");
include_once("../models/Messages.class.php");
?>

<h2>It should show when $user has an input</h2>
<?php 
$validTest = array("userName" => "jwachter",  "password" => "poprocks");
$s1 = new UserData($validTest);
$_SESSION = array('user' => $s1, 'base' => 'wj_lab3');
LoginView::show();
?>
</body>
</html>
