<?php
require_once dirname(__FILE__).'\..\..\WebContent\models\Configuration.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\Database.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\Messages.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\UserData.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\UserDataDB.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\tests\DBMaker.class.php';


class UserDataDBTest extends PHPUnit_Framework_TestCase {
	
 public function testGetAllUsers() {
  	  DBMakerUnit::createDB('ptest');
  	  $users = UserDataDB::getUsersBy();
  	  $this->assertEquals(2, count($users), 'It should fetch all of the users in the test database');

  	  foreach ($users as $user) 
          $this->assertTrue(is_a($user, 'UserData'), 
        		'It should return valid User objects');
  }
  
  public function testInsertValidUser() {
   	DBMakerUnit::createDB('ptest');
  	$beforeCount = count(UserDataDB::getUsersBy());
  	$validTest = array('userName' => 'joan', 'password' => 'superman', 'firstName'=>'bob', 'lastName'=>'smith', 'gender'=>'male', 'birthday'=>'2015-10', 'email'=>'a@a.com', 'phoneNumber'=>'555-555-5555');
  	$s1 = new UserData($validTest);
  	$newUser = UserDataDB::addUser($s1);
  	$this->assertEquals(0, $newUser->getErrorCount(), 
  			'The inserted user should not have users');
  	$afterCount = count(UserDataDB::getUsersBy());
  	$this->assertEquals($afterCount, $beforeCount + 1,
  			'The database should have one more user after insertion');
  }
  
  public function testInsertDuplicateUser() {
  	ob_start();
 	DBMakerUnit::createDB('ptest');
  	$beforeCount = count(UserDataDB::getUsersBy());
  	$duplicateTest = array('userName' => 'jwachter', 'password' => 'superman', 'firstName'=>'bob', 'lastName'=>'smith', 'gender'=>'male', 'birthday'=>'2015-10', 'email'=>'a@a.com', 'phoneNumber'=>'555-555-5555');
  	$s1 = new UserData($duplicateTest);
  	$newUser = UserDataDB::addUser($s1);
  	$this->assertGreaterThan(0, $newUser->getErrorCount(), 
  			'Duplicate attempt should return errors');
  	$afterCount = count(UserDataDB::getUsersBy());
  	$this->assertEquals($afterCount, $beforeCount,
  			'The database should have the same number of elements after trying to insert duplicate');
  	ob_get_clean();
  }
  
  public function testUpdateUserName() {
  	// Test the update of the userName 
 	DBMakerUnit::createDB('ptest');
	$users = UserDataDB::getUsersBy('userId', 1);
	$user = $users[0];
	$parms = $user->getParameters();
	$this->assertEquals($user->getUserName(), 'jwachter',
			'Before the update it should have user name Kay');
	$parms['email'] = 'b@b.com';
	$newUser = new UserData($parms);
	$newUser->setUserId(1);
	$user = UserDataDB::updateUser($newUser);
	$this->assertEquals($user->getUserName(), 'jwachter',
			'Before the update it should email a@a.com');
	$this->assertTrue(empty($user->getErrors()),
			'The updated user should not have errors');
  }
}
?>