<?php
class BucketList {
	private $errorCount;
	private $errors;
	private $formInput;
	private $listId;   // will ultimately be a hash
	private $userId;
	private $typeOf;
	private $title;
	private $userName;
	private $finalized;
	private $public;

	
	public function __construct($formInput = null) {
		$this->formInput = $formInput;
		Messages::reset();
		$this->initialize();
	}

	public function getError($errorName) {
		// Return the error string associated with $errorName
		if (isset($this->errors[$errorName]))
			return $this->errors[$errorName];
		else
			return "";
	}


	public function getErrorCount() {
		return $this->errorCount;
	}

	public function getErrors() {
		return $this->errors;
	}
	
	public function getUserId() {
		return $this->userId;
	}
	
	public function getListId() {
		return $this->listId;
	}
	
	public function getPublic() {
		return $this->public;
	}

	public function getTypeOf() {
		return $this->typeOf;
	}
	
	public function getTitle(){
		return $this->title;
	}
	
	public function getFinalized(){
		return $this->finalized;
	}
	
	public function getUserName(){
		return $this->userName;
	}

	public function getParameters() {
		// Return data fields as an associative array
		$paramArray = array("listId" => $this->listId,
				            "userId" => $this->userId,
				            "typeOf" => $this->typeOf,
							"title"=> $this->title,
							"finalized"=>$this->finalized,
							"userName"=> $this->userName,
							"public"=>$this->public
		); 
		return $paramArray;
	}
	
	public function setError($errorName, $errorValue) {
		// Set a particular error value and increments error count
		$this->errors[$errorName] =  Messages::getError($errorValue);
		$this->errorCount ++;
	}
	
	public function setListId($id) {
		// Set the value of the userId to $id
		$this->listId = $id;
	}

	public function __toString() {
		$str = "List Id: ".$this->listId."<br>userId: ".$this-userId . 
		       "<br>title: ". $this->title;
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
		$this->errors = array();
		if (is_null($this->formInput))
			$this->initializeEmpty();
		else  {
			$this->validateListId();
			$this->validateUserId();
			$this->validateTypeOf();
			$this->validateTitle();
			$this->validateUserName();
			$this->validateFinalized();
			$this->validatePublic();
		}
	}

	private function initializeEmpty() {
		$this->errorCount = 0;
		$errors = array();
	 	$this->userId = "";
	 	$this->typeOf = "";
	 	$this->title = "";
	 	$this->finalized = 0;
	 	$this->public = 0;
	}

	private function validateUserId() {
		// Username should only contain letters, numbers, dashes and underscore
		$this->userId = $this->extractForm('userId');
	}
	
	private function validateTypeOf() {
		// Username should only contain letters, numbers, dashes and underscore
		$this->typeOf = $this->extractForm('typeOf');
	}
	
	private function validateTitle() {
		// Username should only contain letters, numbers, dashes and underscore
		$this->title = $this->extractForm('title');
	}
	
	private function validateUserName(){
		$this->userName = $this->extractForm('userName');
	}
	
	private function validateListId(){
		$this->listId = $this->extractForm('listId');
	}
	
	private function validateFinalized(){
		$this->finalized = $this->extractForm('finalized');
	}
	
	private function validatePublic(){
		$this->public = $this->extractForm('public');
	}
}
?>