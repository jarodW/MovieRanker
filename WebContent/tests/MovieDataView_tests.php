<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Basic tests for MovieData</title>
</head>
<body>
<h1>MovieData tests</h1>

<?php
include_once("../views/MovieDataView.class.php");
include_once("../models/MovieData.class.php");
include_once("../models/BucketList.class.php");
include_once("../views/MasterView.class.php");
include_once("../models/Messages.class.php");
?>

<h2>It should call show</h2>
<?php 
$input = array("movieId"=>1, "listId"=>1, "title"=>'How I Met Your Mother', "year"=>"");
$theMovie = new MovieData($input);
echo "The movie $theMovie";
$_SESSION = array('movies' => array($theMovie), 'base' => "wj_lab3");
MovieDataView::showAll();
?>

<h2>It should call update</h2>
<?php 
$input = array("movieId"=>1, "listId"=>1, "title"=>'How I Met Your Mother', "year"=>"");
$input2 = array("listId"=>1, "userId"=>1, "typeOf"=>'series', "title"=>'comedy');
$theMovie = new MovieData($input);
$theList = new BucketList($input2);
echo "The movie $theMovie";
$_SESSION = array('movieLists' => array($theMovie),'list'=> $theList, 'base' => "wj_lab3");
MovieDataView::showDetails();
?>
</body>
</html>
