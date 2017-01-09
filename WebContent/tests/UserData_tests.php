<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Basic tests for User</title>
</head>
<body>
<h1>User tests</h1>

<?php
include_once("../models/UserData.class.php");
include_once("../models/Messages.class.php");
?>

<h2>It should create a valid User object when all input is provided</h2>
<?php 
$validTest = array("firstName" => "jarod", "lastName" => "wachter", "gender" => "male", "userName"=>"superman", "password" => "dfslkafj", 
				   "favoriteColor" => "#ff0000", "email" => "blah@blah.com", "phoneNumber" => "222-222-2222", "website"=>"https://www.mywebsite.com",
				   "birthday"=>"1900-01","spam"=>"true","file" => "../resources/racoon.jpeg");
$s1 = new UserData($validTest);
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

<h2>It should have an error when the userName, password, firstName, or lastName contains invalid characters</h2>
<?php 
$invalidTest = array("userName" => "jwachter$", "password" => "myPassword%^", "firstName" => "&Richard%", "lastName" => "%$#Jones");
$s1 = new UserData($invalidTest);
$test2 = (empty($s1->getErrors()))?'':
'Failed:It should have errors when invalid input is provided<br>';
echo $test2;
echo "The error for userName is: ". $s1->getError('userName') ."<br>";
echo "The error for password is: ". $s1->getError('password') ."<br>";
echo "The error for firstName is: ". $s1->getError('firstName') ."<br>";
echo "The error for lastName is: ". $s1->getError('lastName') ."<br>";
echo "The object is: $s1<br>";
?>

<h2>It should have an error when the userName, password, email, firstName, lastName, or birthday is empty</h2>
<?php 
$invalidTest = array("userName" => "", "password" => "", "email" => "", "firstName" => "", "lastName" => "", "birthday" => "");
$s1 = new UserData($invalidTest);
$test2 = (empty($s1->getErrors()))?'':
'Failed:It should have errors when invalid input is provided<br>';
echo $test2;
echo "The error for userName is: ". $s1->getError('userName') ."<br>";
echo "The error for password is: ". $s1->getError('password') ."<br>";
echo "The error for email is: ". $s1->getError('email') ."<br>";
echo "The error for firstName is: ". $s1->getError('firstName') ."<br>";
echo "The error for lastName is: ". $s1->getError('lastName') ."<br>";
echo "The error for birthday is: ". $s1->getError('birthday') ."<br>";
echo "The object is: $s1<br>";
?>

<h2>It should return an error when a wrongly formated email, website, or phoneNumber is entered.</h2>
<?php 
$invalidTest = array("phoneNumber" => "32423-434-234234", "email" => "myemail.com", "website" => "gfhgf");
$s1 = new UserData($invalidTest);
$test2 = (empty($s1->getErrors()))?'':
'Failed:It should have errors when invalid input is provided<br>';
echo $test2;
echo "The error for phoneNumber is: ". $s1->getError('phoneNumber') ."<br>";
echo "The error for email is: ". $s1->getError('email') ."<br>";
echo "The error for website is: ". $s1->getError('website') ."<br>";
echo "The object is: $s1<br>";
?>

</body>
</html>
