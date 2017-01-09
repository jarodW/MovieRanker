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

class MovieDataDBTest extends PHPUnit_Framework_TestCase {
	
  public function testGetAllAssignments() {
  	  DBMakerUnit::createDB('ptest');
  	  $movies = MovieDataDB::getMoviesBy();
  	  $this->assertEquals(4, count($movies), 
  	  		'It should fetch all of the movies in the test database');

  	  foreach ($movies as $movie) 
          $this->assertTrue(is_a($movie, 'MovieData'), 
        		'It should return valid List objects');
  }
  
  public function testInsertValidAssignment() {
    DBMakerUnit::createDB('ptest');
  	$beforeCount = count(MovieDataDB::getMoviesBy());
  	$validTest = array('listId' => '2','title'=>'Scream', 'year'=>'1999', 'type' => 'movie');
  	$s1 = new MovieData($validTest);
  	$movie = MovieDataDB::addMovie($s1);
  	$this->assertTrue(!is_null($movie), 'The inserted movie should not be null');
  	$this->assertTrue(empty($movie->getErrors()), 'The returned movie should not have errors');
  	$afterCount = count(MovieDataDB::getMoviesBy());
  	$this->assertEquals($afterCount, $beforeCount + 1,
  			'The database should have one more assignment after insertion');
  }
  

  

  public function testGetMoviesByListId() {
  	DBMakerUnit::createDB('ptest');
    $movies = MovieDataDB::getMoviesBy('listId', '1');
    $this->assertEquals(count($movies), 1, '1 should have one assignment');
    foreach($movies as $movie) {
    	$this->assertTrue(is_a($movie, "MovieData"),
    			'The returned values should be BucketList objects');
    	$this->assertTrue(empty($movie->getErrors()), 
    			"The returned lists should have no errors");
    }
  }
}
?>