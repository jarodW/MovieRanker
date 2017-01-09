<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Basic tests for ListView</title>
</head>
<body>
<h1>ListView tests</h1>

<?php
include_once("../models/BucketList.class.php");
include_once("../views/ListView.class.php");
include_once("../views/MasterView.class.php");
include_once("../models/Messages.class.php");
?>


<h2>It should call show</h2>
<?php 
$input = array("listId"=>1, "userId"=>1, "typeOf"=>'series', "title"=>'comedy');
$theList = new BucketList($input);
echo "The movie $theList";
$_SESSION = array('userLists' => array($theList), 'base' => "wj_lab3");
ListView::show();
?>

</body>
</html>
