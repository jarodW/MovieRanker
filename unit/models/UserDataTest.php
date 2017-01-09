<?php
require_once dirname(__FILE__).'\..\..\WebContent\models\Messages.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\UserData.class.php';

class UserDataTest extends PHPUnit_Framework_TestCase {
	
  public function testValidUserCreate() {
  	$validTest = array('userName' => 'jwachter', 'password' => 'superman', 'firstName'=>'bob', 'lastName'=>'smith', 'gender'=>'male', 'birthday'=>'2015-10', 'email'=>'a@a.com', 'phoneNumber'=>'555-555-5555');
  	$s1 = new UserData($validTest);
    $this->assertTrue(is_a($s1, 'UserData'), 
    	'It should create a valid User object when valid input is provided');
    $this->assertEquals($s1->getErrorCount(), 0,
    		'It should not have errors when creating a valid user'); 
  }
  
  public function testInvalidUserName() {
  	$invalidTest = array("userName" => "krobbins$", "password" => "123");
  	$s1 = new UserData($invalidTest);
  	$this->assertGreaterThan(0, $s1->getErrorCount(),
  			'It should have an error if the user name is invalid');
  }

}
?>