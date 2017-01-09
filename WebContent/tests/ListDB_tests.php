<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Basic tests for ListsDB</title>
</head>
<body>
<h1>ListDB tests</h1>


<?php
include_once("../models/Configuration.class.php");
include_once("../models/Database.class.php");
include_once("../models/Messages.class.php");
include_once("../models/BucketList.class.php");
include_once("../models/ListDB.class.php");
include_once("../models/UserData.class.php");
include_once("../models/UserDataDB.class.php");
include_once("./DBMaker.class.php");
?>


<h2>It should get all users from a test database</h2>
<?php
DBMaker::create('ptest');
Database::clearDB();
$db = Database::getDB('ptest');
$lists = ListDB::getListsBy();
$listCount = count($lists);
echo "Number of lists in db is: $listCount <br>";
foreach ($lists as $list) 
	echo "$list <br>";
?>
</body>
</html>