<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Basic tests for List Controller</title>
</head>
<body>
<h1>List Controller tests</h1>

<?php
include_once("../controllers/ProfileController.class.php");
include_once("../models/UserData.class.php");
include_once("../models/Configuration.class.php");
include_once("../views/ListView.class.php");
include_once("../controllers/ListController.class.php");
include_once("../models/BucketList.class.php");
include_once("../models/ListDB.class.php");
include_once("../models/Database.class.php");
include_once("../views/HomeView.class.php");
include_once("../models/Messages.class.php");
include_once("../models/UserData.class.php");
include_once("../models/UserDataDB.class.php");
include_once("../views/MasterView.class.php");
include_once("./DBMaker.class.php");
?>

<h2>It should should show the lists for a user</h2>
<?php
$myDb = DBMaker::create('ptest');
$_SERVER ["REQUEST_METHOD"] = "POST";
$_SESSION = array('base' => 'wj_lab3', 'control' => 'list',
		'action' =>'showUser', 'arguments' => 1);
ListController::run();
?>

<h2>It should go to home when no review exists</h2>
<?php
$myDb = DBMaker::create('ptest');
$_SERVER ["REQUEST_METHOD"] = "POST";
$_SESSION = array('base' => 'wj_lab3', 'control' => 'list',
		'action' =>'show', 'arguments' => 3);
ListController::run();
?>

<h2>It should display a form for an update</h2>

<?php
$myDb = DBMaker::create('ptest');
$_SERVER ["REQUEST_METHOD"] = "POST";
$_SESSION = array('base' => 'wj_lab3', 'control' => 'list',
		'action' =>'show', 'arguments' => 1);
ListController::run();
?>

</body>
</html>
