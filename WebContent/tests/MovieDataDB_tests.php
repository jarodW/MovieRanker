<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Basic tests for ListsDB</title>
</head>
<body>
<h1>MovieDataDB tests</h1>


<?php
include_once("../models/Configuration.class.php");
include_once("../models/Database.class.php");
include_once("../models/Messages.class.php");
include_once("../models/MovieData.class.php");
include_once("../models/MovieDataDB.class.php");
include_once("../models/UserData.class.php");
include_once("../models/UserDataDB.class.php");
include_once("./DBMaker.class.php");
?>


<h2>It should get all users from a test database</h2>
<?php
DBMaker::create('ptest');
Database::clearDB();
$db = Database::getDB('ptest');
$movies = MovieDataDB::getMoviesBy();
$movieCount = count($movies);
echo "Number of movies in db is: $movieCount <br>";
foreach ($movies as $movie) 
	echo "$movie <br>";
?>

<h2>It should insert a valid movie in the database</h2>
<?php 
DBMaker::create('ptest');
Database::clearDB();
$db = Database::getDB('ptest');
echo "Number of movies in db before added is: ". count(MovieDataDB::getMoviesBy()) ."<br>";
$validTest = array('listId' => '1', 'type'=>'movie', 'title'=>'Scream', 'year'=>'');
$s1 = new MovieData($validTest);
$newMovie = MovieDataDB::addMovie($s1);
echo "Number of users in db after added is: ". count(MovieDataDB::getMoviesBy()) ."<br>";
echo "The new user is: $newMovie<br>";
?>	


<h2>It should get a Movies by listId</h2>
<?php 
DBMaker::create('ptest');
Database::clearDB();
$db = Database::getDB('ptest');
$movies = MovieDataDB::getMoviesBy('listId', '1');
echo "The value of Movie 1 is:<br>$movies[0]<br>";
?>
</body>
</html>