<?php
class MovieData {
	private $type;
	private $errorCount;
	private $errors;
	private $formInput;
	private $title;
	private $year;
	private $movieInfo;
	private $movieId;
	private $listId;
	private $userId;
	private $watched;
	private $rank;
	
	private $exist = false;
	
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

	public function getErrorCount() {
		return $this->errorCount;
	}

	public function getErrors() {
		return $this->errors;
	}

	public function getUserId() {
		return $this->userId;
	}
	
	public function getYear(){
		if($this->exist=="True" && $this->year != "")
			return $this->movieInfo->Year;
		return $this->year;
	}
	
	public function getTitle(){
		if($this->exist=="True")
			return $this->movieInfo->Title;
		return $this->title;
	}
	
	public function getMovieInfo(){
		return $this->movieInfo;
	}
	public function getMovieId() {
		return $this->movieId;
	}
	public function getListId() {
		return $this->listId;
	}
	public function getRated(){
		if($this->exist=="True")
			return $this->movieInfo->Rated;
		return"";
	}	
	public function getImdbRating(){
		if($this->exist=="True")
			return $this->movieInfo->imdbRating;
		return "";
	}
	public function getDirector(){
		if($this->exist=="True")
			return $this->movieInfo->Director;
		return "";
	}
	public function setMovieId($id) {
		// Set the value of the userId to $id
		$this->movieId = $id;
	}
	public function getType(){
		return $this->type;
	}
	public function getExist(){
		return $this->exist;
	}
	public function getRank(){
		return $this->rank;
	}
	public function getWatched(){
		return $this->watched;
	}
	public function getParameters() {
		// Return data fields as an associative array
		$paramArray = array(
				"title" => $this->title,
				"year"=>$this->year,
				"listId"=>$this->listId,
				"type"=>$this->type,
				"movieId"=>$this->movieId,
				"userId"=>$this->userId,
				"rank"=>$this->rank,
				"watched"=>$this->watched
				
		); 
		return $paramArray;
	}

	public function __toString() {
		$str = " Year: " . $this->year .
		       " Title: " . $this->title.
			   " Type: " . $this->type;
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
		else{
		   $this->validateType();
		   $this->validateYear();
		   $this->validateTitle();
		   $this->validateListId();
		   $this->validateMovieId();
		   $this->validateUserId();
		   $this->validateRank();
		   $this->validateWatched();
		}
	}

	private function initializeEmpty() {
		$this->errorCount = 0;
		$errors = array();
	 	$this->userName = "";
		$this->year = "";
	 	$this->title = "";
	 	$this->rank = "";
	 	$this->watched = 0;
	}

	private function validateUserName() {
		// Username should only contain letters, numbers, dashes and underscore
		$this->userName = $this->extractForm('userName');

	}
	private function validateType(){
		$this->type = $this->extractForm('type');
		if (empty($this->type)) {
			$this->setError('type', 'TYPE_EMPTY');
			$this->errorCount ++;
		}
	}
	private function validateTitle() {
		$this->title = $this->extractForm('title');
		$movieTitle = urlencode($this->title);
		$movieTitle  = str_replace(' ', '+', $this->title);
		try{
		$json = file_get_contents("http://www.omdbapi.com/?t=$movieTitle&y=$this->year&type=$this->type&r=json&tomatoes=true");
		$details=json_decode($json);
		$this->exist = $details->Response;
		}catch (Exception $e){
			
		}
		if(empty($this->title)){
			$this->setError('title', 'EMPTY_TITLE');
			$this->errorCount++;
		}
		elseif($details->Response=='False'){
			$this->setError('title', 'MOVIE_ERROR');
			$this->errorCount++;
		}
		else 
			$this->movieInfo = $details;
	}
	private function validateListId(){
		$this->listId = $this->extractForm('listId');
	}
	private function validateYear() {
		// Username should only contain letters, numbers, dashes and underscore
		$this->year = $this->extractForm('year');
		
		if (!filter_var($this->year, FILTER_VALIDATE_REGEXP,
				array("options"=>array("regexp" =>"/^\d{4}$/")) ) && $this->year !="") {
			$this->setError('year', 'INVALID_YEAR');
			$this->errorCount ++;
		}
	}
	
	private function validateMovieId(){
		$this->movieId = $this->extractForm('movieId');
	}
	

	private function validateuserId(){
		$this->userId = $this->extractForm('userId');
	}
	
	private function validateRank(){
		$this->rank = $this->extractForm('rank');
	}
	
	private function validateWatched(){
		$this->watched = $this->extractForm('watched');
	}
}
?>