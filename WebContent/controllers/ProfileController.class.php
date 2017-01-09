<?php
class ProfileController {
	public static function run() {
		// Perform actions related to a review
		$action = $_SESSION['action'];
		$arguments = $_SESSION['arguments'];
		switch ($action) {
			case "show":
				$users = UserDataDB::getUsersBy('userId', $arguments);
				$_SESSION['user'] = (!empty($users))?$users[0]:null;
				self::show();
				break;
			case "home":
				$users = UserDataDB::getUsersBy('userId', $arguments);
				$_SESSION['user'] = (!empty($users))?$users[0]:null;
				self::home();
				break;
			case "update":
				self::updateProfile();
				break;
			case "update2":
				self::updateProfile2();
				break;
			case  "showall":
				$_SESSION['users'] = UserDataDB::getUsersBy();
				$_SESSION['headertitle'] = "Show all users";
				$_SESSION['footertitle'] = "<h3>The footer goes here</h3>";
				ProfileView::showall();
				break;
			default:
		}
	}
	
	public static function home(){
			HomeView::show();
	}
	public static function show() {
		$arguments = (array_key_exists('arguments', $_SESSION))?$_SESSION['arguments']:0;
		$user = $_SESSION['user'];
		if(!is_null($user)){
			$_SESSION['user'] = $user;
		}	
		if (is_null($user) || $user->getErrorCount() != 0 || $user->getUserId() != $_SESSION['authenticatedUser']->getUserId()) {
			HomeView::show();
		}
		 else{  
			ProfileView::show();
		}
	}
	
	public static function updateProfile(){
		// Process updating review
		$users = UserDataDB::getUsersBy('userId', $_SESSION['arguments']);
		if (empty($users)|| $users[0]->getUserId() != $_SESSION['authenticatedUser']->getUserId()) {
			HomeView::show();
		} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
			$_SESSION['users'] = $users;
			$_SESSION['user'] = (!empty($users))?$users[0]:null;
			ProfileView::showUpdate();
		} else {
		
			$parms = $users[0]->getParameters();
			$parms['email'] = (array_key_exists('email', $_POST))? $_POST['email']:$users[0]->getEmail();
			$parms['phoneNumber'] = (array_key_exists('phoneNumber', $_POST))? $_POST['phoneNumber']:$users[0]->getPhoneNumber();
			$newProfile = new UserData($parms);
			$newProfile->setUserId($users[0]->getUserId());
			$user = UserDataDB::updateUser($newProfile);
		
			if ($user->getErrorCount() != 0) {
				$_SESSION['users'] = array($newProfile);
				ProfileView::showUpdate();
			} else {
				$_SESSION['user'] = $user;
				ProfileView::show();
				
			}
		}
	}
	
	public static function updateProfile2(){
		// Process updating review
		$users = UserDataDB::getUsersBy('userId', $_SESSION['arguments']);
		if (empty($users)|| $users[0]->getUserId() != $_SESSION['authenticatedUser']->getUserId()) {
			HomeView::show();
		} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
			$_SESSION['users'] = $users;
			ProfileView::showUpdate();
		} else {
	
			$parms = $users[0]->getParameters();
			$parms['email'] = (array_key_exists('email', $_POST))? $_POST['email']:$users[0]->getEmail();
			$parms['phoneNumber'] = (array_key_exists('phoneNumber', $_POST))? $_POST['phoneNumber']:$users[0]->getPhoneNumber();
			$newProfile = new UserData($parms);
			$newProfile->setUserId($users[0]->getUserId());
			$user = UserDataDB::updateUser($newProfile);
	
			if ($user->getErrorCount() != 0) {
				$_SESSION['users'] = array($newProfile);
				ProfileView::showUpdate();
			} else {
				$_SESSION['user'] = $user;
				ProfileView::show();
	
			}
		}
	}
}
?>