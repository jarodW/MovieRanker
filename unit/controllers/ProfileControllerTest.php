<?php
require_once dirname ( __FILE__ ) . '\..\..\WebContent\controllers\ProfileController.class.php';
require_once dirname ( __FILE__ ) . '\..\..\WebContent\models\Database.class.php';
require_once dirname ( __FILE__ ) . '\..\..\WebContent\models\Messages.class.php';
require_once dirname ( __FILE__ ) . '\..\..\WebContent\models\UserData.class.php';
require_once dirname ( __FILE__ ) . '\..\..\WebContent\models\UserDataDB.class.php';
require_once dirname ( __FILE__ ) . '\..\..\WebContent\views\HomeView.class.php';
require_once dirname ( __FILE__ ) . '\..\..\WebContent\views\LoginView.class.php';
require_once dirname ( __FILE__ ) . '\..\..\WebContent\views\ProfileView.class.php';
require_once dirname ( __FILE__ ) . '\..\..\WebContent\views\MasterView.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\tests\DBMaker.class.php';
require_once dirname(__FILE__).'\..\models\DBMakerUnit.class.php';

class ProfileControllerTest extends PHPUnit_Framework_TestCase {
	/**
	 * @runInSeparateProcess
	 */
	public function testCallRunFromPost() {
		ob_start();
 	    DBMakerUnit::createDB('ptest');
		$_SERVER ["REQUEST_METHOD"] = "POST";
		$_POST =  array('userName' => 'jwachter', 'password' => 'superman', 'firstName'=>'bob', 'lastName'=>'smith', 'gender'=>'male', 'birthday'=>'2015-10', 'email'=>'a@a.com', 'phoneNumber'=>'555-555-5555');
		$_SESSION = array('base' => 'wj_lab4', 'action' => 'show', 'arguments' => null);
        ProfileController::run();
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
		$_SESSION = array('base' => 'wj_lab4', 'action' => 'show','control' =>'assignment', 'arguments' => null);

        ProfileController::run();
		$output = ob_get_clean ();
		$this->assertFalse ( empty ( $output ), "It should show something from a GET" );
	}
}

?>
