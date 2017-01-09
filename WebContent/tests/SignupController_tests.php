<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Basic tests for Signup Controller</title>
</head>
<body>
<h1>Signup controller tests</h1>

<?php
include_once("../controllers/SignupController.class.php");
include_once("../models/Database.class.php");
include_once("../views/ProfileView.class.php");
include_once("../models/Configuration.class.php");
include_once("../models/Messages.class.php");
include_once("../views/SignupView.class.php");
include_once("../models/Database.class.php");
include_once("../models/UserDataDB.class.php");
include_once("../models/UserData.class.php");
include_once("../views/MasterView.class.php");
include_once("../controllers/ProfileController.class.php");
include_once("../models/UserData.class.php");
include_once("../views/ListView.class.php");
include_once("../controllers/ListController.class.php");
include_once("../models/Configuration.class.php");
include_once("../models/BucketList.class.php");
include_once("../models/ListDB.class.php");
include_once("../models/MovieData.class.php");
include_once("../models/MovieDataDB.class.php");
include_once("../views/MovieDataView.class.php");
include_once("../controllers/MovieDataController.class.php");
include_once("../models/Database.class.php");
include_once("../views/HomeView.class.php");
include_once("../models/Messages.class.php");
include_once("../models/UserData.class.php");
include_once("../models/UserDataDB.class.php");
include_once("../views/MasterView.class.php");
include_once("./DBMaker.class.php");
?>

<h2>It should call the run method for valid input during $POST</h2>
<?php 
$_SERVER ["REQUEST_METHOD"] = "POST";
$_POST = array("firstName" => "jarod", "lastName" => "wachter", "gender" => "male", "userName"=>"superman", "password" => "dfslkafj", 
				   "favoriteColor" => "#ff0000", "email" => "blah@blah.com", "phoneNumber" => "222-222-2222", "website"=>"https://www.mywebsite.com",
				   "birthday"=>"1900-01","spam"=>"true","file" => "../resources/racoon.jpeg");
SignupController::run();
?>

<h2>It should call show the Signup page for a $GET request</h2>
<?php 
$_SERVER ["REQUEST_METHOD"] = "GET";
SignupController::run();
?>
</body>
</html>
