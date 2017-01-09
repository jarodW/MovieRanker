<!DOCTYPE html>
<html>
<head>
</head>
<body>
<h1>Messages tests</h1>

<?php
include_once("../models/Messages.class.php");
?>

<h2>It should set errors from a file</h2>
<?php 

Messages::setErrors("../resources/errors_English.txt");

echo "LAST_NAME_TOO_SHORT: " .Messages::getError("LAST_NAME_TOO_SHORT")."<br>";
echo "EMAIL_INVALID: " .Messages::getError("EMAIL_INVALID")."<br>";
echo "LAST_NAME_INVALID: " .Messages::getError("LAST_NAME_HAS_INVALID_CHARS")."<br>";
echo "FIRST_NAME_EMPTY: ".Messages::getError("FIRST_NAME_EMPTY")."<br>";
echo "FIRST_NAME_HAS_INVALID_CHARS: ".Messages::getError("FIRST_NAME_HAS_INVALID_CHARS")."<br>";
echo "LAST_NAME_HAS_INVALID_CHARS: ".Messages::getError("LAST_NAME_HAS_INVALID_CHARS")."<br>";
echo "USER_NAME_EMPTY: ".Messages::getError("USER_NAME_EMPTY")."<br>";
echo "USER_NAME_HAS_INVALID_CHARS ".Messages::getError("USER_NAME_HAS_INVALID_CHARS")."<br>";
echo "PASSWORD_EMPTY ".Messages::getError("PASSWORD_EMPTY")."<br>";
echo "PASSWORD_TOO_SHORT ".Messages::getError("PASSWORD_TOO_SHORT")."<br>";
echo "INVALID_WEBSITE ".Messages::getError("INVALID_WEBSITE")."<br>";
echo "EMAIL_EMPTY ".Messages::getError("EMAIL_EMPTY")."<br>";
echo "EMAIL_INVALID ".Messages::getError("EMAIL_INVALID")."<br>";
echo "GENDER_EMPTY ".Messages::getError("GENDER_EMPTY")."<br>";
echo "LAST_NAME_EMPTY ".Messages::getError("LAST_NAME_EMPTY")."<br>";
echo "PASSWORD_HAS_INVALID_CHARS ".Messages::getError("PASSWORD_HAS_INVALID_CHARS")."<br>";
echo "INVALID_PHONENUMBER ".Messages::getError("INVALID_PHONENUMBER")."<br>";
echo "BIRTHDAY_EMPTY ".Messages::getError("BIRTHDAY_EMPTY")."<br>";
	
?>

<h2>It should allow reset</h2>
<?php 
Messages::reset();

echo "LAST_NAME_TOO_SHORT: " .Messages::getError("LAST_NAME_TOO_SHORT")."<br>";
echo "EMAIL_INVALID: " .Messages::getError("EMAIL_INVALID")."<br>";
echo "LAST_NAME_INVALID: " .Messages::getError("LAST_NAME_HAS_INVALID_CHARS")."<br>";
echo "FIRST_NAME_EMPTY: ".Messages::getError("FIRST_NAME_EMPTY")."<br>";
echo "FIRST_NAME_HAS_INVALID_CHARS: ".Messages::getError("FIRST_NAME_HAS_INVALID_CHARS")."<br>";
echo "LAST_NAME_HAS_INVALID_CHARS: ".Messages::getError("LAST_NAME_HAS_INVALID_CHARS")."<br>";
echo "USER_NAME_EMPTY: ".Messages::getError("USER_NAME_EMPTY")."<br>";
echo "USER_NAME_HAS_INVALID_CHARS ".Messages::getError("USER_NAME_HAS_INVALID_CHARS")."<br>";
echo "PASSWORD_EMPTY ".Messages::getError("PASSWORD_EMPTY")."<br>";
echo "PASSWORD_TOO_SHORT ".Messages::getError("PASSWORD_TOO_SHORT")."<br>";
echo "INVALID_WEBSITE ".Messages::getError("INVALID_WEBSITE")."<br>";
echo "EMAIL_EMPTY ".Messages::getError("EMAIL_EMPTY")."<br>";
echo "EMAIL_INVALID ".Messages::getError("EMAIL_INVALID")."<br>";
echo "GENDER_EMPTY ".Messages::getError("GENDER_EMPTY")."<br>";
echo "LAST_NAME_EMPTY ".Messages::getError("LAST_NAME_EMPTY")."<br>";
echo "PASSWORD_HAS_INVALID_CHARS ".Messages::getError("PASSWORD_HAS_INVALID_CHARS")."<br>";
echo "INVALID_PHONENUMBER ".Messages::getError("INVALID_PHONENUMBER")."<br>";
echo "BIRTHDAY_EMPTY ".Messages::getError("BIRTHDAY_EMPTY")."<br>";

?>

</body>
</html>

