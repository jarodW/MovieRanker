<?php  
class ProfileView{
	
	public static function show() {
		$_SESSION['headertitle'] = "Profile View";
		MasterView::showHeader();
		MasterView::showNavBar();
		ProfileView::showDetails();
	} 	

	public static function showDetails(){
	   	$user = (array_key_exists('user', $_SESSION))?$_SESSION['user']:null;
	   	$base = (array_key_exists('base', $_SESSION))?$_SESSION['base']:"";
	   	
	   	echo '<div style="background:transparent !important" class="jumbotron">';
	   	echo '<section class ="text-center">';
		echo '<h1 class="text-center">'.$user->getUserName().'\'s Profile</h1>';
		echo'<section class="text-center">';
		echo '<p><strong>Name</strong><br> ';
		if (!is_null($user)) {
			echo ($user->getFirstName(). " " . $user->getLastName());}
		echo '</p><p><strong>Sex</strong><br>';
		if (!is_null($user)) {
			echo $user->getGender();}
		echo '</p><p><strong>Birthday</strong></br> ';
		if (!is_null($user)) {
			echo $user->getBirthday();}
		echo '</p><p><strong>Email</strong><br>';
		if (!is_null($user)) {
			echo $user->getEmail();}
		echo '</p><P><strong>Phone Number</strong><br>';
		if (!is_null($user)) {
			echo $user->getPhoneNumber();}
		echo '</p><br>';
		echo '<a href="/'.$base.'/profile/update/'.$user->getUserId().'"> Edit Profile</a>';
		echo'</section>';
		echo '</div>';
		echo '</div>';
	  }
	  
	 public static function showUpdate(){
	 	$users = (array_key_exists('users', $_SESSION))?$_SESSION['users']:null;
	 	$base = (array_key_exists('base', $_SESSION))?$_SESSION['base']:"";
	 	
	 	$_SESSION['headertitle'] = "Update Profile";
	 	MasterView::showHeader();
	 	MasterView::showNavBar();
	 	if (is_null($users) || empty($users) || is_null($users[0])) {
	 		echo '<section>User does not exist</section>';
	 		return;
	 	}
	 	echo '<div style="background:transparent !important" class="jumbotron">';
	 	echo '<section class ="text-center">';
	 	$user = $users[0];
	 	echo'<section class="text-center">';
		echo '<h1 class="text-center">'.$user->getUserName().'\'s Profile</h1>';
	 		echo '<p><strong>Name</strong><br> ';
		if (!is_null($user)) {
			echo ($user->getFirstName(). " " . $user->getLastName());}
		echo '</p><p><strong>Sex</strong><br>';
		if (!is_null($user)) {
			echo $user->getGender();}
		echo '</p><p><strong>Birthday</strong></br> ';
		if (!is_null($user)) {
			echo $user->getBirthday();}
	 	echo'</section>';
	 	if ($user->getErrors() > 0) {
			$errors = $user->getErrors();
			echo '<section><p>Errors:<br>';
			foreach($errors as $key => $value)
				echo $value . "<br>";
			echo '</p></section>';
		}
	 	
		echo '<section class ="text-center">';
		echo '<form method="post" action="/'.$base.'/profile/update/'.$user->getUserId().'" role="form">';	
		echo '<strong>Email</strong><br>';
		echo '<input type="email" name="email"';
		echo 'value = "'. $user->getEmail() .'"><br>';
	    echo '<strong>Phone Number <br>(xxx-xxx-xxxx)</strong><br>';
		echo '<input type="tel" name="phoneNumber"';
		echo 'value = "'. $user->getPhoneNumber() .'"><br>';
	    echo'<input type="submit" value="Submit"> </form>';
	    echo '</section>';
	    echo '</div>';
	    echo '</div>';
	 }
	 
	 public static function showAll() {
	 	// SHow a table of users with links
	 	

	 	if (array_key_exists('headertitle', $_SESSION)) {
	 		MasterView::showHeader();
	 		MasterView::showNavBar();
	 	}
	 	
	 	$users = (array_key_exists('users', $_SESSION))?$_SESSION['users']:array();
	 	$base = (array_key_exists('base', $_SESSION))?$_SESSION['base']:"";
	 	
	 	echo '<div style="background:transparent !important" class="jumbotron">';
	 	echo '<div class="container">';
	 	echo '<h1 class="text-center">User list</h1>';
	 	echo '<div class="table-responsive">';
	 	echo '<table class="table table-hover">';
	 	echo "<thead>";
	 	echo "<tr><th>User Id</th><th>User name</th><th>First name</th><th>Last name</th><th>Gender</th><th>Birthday</th><th>Email</th><th>Phone Number</th><th>List</th><th>Update</th></tr>";
	 	echo "</thead>";
	 	echo "<tbody>";
	 
	 	foreach($users as $user) {
	 		echo '<tr>';
	 		echo '<td>'.$user->getUserId().'</td>';
	 		echo '<td>'.$user->getUserName().'</td>';
	 		echo '<td>'.$user->getFirstName().'</td>';
	 		echo '<td>'.$user->getLastName().'</td>';
	 		echo '<td>'.$user->getGender().'</td>';
	 		echo '<td>'.$user->getBirthday().'</td>';
	 		echo '<td>'.$user->getEmail().'</td>';
	 		echo '<td>'.$user->getPhoneNumber().'</td>';
	 		echo '<td><a href="/'.$base.'/list/showUser/'.$user->getUserId().'">List</a></td>';
	 		if(!empty($_SESSION['authenticatedUser']))
	 		if($user->getUserId() == $_SESSION['authenticatedUser']->getUserId())
	 		echo '<td><a href="/'.$base.'/profile/update2/'.$user->getUserId().'">Update</a></td>';
	 		echo '</tr>';
	 	}
	 	echo "</tbody>";
	 	echo "</table>";
	 	echo "</div>";
	 	echo "</div>";
	 	if (array_key_exists('footertitle', $_SESSION))
	 		MasterView::showFooter();
	 }
	 
	 public static function showUser(){
	 	
	 }
}