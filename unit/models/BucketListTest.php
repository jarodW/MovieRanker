<?php
require_once dirname(__FILE__).'\..\..\WebContent\models\Messages.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\BucketList.class.php';

class BucketListTest extends PHPUnit_Framework_TestCase {
	
  public function testValidMovieDataCreate() {
  	$validTest = array('userName' => 'jwachter', 'userId' => '1', 'typeOf'=>'movie', 'title'=>'comedy');
  	$s1 = new BucketList($validTest);
    $this->assertTrue(is_a($s1, 'BucketList'), 
    	'It should create a valid User object when valid input is provided');
    $this->assertEquals($s1->getErrorCount(), 0,
    		'It should not have errors when creating a valid user'); 
  }
  
  public function testInvalidMovieDataName() {
  	$invalidTest = array('userName' => 'jwachter', 'userId' => '1', 'typeOf'=>'dsf', 'title'=>'comedy');
  	$s1 = new MovieData($invalidTest);
  	$this->assertGreaterThan(0, $s1->getErrorCount(),
  			'It should have an error if the user name is invalid');
  }

}
?>