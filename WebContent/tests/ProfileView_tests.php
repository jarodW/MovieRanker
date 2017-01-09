<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Basic tests for Login View</title>
</head>
<body>
<h1>Profile view tests</h1>

<?php
include_once("../views/ProfileView.class.php");
include_once("../models/UserData.class.php");
include_once("../views/MasterView.class.php");
include_once("../models/Messages.class.php");
?>

<h2>It should call show when $user has an input</h2>
<?php 
$validTest = array("firstName" => "jarod", "lastName" => "wachter", "gender" => "male", "userName"=>"superman", "password" => "dfslkafj", 
				   "favoriteColor" => "#ff0000", "email" => "blah@blah.com", "phoneNumber" => "222-222-2222", "website"=>"https://www.mywebsite.com",
				   "birthday"=>"1900-01","file" => "../resources/racoon.jpeg");
$s1 = new UserData($validTest);
$_SESSION = array('user' => $s1, 'base' => 'wj_lab3');
ProfileView::show();
?>
</body>
</html>
