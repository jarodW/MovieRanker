<?php
require_once dirname(__FILE__).'\..\..\WebContent\models\Messages.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\BucketList.class.php'; 
require_once dirname(__FILE__).'\..\..\WebContent\views\MasterView.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\views\MovieDataView.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\MovieData.class.php';
class MovieDataViewTest extends PHPUnit_Framework_TestCase {
	
  public function testShowMovieViewWithMovie() {
  	 ob_start();
     $movie1 = new MovieData(array('listId' => '1', 'type'=>'movie', 'title'=>'title', 'year'=>''));
     $movie1 -> setMovieId(1);
     $user = array('userId' => 1, 'userName' => 'jwachter', 'password' => 'superman', 'firstName'=>'bob', 'lastName'=>'smith', 'gender'=>'male', 'birthday'=>'2015-10', 'email'=>'a@a.com', 'phoneNumber'=>'555-555-5555');
     $s1 = new UserData($user);
     $list1 = new BucketList(array('userName' => 'jwachter', 'userId' => '1', 'typeOf'=>'movie', 'title'=>'comedy'));
     $list1 -> setListId(1);
   	 $_SESSION = array('movieLists' => $movie1, 'base' => "wj_lab4",'user' => $s1, 'list' => $list1);
   	 ListView::show();
   	 $output = ob_get_clean();
   	 $this->assertFalse(empty($output), "It should show the user update form");
  }
  
 public function testShowAllMovies() {
     // Test that the showAll produces output for users
  	 ob_start();
     $movie1 = new MovieData(array('listId' => '1', 'type'=>'movie', 'title'=>'title', 'year'=>''));
     $movie1 -> setMovieId(1);
     $movie2 = new MovieData(array('listId' => '1', 'type'=>'movie', 'title'=>'title', 'year'=>''));
     $movie2 -> setMovieId(2);
     $_SESSION['movies'] = array($movie1, $movie2);
     $_SESSION['base'] = 'wj_lab4';
     $_SESSION['arguments'] = null;
     MovieDataView::showall();
     $output = ob_get_clean();
     $this->assertFalse(empty($output), "It should show the Users table");
  }
  
   public function tesMovieDetails() {
  	 ob_start();
     $movie1 = new MovieData(array('listId' => '1', 'type'=>'movie', 'title'=>'title', 'year'=>''));
     $movie1 -> setMovieId(1);
     $user = array('userId' => 1, 'userName' => 'jwachter', 'password' => 'superman', 'firstName'=>'bob', 'lastName'=>'smith', 'gender'=>'male', 'birthday'=>'2015-10', 'email'=>'a@a.com', 'phoneNumber'=>'555-555-5555');
     $s1 = new UserData($user);
     $list1 = new BucketList(array('userName' => 'jwachter', 'userId' => '1', 'typeOf'=>'movie', 'title'=>'comedy'));
     $list1 -> setListId(1);
   	 $_SESSION = array('movieLists' => $movie1, 'base' => "wj_lab4",'user' => $s1, 'list' => $list1);
   	 ListView::showDetails();
   	 $output = ob_get_clean();
   	 $this->assertFalse(empty($output), "It should show the user update form");
   }
 }
?>