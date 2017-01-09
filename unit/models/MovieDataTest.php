<?php
require_once dirname(__FILE__).'\..\..\WebContent\models\Messages.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\MovieData.class.php';

class MovieDataTest extends PHPUnit_Framework_TestCase {
	
  public function testValidMovieDataCreate() {
  	$validTest = array('listId' => '1', 'type'=>'movie', 'title'=>'title', 'year'=>'');
  	$s1 = new MovieData($validTest);
    $this->assertTrue(is_a($s1, 'MovieData'), 
    	'It should create a valid User object when valid input is provided');
    $this->assertEquals($s1->getErrorCount(), 0,
    		'It should not have errors when creating a valid user'); 
  }
  
  public function testInvalidMovieDataName() {
  	$invalidTest = array('listId' => '1', 'type'=>'dfsa', 'title'=>'title', 'year'=>'');
  	$s1 = new MovieData($invalidTest);
  	$this->assertGreaterThan(0, $s1->getErrorCount(),
  			'It should have an error if the user name is invalid');
  }

}
?>