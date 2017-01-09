<?php
require_once dirname(__FILE__).'\..\..\WebContent\models\Messages.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\BucketList.class.php'; 
require_once dirname(__FILE__).'\..\..\WebContent\views\MasterView.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\views\ListView.class.php';

class ListViewTest extends PHPUnit_Framework_TestCase {
	
  public function testShowListViewWithList() {
  	 ob_start();
     $list = new BucketList(array('userName' => 'jwachter', 'userId' => '1', 'typeOf'=>'movie', 'title'=>'comedy'));
     $list -> setListId(1);
     $validTest = array('userId' => 1, 'userName' => 'jwachter', 'password' => 'superman', 'firstName'=>'bob', 'lastName'=>'smith', 'gender'=>'male', 'birthday'=>'2015-10', 'email'=>'a@a.com', 'phoneNumber'=>'555-555-5555');
     $s1 = new UserData($validTest);
   	 $_SESSION = array('userLists' => $list, 'base' => "wj_lab4",'user' => $s1);
   	 ListView::show();
   	 $output = ob_get_clean();
   	 $this->assertFalse(empty($output), "It should show the user update form");
  }
  
  public function testShowAllList() {
     // Test that the showAll produces output for users
  	 ob_start();
     $list1 = new BucketList(array('userName' => 'jwachter', 'userId' => '1', 'typeOf'=>'movie', 'title'=>'comedy'));
     $list1 -> setListId(1);
     $list2 = new BucketList(array('userName' => 'jwachter', 'userId' => '1', 'typeOf'=>'movie', 'title'=>'scary'));
     $list2 -> setListId(2);
     $_SESSION['users'] = array($list1, $list2);
     $_SESSION['base'] = 'wj_lab4';
     $_SESSION['arguments'] = null;
     ListView::showall();
     $output = ob_get_clean();
     $this->assertFalse(empty($output), "It should show the Users table");
  }
  
   public function testListDetails() {
  	 ob_start();
     $list = new BucketList(array('userName' => 'jwachter', 'userId' => '1', 'typeOf'=>'movie', 'title'=>'comedy'));
     $list -> setListId(1);
     $validTest = array('userId' => 1, 'userName' => 'jwachter', 'password' => 'superman', 'firstName'=>'bob', 'lastName'=>'smith', 'gender'=>'male', 'birthday'=>'2015-10', 'email'=>'a@a.com', 'phoneNumber'=>'555-555-5555');
     $s1 = new UserData($validTest);
   	 $_SESSION = array('userLists' => $list, 'base' => "wj_lab4",'user' => $s1);
   	 ListView::showDetails();
   	 $output = ob_get_clean();
   	 $this->assertFalse(empty($output), "It should show the user update form");
   }
}
?>