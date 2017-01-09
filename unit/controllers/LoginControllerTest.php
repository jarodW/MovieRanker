<?php
require_once dirname ( __FILE__ ) . '\..\..\WebContent\controllers\LoginController.class.php';
require_once dirname ( __FILE__ ) . '\..\..\WebContent\models\Database.class.php';
require_once dirname ( __FILE__ ) . '\..\..\WebContent\models\Messages.class.php';
require_once dirname ( __FILE__ ) . '\..\..\WebContent\models\UserData.class.php';
require_once dirname ( __FILE__ ) . '\..\..\WebContent\models\UserDataDB.class.php';
require_once dirname ( __FILE__ ) . '\..\..\WebContent\views\HomeView.class.php';
require_once dirname ( __FILE__ ) . '\..\..\WebContent\views\LoginView.class.php';
require_once dirname ( __FILE__ ) . '\..\..\WebContent\views\MasterView.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\tests\DBMaker.class.php';
require_once dirname(__FILE__).'\..\models\DBMakerUnit.class.php';

class LoginControllerTest extends PHPUnit_Framework_TestCase {
	/**
	 * @runInSeparateProcess
	 */
	public function testCallRunFromPost() {
		ob_start();
 	    DBMakerUnit::createDB('ptest');
		Database::clearDB ();
		$_SERVER ["REQUEST_METHOD"] = "POST";
		$_POST = array ("userName" => "jwachter", "password" => "superman");
		$_SESSION = array('base' => 'wj_lab4');
        LoginController::run();
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
		$_SESSION = array('base' => 'wj_lab4');

        LoginController::run();
		$output = ob_get_clean ();
		$this->assertFalse ( empty ( $output ), "It should show something from a GET" );
	}
}

?>
