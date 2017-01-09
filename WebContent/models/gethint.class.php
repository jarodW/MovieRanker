<?php
include_once("../models/Configuration.class.php");
include_once("../models/Database.class.php");
include_once("../models/Messages.class.php");
include_once("../models/UserData.class.php");
include_once("../models/UserDataDB.class.php");
// Array with names
$a = UserDataDB::getUserValuesBy('userName');
// get the q parameter from URL
$q = $_REQUEST["q"];

$hint = "";

// lookup all hints from array if $q is different from "" 
if ($q !== "") {

    foreach($a as $name) {
        if (strcmp ( $q, $name ) == 0) {
        	$hint = "username is not available.";

        }
    }
}

// Output "no suggestion" if no hint was found or output correct values 
echo $hint === "" ? "username available" : $hint;
?>