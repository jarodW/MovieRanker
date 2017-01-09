<?php
class UserData {
	private $errorCount;
	private $errors;
	private $formInput;
	private $firstName;
	private $lastName;
	private $userName;
	private $password;
	private $passwordHash;
	private $email;
	private $gender;
	private $phoneNumber;
	private $website;
	private $favoriteColor;
	private $birthday;
	private $file;
	private $userId;
	
	public function __construct($formInput = null) {
		$this->formInput = $formInput;
		Messages::reset();
		$this->initialize();
	}

	public function getError($errorName) {
		if (isset($this->errors[$errorName]))
			return $this->errors[$errorName];
		else
			return "";
	}

	public function setError($errorName, $errorValue) {
		// Sets a particular error value and increments error count
		$this->errors[$errorName] =  Messages::getError($errorValue);
		$this->errorCount ++;
	}
	
	public function setUserId($id) {
		// Set the value of the userId to $id
		$this->userId = $id;
	}
	
	public function getErrorCount() {
		return $this->errorCount;
	}

	public function getErrors() {
		return $this->errors;
	}
	
	public function getEmail() {
		return $this->email;
	}

	public function getFirstName() {
		return $this->firstName;
	}
	
	public function getGender() {
		return $this->gender;
	}
	
	public function getLastName() {
		return $this->lastName;
	}
	
	public function getUserName(){
		return $this->userName;
	}
	
	public function getPassword(){
		return $this->password;
	}
	
	public function getPasswordHash() {
		return $this->passwordHash;
	}
	
	public function verifyPassword($hash) {
		// Set the value of passwordHash to hash
		return password_verify($this->password, $hash);
	}
	
	public function getPhoneNumber(){
		return $this->phoneNumber;
	}
	
	public function getWebsite(){
		return $this->website;
	}
	
	public function getFavoriteColor(){
		return $this->favoriteColor;
	}
	
	public function getBirthday(){
		return $this->birthday;
	}
	
	public function getFile(){
		return $this->file;
	}
	
	
	public function getUserId(){
		return $this->userId;
	}
	
	public function getParameters() {
		// Return data fields as an associative array
		$paramArray = array("firstName" => $this->firstName,
				            "lastName" => $this->lastName,
			            	"email" => $this->email,
			              	"gender" => $this->gender,
							"userName" => $this->userName,
							"password" => $this->password,
							"phoneNumber" => $this->phoneNumber,
							"website" => $this->website,
							"birthday" => $this->birthday,
							"file" => $this->file,
							"favoriteColor" =>$this->favoriteColor); 
		return $paramArray;
	}

	public function __toString() {
		$str = "First name: ".$this->firstName.
			   " Last name: ".$this->lastName.
			   " Email: ".$this->email.
			   " Gender: " .$this->gender.
			   " UserName: ".$this->userName.
			   " Password: ".$this->password.
			   " PhoneNumber: ".$this->phoneNumber.
			   " Website: ".$this->website.
			   " Birthday: ".$this->birthday.
			   " File: ".$this->file.
			   " FavoriteColor: ".$this->favoriteColor;
		return $str;
	}
	
	private function extractForm($valueName) {
		// Extract a stripped value from the form array
		$value = "";
		if (isset($this->formInput[$valueName])) {
			$value = trim($this->formInput[$valueName]);
			$value = stripslashes ($value);
			$value = htmlspecialchars ($value);
			return $value;
		}
	}
	
	private function initialize() {
		$this->errorCount = 0;
		$errors = array();
		if (is_null($this->formInput))
			$this->initializeEmpty();
		else  {	 
		  $this->validateUserId();
		  $this->validateEmail();
	      $this->validateGender();
		  $this->validateFirstName();
		  $this->validateLastName();
		  $this->validateUserName();
		  $this->validatePassword();
		  $this->validateFavoriteColor();
		  $this->validateWebsite();
		  $this->validatePhoneNumber();
		  $this->validateBirthDay();
		  $this->validateFile();
		}	
	}

	private function initializeEmpty() {
		$this->errorCount = 0;
		$errors = array();
		$this->firstName = "First";
		$this->lastName = "Last";
		$this->email = "";
		$this->gender = "";
		$this->favoriteColor = "";
		$this->website = "";
		$this->phoneNumber = "";
		$this->gender = "";
		$this->userName = "";
		$this->password = "";
		$this->file = "";
		$this->passwordHash = "";
	}


	private function validateUserName(){
		$this->userName = $this->extractForm('userName');
		if (empty($this->userName)) {
			$this->setError('userName', 'USER_NAME_EMPTY');
			$this->errorCount ++;
		}elseif (!filter_var($this->userName, FILTER_VALIDATE_REGEXP,
			array("options"=>array("regexp" =>"/^([a-zA-Z0-9\-\_])+$/i")) )) {
			$this->setError('userName', 'USER_NAME_HAS_INVALID_CHARS');
			$this->errorCount ++;
		};
	}
	
	private function validatePassword(){
		// Password should not be blank
		if (isset($this->formInput['password'])) {
		    $this->password = $this->extractForm('password');
		    $this->passwordHash = password_hash($this->password, PASSWORD_DEFAULT);
			if (empty($this->password)) {
			$this->setError('password', 'PASSWORD_EMPTY');
			$this->errorCount ++;
			}elseif (!filter_var($this->password, FILTER_VALIDATE_REGEXP,
				array("options"=>array("regexp" =>"/^([a-zA-Z0-9\-\_])+$/i")) )) {
				$this->setError('password', 'PASSWORD_HAS_INVALID_CHARS');
				$this->errorCount ++;
			}elseif(strlen($this->password) < '8'){
				$this->setError('password', 'PASSWORD_TOO_SHORT');
			}
		}
		elseif (isset($this->formInput['passwordHash']))
		$this->passwordHash =  $this->formInput['passwordHash'];
	}
	
	private function validateFavoriteColor(){
		$this->favoriteColor = $this->extractForm('favoriteColor');
	}
	
	private function validateEmail() {
		$this->email = $this->extractForm('email');
		if(empty($this->email)){
			$this->setError('email', 'EMAIL_EMPTY');
			$this->errorCount++;
		}elseif(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
			$this->setError('email',"EMAIL_INVALID");
			$this->errorCount++;
		}
	}
	
	private function validatePhoneNumber(){
		$this->phoneNumber = $this->extractForm('phoneNumber');
		if (!filter_var($this->phoneNumber, FILTER_VALIDATE_REGEXP,
				array("options"=>array("regexp" => "/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/")))){
			$this->setError('phoneNumber','INVALID_PHONENUMBER');
			$this->errorCount++;
		}
	}
	
	private function validateWebsite(){
		$this->website = $this->extractForm('website');
	}
	
	private function validateGender() {
		$this->gender = $this->extractForm('gender');
		if (empty($this->gender)) {
			$this->setError('gender', 'GENDER_EMPTY');
			$this->errorCount++;
		}
		
	}
	
	private function validateBirthday(){
		$this->birthday = $this->extractForm('birthday');
		if(empty($this->birthday)){
			$this->setError('birthday',"BIRTHDAY_EMPTY");
			$this->errorCount++;
		}elseif (!filter_var($this->birthday, FILTER_VALIDATE_REGEXP,
				array("options"=>array("regexp" =>"/(0[1-9]|1[012])[- \/.](0[1-9]|[12][0-9]|3[01])[- \/.](19|20)\d\d/")) )) {
			$this->setError('birthday', 'INVALID_BIRTHDAY');
			$this->errorCount ++;
		}
	}
	
	private function validateFile(){
		$this->file = $this->extractForm('file');
	}
	

	private function validateFirstName() {
		$this->firstName = $this->extractForm('firstName');
		if (empty($this->firstName)) {
			$this->setError('firstName', 'FIRST_NAME_EMPTY');
			$this->errorCount ++;
		}elseif (!filter_var($this->firstName, FILTER_VALIDATE_REGEXP,
				array("options"=>array("regexp" =>"/^([a-zA-Z0-9\-\_])+$/i")) )) {
			$this->setError('firstName', 'FIRST_NAME_HAS_INVALID_CHARS');
			$this->errorCount ++;
		}
	}	
	
	private function validateLastName() {
			$this->lastName = $this->extractForm('lastName');
		if (empty($this->lastName)) {
			$this->setError('lastName', 'LAST_NAME_EMPTY');
			$this->errorCount ++;
		} elseif (!filter_var($this->lastName, FILTER_VALIDATE_REGEXP,
				array("options"=>array("regexp" =>"/^([a-zA-Z0-9\-\_])+$/i")) )) {
			$this->setError('lastName', 'LAST_NAME_HAS_INVALID_CHARS');
			$this->errorCount ++;
		}
	}
	
	private function validateUserId(){
		$this->userId = $this->extractForm('userId');
	}
	
}
?>