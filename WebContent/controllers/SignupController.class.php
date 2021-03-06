<?php
class SignupController {

	public static function run() {
		$user = null;
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$user = new UserData($_POST);
			$users = UserDataDB::getUsersBy('userName',$user->getUserName());
			if(!empty($users))
				$user->setError('userName','USER_NAME_ALREADY_EXIST');
		}
		
		$_SESSION['user'] = $user;
		if (is_null($user) || $user->getErrorCount() != 0){ 
			SignupView::show();
		} 
		else{  // Initial link
		   $user = UserDataDB::addUser($user);
		   $users = UserDataDB::getUsersBy('userName', $user->getUserName());
		   $_SESSION['authenticatedUser'] = $users[0];
		   HomeView::show();
		   header('Location: /'.$_SESSION['base']);
		}
		
	}
}
?>