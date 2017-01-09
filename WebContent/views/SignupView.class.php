<?php  
class SignupView{
	
	public static function show() {
		$_SESSION['headertitle'] = "Login Form";
		MasterView::showHeader();
		MasterView::showNavBar();
		SignupView::showDetails();
	}
	public static function showDetails(){
			
		$user = (array_key_exists('user', $_SESSION))?$_SESSION['user']:null;
		$base = (array_key_exists('base', $_SESSION))?$_SESSION['base']:"";
		echo '<div style="background:transparent !important" class="jumbotron">';
	    echo '<section class ="text-center">';
		echo '<h1>Sign Up</h1>';
		echo '<form action="signup" method="Post" role="form">';
		echo '<div class="form-inline">';
		echo  '<label for="name">Name</label><br>'; 
		echo '<input type="text" class="form-control" name="firstName" placeholder="First Name"'; 
		if (!is_null($user)) {echo 'value = "'. $user->getFirstName() .'"';}
		echo '>';
		echo '<input type="text" name="lastName" class="form-control" placeholder="Last Name"';
		if (!is_null($user)) {echo 'value = "'. $user->getLastName() .'"';}
		echo '> <span class="error">';
		if(!is_null($user)) {echo $user->getError('firstName');}
		echo '</span> <span class="error">';
        if(!is_null($user)) {echo $user->getError('lastName');}
        echo '<br> </span> <br>';
        echo '</div>';
        echo '<div class="form-inline">';
		echo  '<label for="userName">User Name</label><br>';
	    echo '<input type="text" name="userName" placeholder="User Name" class="form-control" onkeyup="showHint(this.value)"'; 
	    if (!is_null($user)) {echo 'value = "'. $user->getUserName() .'"';}
	    echo '> <span class="error">';
		if(!is_null($user)) {echo $user->getError('userName');}
		echo '<br> </span> <br>';
		echo '<span id="txtHint"></span>';
        echo '<div class="form-inline">';
		echo  '<label for="password">Password</label><br>';
		echo '<input type="password" name="password" placeholder="password" class="form-control"'; 
		if (!is_null($user)) {echo 'value = "'. $user->getPassword() .'"';}
		echo '> <span class="error">';
		if(!is_null($user)) {echo $user->getError('password');}
		echo '<br> </span> <br>';
        echo '<div class="form-inline">';
		echo '<label for="email">Email</label><br>';
		echo '<input type="email" name="email" placeholder="email" class="form-control"';
		if (!is_null($user)) {echo 'value = "'. $user->getEmail() .'"';}
		echo '> <span class="error">';
		if(!is_null($user)) {echo $user->getError('email');}
		echo '<br> </span> <br>';
	    echo '<div class="form-inline">';
	    echo '<label for="phoneNumber">Phone Number(xxx-xxx-xxxx)</label><br>';
		echo '<input type="tel" name="phoneNumber" placeholder="xxx-xxx-xxxx" class="form-control"';
		if (!is_null($user)) {echo 'value = "'. $user->getPhoneNumber() .'"';}
		echo '> <span class="error">';
	    if(!is_null($user)) {echo $user->getError('phoneNumber');}
	    echo '<br> </span> <br>';
		echo '<strong>Gender</strong><br>';
		echo '<label class="radio-inline">';
		echo '<input type="radio"';
		if(!is_null($user) && $user->getGender() == "male") {echo 'checked = ""';}
		echo 'value ="male" name="gender"> Male';
		echo '</label>';
		echo '<label class="radio-inline">';
		echo '<input type="radio"'; 
		if(!is_null($user) && $user->getGender() == "female") {echo 'checked = ""';} 
		echo 'value="female" name="gender"> Female';
		echo '</label>';
		echo '<span class="error">';
		if(!is_null($user)) {echo $user->getError('gender');}
		echo '<br> </span>';
		echo '<div class="form-group">';
		echo '<strong>Birthday</strong><br>';
		echo '<input type="text" name="birthday" id = "datepicker" class="form-control"'; 
		if (!is_null($user)) {echo 'value = "'. $user->getBirthday() .'"';}
		echo '> <br>';
		echo '<span class="error">';
		if(!is_null($user)) {echo $user->getError('birthday');}
		echo '<br> </span>';
		echo '</div><br>';
		echo'<input type="submit" value="Submit" class="btn btn-default"> </form>';
		echo '</section>';
		echo '</div>';
	}
}
?>