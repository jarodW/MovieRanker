<?php
require_once dirname(__FILE__).'\..\..\WebContent\models\Messages.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\UserData.class.php'; 
require_once dirname(__FILE__).'\..\..\WebContent\views\MasterView.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\views\ProfileView.class.php';

class ProfileViewTest extends PHPUnit_Framework_TestCase {
	
  public function testShowUserViewWithUser() {
  	 ob_start();
     $user = new UserData(array('userName' => 'jwachter', 'password' => 'superman', 'firstName'=>'bob', 'lastName'=>'smith', 'gender'=>'male', 'birthday'=>'2015-10', 'email'=>'a@a.com', 'phoneNumber'=>'555-555-5555'));
     $user -> setUserId(1);
   	 $_SESSION = array('user' => $user, 'base' => "wj_lab4");
   	 ProfileView::show();
   	 $output = ob_get_clean();
   	 $this->assertFalse(empty($output), "It should show the user update form");
  }
  
  public function testShowAllUsers() {
     // Test that the showAll produces output for users
  	 ob_start();
     $s1 = new UserData(array('userName' => 'jwachter', 'password' => 'superman', 'firstName'=>'bob', 'lastName'=>'smith', 'gender'=>'male', 'birthday'=>'2015-10', 'email'=>'a@a.com', 'phoneNumber'=>'555-555-5555'));
     $s1 -> setUserId(1);
     $s2 = new UserData(array('userName' => 'joe', 'password' => 'superman', 'firstName'=>'bob', 'lastName'=>'smith', 'gender'=>'male', 'birthday'=>'2015-10', 'email'=>'a@a.com', 'phoneNumber'=>'555-555-5555'));
     $s2 -> setUserId(2);  
     $_SESSION['users'] = array($s1, $s2);
     $_SESSION['base'] = 'wj_lab4';
     $_SESSION['arguments'] = null;
     ProfileView::showall();
     $output = ob_get_clean();
     $this->assertFalse(empty($output), "It should show the Users table");
  }
  
   public function testUpdateUser() {
     // Test show the update
  	 ob_start();
     $user = new UserData(array('userName' => 'jwachter', 'password' => 'superman', 'firstName'=>'bob', 'lastName'=>'smith', 'gender'=>'male', 'birthday'=>'2015-10', 'email'=>'a@a.com', 'phoneNumber'=>'555-555-5555'));
     $user -> setUserId(1);
   	 $_SESSION = array('users' => array($user), 'base' => "wj_lab4");
   	 ProfileView::showUpdate();
   	 $output = ob_get_clean();
   	 $this->assertFalse(empty($output), "It should show the user update form");
   }
}
?>