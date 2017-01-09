<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Basic tests for Profile Controller</title>
</head>
<body>
<h1>Profile controller tests</h1>

<?php
include_once("../controllers/ProfileController.class.php");
include_once("../models/UserData.class.php");
include_once("../views/ProfileView.class.php");
include_once("../models/Configuration.class.php");
include_once("../controllers/LoginController.class.php");
include_once("../models/User.class.php");
include_once("../models/Database.class.php");
include_once("../views/HomeView.class.php");
include_once("../views/LoginView.class.php");
include_once("../models/Messages.class.php");
include_once("../models/UserData.class.php");
include_once("../models/UserDataDB.class.php");
include_once("../views/MasterView.class.php");
include_once("./DBMaker.class.php");
?>

<h2>It should should show a review that exists</h2>
<?php
$myDb = DBMaker::create('ptest');
$_SERVER ["REQUEST_METHOD"] = "POST";
$_SESSION = array('base' => 'wj_lab3', 'control' => 'profile',
		'action' =>'show', 'arguments' => 1);
ProfileController::run();
?>

<h2>It should go to home when no review exists</h2>
<?php 
$myDb = DBMaker::create('ptest');
$_SERVER ["REQUEST_METHOD"] = "POST";
$_SESSION = array('base' => 'wj_lab3', 'control' => 'profile',
		'action' =>'show', 'arguments' => 3);
ProfileController::run();
?>


<h2>It should display a form for an update</h2>
<?php 
$myDb = DBMaker::create('ptest');
$_SERVER ["REQUEST_METHOD"] = "GET";
$_SESSION = array('base' => 'wj_lab3', 'control' => 'profile',
		'action' =>'update', 'arguments' => 1);
ProfileController::run();
?>


</body>
</html>
