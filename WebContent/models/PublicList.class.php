<?php
class PublicList {
	private $errorCount;
	private $errors;
	private $formInput;
	private $publicListId;   // will ultimately be a hash
	private $listId;
	private $points;
	private $title;
	private $type;

	
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
	
	public function getPublicListId() {
		return $this->publicListId;
	}
	
	public function getListId() {
		return $this->listId;
	}
	
	public function getPoints() {
		return $this->points;
	}

	public function getTitle() {
		return $this->title;
	}
	
    public function getType(){
    	return $this->type;
    }
	
	public function getParameters() {
		// Return data fields as an associative array
		$paramArray = array("publicListId" => $this->publicListId,
				            "listId" => $this->listId,
				            "points" => $this->points,
							"typeOf"=> $this->type,
							"title"=> $this->title
		); 
		return $paramArray;
	}
	
	public function setError($errorName, $errorValue) {
		// Set a particular error value and increments error count
		$this->errors[$errorName] =  Messages::getError($errorValue);
		$this->errorCount ++;
	}
	
	public function setPublicListId($id) {
		// Set the value of the userId to $id
		$this->publicListId = $id;
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
			$this->validatePublicListId();
			$this->validateListId();
			$this->validatePoints();
			$this->validateTitle();
			$this->validateType();
		}
	}

	private function initializeEmpty() {
		$this->errorCount = 0;
		$errors = array();
	 	$this->listId = "";
	 	$this->points = "";
	 	$this->title = "";
	 	$this->type = "";
	}

	private function validatePublicListId() {
		// Username should only contain letters, numbers, dashes and underscore
		$this->publicListId = $this->extractForm('publicListId');
	}
	
	private function validateListId() {
		// Username should only contain letters, numbers, dashes and underscore
		$this->listId = $this->extractForm('listId');
	}
	
	private function validatePoints() {
		// Username should only contain letters, numbers, dashes and underscore
		$this->points = $this->extractForm('points');
	}
	
	private function validateTitle(){
		$this->title = $this->extractForm('title');
	}
	
	private function validateType(){
		$this->type = $this->extractForm('type');
	}
}
?>