<?php
require_once dirname(__FILE__).'\..\..\WebContent\models\Messages.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\User.class.php'; 
require_once dirname(__FILE__).'\..\..\WebContent\views\HomeView.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\views\MasterView.class.php';

class HomeViewTest extends PHPUnit_Framework_TestCase {
	
  public function testShowHomeViewWithUser() {
  	ob_start();
  	$validTest = array('userId' => 1, 'userName' => 'jwachter', 'password' => 'superman', 'firstName'=>'bob', 'lastName'=>'smith', 'gender'=>'male', 'birthday'=>'2015-10', 'email'=>'a@a.com', 'phoneNumber'=>'555-555-5555');
  	$s1 = new UserData($validTest);
  	$_SESSION = array('user' => $s1, 'base' => 'wj_lab4');
  	HomeView::show();
  	$output = ob_get_clean();
  	$this->assertFalse(empty($output),
  			"It should show a Home view when passed a valid user");
  }
  
  public function testShowHomeViewWithNullUser() {
  	ob_start();
  	$_SESSION = array('user' => null, 'base' => 'mvcdbcrud');
  	$return = HomeView::show();
  	$output = ob_get_clean();
  	$this->assertFalse(empty($output),
  			"It should show a Home view when passed a null user");
  }

}
?>