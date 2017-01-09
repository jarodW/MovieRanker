<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Basic tests for MovieData</title>
</head>
<body>
<h1>MovieData tests</h1>

<?php
include_once("../models/Messages.class.php");
include_once("../models/MovieData.class.php");
?>

<h2>It should create a valid MovieData object when a movie title is provided.</h2>
<?php 
$validTest = array("title" => "City of God","listId" => 1);
$s1 = new MovieData($validTest);
echo "The object is: $s1<br>";
$test1 = (is_object($s1))?'':
'Failed:It should create a valid object when valid input is provided<br>';
echo $test1;
$test2 = (empty($s1->getErrors()))?'':
'Failed:It not have errors when valid input is provided<br>';
echo $test2;
?>

<h2>It should extract the parameters that went in</h2>
<?php 
$props = $s1->getParameters();
print_r($props);
?>
<h2>It should recieve data from the OMDB database</h2>
<?php
echo "Title: " . $s1->getTitle(). "<br>";
echo "Rated: " . $s1->getRated(). "<br>";
echo "Director: " . $s1->getDirector(). "<br>";
echo "IMDB Rating: " . $s1->getImdbRating(). "<br>";
echo "Year: " . $s1->getYear(). "<br>";
echo 'Poster: <img src = "'.$s1->getMovieInfo()->Poster.'"height="42" width="42"><br>';
?>
<h2>It should have an error when the title does not reference a real movie or tv show and when a type is not provided</h2>
<?php 
$invalidTest = array("title" => "fdsajlsdkjf", "type" => "");
$s1 = new movieData($invalidTest);
$test2 = (empty($s1->getErrors()))?'':
'Failed:It should have errors when invalid input is provided<br>';
echo $test2;
echo "The error for movieData is: ". $s1->getError('title') ."<br>";
echo "The error for type is: " .$s1->getError('type') ."<br>";
echo "The object is: $s1<br>";
?>
<h2>It should have an error when an improperly formated year is inputed</h2>
<?php 
$invalidTest = array("title" => "", "type" => "", "year" => "199a");
$s1 = new movieData($invalidTest);
$test2 = (empty($s1->getErrors()))?'':
'Failed:It should have errors when invalid input is provided<br>';
echo $test2;
echo "The error for year is: ". $s1->getError('year') ."<br>";
echo "The object is: $s1<br>";
?>
</body>
</html>
