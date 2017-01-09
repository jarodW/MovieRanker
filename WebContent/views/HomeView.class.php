<?php
class HomeView {
  public static function show() { 
  	  $_SESSION['headertitle'] = "Home Page";
	  MasterView::showHeader();
	  MasterView::showNavBar();
	  HomeView::showDetails();
	  $_SESSION['footertitle'] = "";
      MasterView::showFooter();
  }

   public static function showDetails() {
   		$user = (array_key_exists('user', $_SESSION))?$_SESSION['user']:null;
   		$base = $_SESSION['base'];
   		echo '<div style="background:transparent !important" class="jumbotron">';
   		echo '<div class="container">';
   		if(empty($_SESSION['authenticatedUser']))
   			echo '<a href="/'.$base.'/signup"><img src = "http://10.242.148.195/wj_lab2/resources/logo.png" alt ="Logo" class ="center-block"></a>';
   		else
   			echo '<a href="/'.$base.'/list/show/'.$user->getUserId().'"><img src = "http://10.242.148.195/wj_lab2/resources/logo.png" alt ="Logo" class ="center-block"></a>';
		echo '<section> <h2 class ="text-center">Overview</h2>';	
		echo '<p class ="text-center">This website allows users to prioritize various forms of entertainment.</p> <aside>';
		echo '<p class ="text-center">You can prioritize movies and tv shows.</p> </aside> </section>';
		echo '</div>';
		echo '</div>';
     	echo '<div class="container">';
      	echo '<div class="row">';
		/*if(!is_null($user) && !empty($user)){ echo '<a href="/'.$base.'/profile/show/'.$user->getUserId().'">   Profile</a>  ';}
		echo '</div>';
		echo '<div class="col-md-3">';
		if(!is_null($user) && !empty($user)){echo '<a href="/'.$base.'/list/show/'.$user->getUserId().'">   My Lists</a>  ';}
		echo '</div>';*/
		echo '</div>';
		echo '</div>';
	}
}
?>