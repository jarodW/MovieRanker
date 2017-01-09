<?php
require_once dirname(__FILE__).'\..\..\WebContent\models\Messages.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\UserData.class.php'; 
require_once dirname(__FILE__).'\..\..\WebContent\views\MasterView.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\views\LoginView.class.php';

class LoginViewTest extends PHPUnit_Framework_TestCase {
	
  public function testShowLoginViewWithUser() {
  	 ob_start();
     $user = new UserData(array('userName' => 'jwachter', 'password' => 'superman', 'firstName'=>'bob', 'lastName'=>'smith', 'gender'=>'male', 'birthday'=>'2015-10', 'email'=>'a@a.com', 'phoneNumber'=>'555-555-5555'));
     $user -> setUserId(1);
   	 $_SESSION = array('user' => $user, 'base' => "wj_lab4");
   	 LoginView::show();
   	 $output = ob_get_clean();
   	 $this->assertFalse(empty($output), "It should show the user update form");
  }
  
}
?>