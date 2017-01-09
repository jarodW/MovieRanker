<?php
require_once dirname(__FILE__).'\..\..\WebContent\models\BucketList.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\ListDB.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\Configuration.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\Database.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\Messages.class.php';

require_once dirname(__FILE__).'\..\..\WebContent\models\MovieData.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\MovieDataDB.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\UserData.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\UserDataDB.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\tests\DBMaker.class.php';
require_once dirname(__FILE__).'\DBMakerUnit.class.php';

class ListDBTest extends PHPUnit_Framework_TestCase {
	
  public function testGetAllAssignments() {
  	  DBMakerUnit::createDB('ptest');
  	  $lists = ListDB::getListsBy();
  	  $this->assertEquals(3, count($lists), 
  	  		'It should fetch all of the assignments in the test database');

  	  foreach ($lists as $list) 
          $this->assertTrue(is_a($list, 'BucketList'), 
        		'It should return valid List objects');
  }
  
  public function testInsertValidAssignment() {
    DBMakerUnit::createDB('ptest');
  	$beforeCount = count(ListDB::getListsBy());
  	$validTest = array('userId' => '1', 'typeOf'=>'movie', 'title'=>'crime');
  	$s1 = new BucketList($validTest);
  	$list = ListDB::addList($s1);
  	$this->assertTrue(!is_null($list), 'The inserted list should not be null');
  	$this->assertTrue(empty($list->getErrors()), 'The returned list should not have errors');
  	$afterCount = count(ListDB::getListsBy());
  	$this->assertEquals($afterCount, $beforeCount + 1,
  			'The database should have one more assignment after insertion');
  }
  

  

  public function testGetAssignmentByAssignmentOwnerName() {
  	DBMakerUnit::createDB('ptest');
    $lists = ListDB::getListsBy('userName', 'jwachter');
    $this->assertEquals(count($lists), 2, 'jwachter should have one assignment');
    foreach($lists as $list) {
    	$this->assertTrue(is_a($list, "BucketList"),
    			'The returned values should be BucketList objects');
    	$this->assertTrue(empty($list->getErrors()), 
    			"The returned lists should have no errors");
    }
  }
  
  public function testInsertDuplicateList() {
  	DBMakerUnit::createDB('ptest');
  	$beforeCount = count(ListDB::getListsBy());
  	$duplicateTest =  	$validTest = array('userId' => '1', 'typeOf'=>'movie', 'title'=>'crime');
  	$s1 = new BucketList($duplicateTest);
  	$list = ListDB::addList($s1);
  	$this->assertTrue(!is_null($list), 'The returned review should not be null');
  	$this->assertTrue(!empty($list->getErrors()), 'The returned review should have errors');
  	$afterCount = count(ListDB::getListsBy());
  	$this->assertEquals($afterCount, $beforeCount,
  			'The database should have the same number of reviews after trying to insert duplicate');
  }
  
  /*public function testUpdateReview() {
  	DBMakerUnit::createDB('ptest');
  	$beforeCount = count(ReviewsDB::getReviewsBy());
  	$reviews = ReviewsDB::getReviewsBy('reviewId', 1);
  	$currentReview = $reviews[0];
  	$parms = $currentReview->getParameters();
  	$parms['review'] = 'new review text';
  	$newReview = new Review($parms);
  	$newReview->setReviewId($currentReview->getReviewId());
  	$updatedReview = ReviewsDB::updateReview($newReview);
  	$afterCount = count(ReviewsDB::getReviewsBy());
  	$this->assertEquals($beforeCount, $afterCount,
  			'The number of reviews in the database should not change after update');
  	$this->assertEquals($updatedReview->getReviewId(), $newReview->getReviewId(),
  			'The id of the updated review should remain the same');
  }*/
  
  
}
?>