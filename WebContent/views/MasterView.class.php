<?php
class MasterView {
	public static function showHeader() {
        echo '<!DOCTYPE html lang="en"><html><head>';
        echo '<meta charset="utf-8">';
        echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
        echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
        echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>';
        echo '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>';
        echo '<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>';
        echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">';
        echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">';
        echo '<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">';
        echo '<script src="/wj_project/js/jquery-1.10.2.js"></script>';
        echo '<script src="/wj_project/js/jquery-ui.js"></script>';
        echo '<script src="/wj_project/js/datePicker.js"></script>';
        echo '<script src="/wj_project/js/userName.js"></script>';
        
        $styles = (array_key_exists('styles', $_SESSION))? $_SESSION['styles']: array();
        $base = (array_key_exists('base', $_SESSION))? $_SESSION['base']: "";
        echo '<link rel="stylesheet" href="/'.$base.'/css/jumbotron.css">';
        echo '<link rel="stylesheet" href="/'.$base.'/css/active.css">';
        foreach ($styles as $style ) 
           echo '<link href="/'.$base.'/css/'.$style. '" rel="stylesheet">';
        $title = (array_key_exists('headertitle', $_SESSION))? $_SESSION['headertitle']: "";
        echo "<title>$title</title>";
        echo "</head><body>";
    }
    
    /*public static function showNavBar() {
    	// Show the navbar
    	echo "<nav>";
    	$user = (array_key_exists('user', $_SESSION))?$_SESSION['user']:null;
    	if (!is_null($user))
    	   echo "Hello ". $user->getUserName()." <br>";
    	echo "</nav>";
    }*/

    public static function showNavBar() {
    	// Show the navbar
    	$base = (array_key_exists('base', $_SESSION))? $_SESSION['base']: "";
    	$authenticatedUser = (array_key_exists('authenticatedUser', $_SESSION))?$_SESSION['authenticatedUser']:null;
    	$user = (array_key_exists('user', $_SESSION))?$_SESSION['user']:null;
    	echo '<nav class="navbar navbar-inverse navbar-fixed-top">';
    	echo '<div class="container-fluid">';
    	echo '<div class="navbar-header">';
    	echo '<button type="button" class="navbar-toggle collapsed"';
    	echo 'data-toggle="collapse" data-target="#navbar"';
    	echo 'aria-expanded="false" aria-controls="navbar">';
    	echo '<span class="icon-bar"></span>';
    	echo '<span class="icon-bar"></span>';
    	echo '<span class="icon-bar"></span>';
    	echo '</button>';
    	echo '<a class="navbar-brand" href="/'.$base.'"index.html" >Prioiritize It!</a>';
    	echo '</div>';
    	echo '<div id="navbar" class="navbar-collapse collapse">';
    	echo '<ul class="nav navbar-nav">';
    	if (is_null($authenticatedUser))
    		echo '<li class="active"><a href="/'.$base.'"index.html>Home</a></li>';
    	else
    		echo '<li class="active"><a href="/'.$base.'/profile/home/'.$user->getUserId().'">Home</a></li>';	
    	if (is_null($authenticatedUser)){
    	echo '<li><a a href="/'.$base.'/signup">SignUp</a></li>';
    	echo '<li><a a href="/'.$base.'/public/showall">Public Lists</a></li>';
    	}
    	if (!is_null($authenticatedUser)){
    	echo '<li><a href="/'.$base.'/profile/show/'.$user->getUserId().'">Profile</a></li>';
    	echo '<li><a href="/'.$base.'/list/show/'.$user->getUserId().'">My List</a></li>';
    	echo '<li><a a href="/'.$base.'/public/showLoggedIn/">Public Lists</a></li>';
    	}
    	echo '</ul>';
    	
    	
    	if (!is_null($authenticatedUser)) {
    		echo '<form class="navbar-form navbar-right"
    			    method="post" action="/'.$base.'/logout">';
    		echo '<div class="form-group">';
    		echo '<span class="label label-default">Hi '.
    				$authenticatedUser->getUserName().'</span>&nbsp; &nbsp;';
    		echo '</div>';
    		echo '<button type="submit" class="btn btn-success">Sign out</button>';
    		echo '</form>';
    	} else {
    		echo '<form class="navbar-form navbar-right" method="post" action="/'.$base.'/login">';
    		echo '<div class="form-group">';
    		echo '<input type="text" placeholder="User name" class="form-control" name ="userName" ';
    		/*if (!is_null($user))
    			echo 'value = "'. $user->getUserName();*/
    		echo 'required></div>';
    		echo '<div class="form-group">';
    		echo '<input type="password" placeholder="Password"
	    			      class="form-control" name ="password">';
    		echo '</div>';
    		echo '<button type="submit" class="btn btn-success">Sign in</button>';
    		echo '</form>';
    
    	}
    	echo '</div>';
    	echo '</div>';
    	echo '</div>';
    	echo '</nav>';
    }
    
    
	public static function showFooter() {
		$footer = (array_key_exists('footertitle', $_SESSION))?
		           $_SESSION['footertitle']: "";
		echo $footer;
		echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>';
		echo '<script src="../../dist/js/bootstrap.min.js"></script>';
		echo '<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>';
        echo "</body></html>"; 
    }
}
?>