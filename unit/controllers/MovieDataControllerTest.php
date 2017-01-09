<?php
require_once dirname ( __FILE__ ) . '\..\..\WebContent\controllers\MovieDataController.class.php';
require_once dirname ( __FILE__ ) . '\..\..\WebContent\models\Database.class.php';
require_once dirname ( __FILE__ ) . '\..\..\WebContent\models\Messages.class.php';
require_once dirname ( __FILE__ ) . '\..\..\WebContent\models\UserData.class.php';
require_once dirname ( __FILE__ ) . '\..\..\WebContent\models\UserDataDB.class.php';
require_once dirname ( __FILE__ ) . '\..\..\WebContent\models\MovieDataDB.class.php';
require_once dirname ( __FILE__ ) . '\..\..\WebContent\models\MovieData.class.php';
require_once dirname ( __FILE__ ) . '\..\..\WebContent\models\ListDB.class.php';
require_once dirname ( __FILE__ ) . '\..\..\WebContent\views\HomeView.class.php';
require_once dirname ( __FILE__ ) . '\..\..\WebContent\views\MovieDataView.class.php';
require_once dirname ( __FILE__ ) . '\..\..\WebContent\views\LoginView.class.php';
require_once dirname ( __FILE__ ) . '\..\..\WebContent\views\ProfileView.class.php';
require_once dirname ( __FILE__ ) . '\..\..\WebContent\views\ListView.class.php';
require_once dirname ( __FILE__ ) . '\..\..\WebContent\views\MasterView.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\tests\DBMaker.class.php';
require_once dirname(__FILE__).'\..\models\DBMakerUnit.class.php';

class MovieControllerTest extends PHPUnit_Framework_TestCase {
	/**
	 * @runInSeparateProcess
	 */
	public function testCallRunFromPost() {
		ob_start();
 	    DBMakerUnit::createDB('ptest');
		$_SERVER ["REQUEST_METHOD"] = "POST";
		$_POST =  array('listId' => '1', 'type'=>'movie', 'title'=>'title', 'year'=>'');
		$_SESSION = array('base' => 'wj_lab4', 'action' => 'show', 'arguments' => null);
        MovieDataController::run();
		$output = ob_get_clean();
		$this->assertFalse ( empty ( $output ), "It should show something from a POST" );
	}
	
	/**
	 * @runInSeparateProcess
	 */
	public function testCallRunFromGet() {
		ob_start ();
 	    DBMakerUnit::createDB('ptest');
		$_SERVER ["REQUEST_METHOD"] = "GET";
		$_SESSION = array('base' => 'wj_lab4', 'action' => 'show', 'control' =>'assignment','arguments' => null);

        MovieDataController::run();
		$output = ob_get_clean ();
		$this->assertFalse ( empty ( $output ), "It should show something from a GET" );
	}
}

?>
