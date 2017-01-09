<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Basic tests for UsersDB</title>
</head>
<body>
<h1>UsersDB tests</h1>


<?php
include_once("../models/Configuration.class.php");
include_once("../models/Database.class.php");
include_once("../models/Messages.class.php");
include_once("../models/UserData.class.php");
include_once("../models/UserDataDB.class.php");
include_once("./DBMaker.class.php");
?>


<h2>It should get all users from a test database</h2>
<?php
DBMaker::create('ptest');
Database::clearDB();
$db = Database::getDB('ptest');
$users = UserDataDB::getUsersBy();
$userCount = count($users);
echo "Number of users in db is: $userCount <br>";
foreach ($users as $user) 
	echo "$user <br>";
?>	

<h2>It should allow a user to be added</h2>
<?php 
DBMaker::create('ptest');
Database::clearDB();
$db = Database::getDB('ptest');
echo "Number of users in db before added is: ". count(UserDataDB::getUsersBy()) ."<br>";
$validTest = array('userName' => 'joan', 'password' => 'superman', 'firstName'=>'bob', 'lastName'=>'smith', 'gender'=>'male', 'birthday'=>'2015-10', 'email'=>'a@a.com', 'phoneNumber'=>'555-555-5555');
$user = new UserData($validTest);
$newUser = UserDataDB::addUser($user);
echo "Number of users in db after added is: ". count(UserDataDB::getUsersBy()) ."<br>";
echo "The new user is: $newUser<br>";
?>

<h2>It should not add an invalid user</h2>
<?php
DBMaker::create('ptest');
Database::clearDB();
$db = Database::getDB('ptest');
echo "Number of users in db before added is: ". count(UserDataDB::getUsersBy()) ."<br>";
$invalidUser = new UserData(array('userName' => 'jwachter', 'password' => 'fds', 'firstName'=>'bob', 'lastName'=>'smith', 'gender'=>'male', 'birthday'=>'2015-10', 'email'=>'a@a.com', 'phoneNumber'=>'555-555-5555'));
$newUser = UserDataDB::addUser($invalidUser);
echo "Number of users in db after added is: ". count(UserDataDB::getUsersBy()) ."<br>";
echo "New user is: $newUser<br>";
?>

<h2>It should not add a duplicate user</h2>
<?php 
DBMaker::create('ptest');
Database::clearDB();
$db = Database::getDB('ptest');
echo "Number of users in db before added is: ". count(UserDataDB::getUsersBy()) ."<br>";
$duplicateUser = new UserData(array('userName' => 'jwachter', 'password' => 'superman', 'firstName'=>'bob', 'lastName'=>'smith', 'gender'=>'male', 'birthday'=>'2015-10', 'email'=>'a@a.com', 'phoneNumber'=>'555-555-5555'));
$userId = UserDataDB::addUser($duplicateUser);
echo "Number of users in db after added is: ". count(UserDataDB::getUsersBy()) ."<br>";
echo "User ID of new user is: $userId<br>";
?>

<h2>It should get a User by userName</h2>
<?php 
DBMaker::create('ptest');
Database::clearDB();
$db = Database::getDB('ptest');
$users = UserDataDB::getUsersBy('userName', 'jwachter');
echo "The value of User jwachter is:<br>$users[0]<br>";
?>

<h2>It should get a User by userId</h2>
<?php 
DBMaker::create('ptest');
Database::clearDB();
$db = Database::getDB('ptest');
$users = UserDataDB::getUsersBy('userId', '1');
echo "The value of User 3 is:<br>$users[0]<br>";
?>

<h2>It should not get a User not in Users</h2>
<?php 
DBMaker::create('ptest');
Database::clearDB();
$db = Database::getDB('ptest');
$users = UserDataDB::getUsersBy('userName', 'Alfred');
if (empty($users))
	echo "No User Alfred";
else echo "The value of User Alfred is:<br>$users[0]<br>";
?>

<h2>It should not get a User by a field that isn't there</h2>
<?php
DBMaker::create('ptest');
Database::clearDB();
$db = Database::getDB('ptest');
$users = UserDataDB::getUsersBy('telephone', '21052348234');
if (empty($users))
	echo "No User with this telephone number";
else 
	echo "The value of User with a specified telephone number is:<br>$user<br>";
?>

<h2>It should get a user name by user id</h2>
<?php
DBMaker::create('ptest');
Database::clearDB();
$db = Database::getDB('ptest');
$userNames = UserDataDB::getUserValuesBy('userName', 'userId', 1);
print_r($userNames);
?>
<h2>It should allow update of the user name</h2>
<?php
DBMaker::create('ptest');
Database::clearDB();
$db = Database::getDB('ptest');
$users = UserDataDB::getUsersBy('userId', 1);
$user = $users[0];
echo "<br>Before update: $user <br>";
$parms = $user->getParameters();
$parms['email'] = 'b@b.com';
$newUser = new UserData($parms);
$newUser->setUserId(1);
$user = UserDataDB::updateUser($newUser);
echo "<br>After update: $user <br>";


?>
</body>
</html>