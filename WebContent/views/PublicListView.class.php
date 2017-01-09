<?php  
class PublicListView{
	 
	 public static function showAll() {
	 	// SHow a table of users with links
	 	if (array_key_exists('headertitle', $_SESSION)) {
	 		MasterView::showHeader();
	 		MasterView::showNavBar();
	 	}
	 	$lists = (array_key_exists('lists', $_SESSION))?$_SESSION['lists']:array();
	 	$base = (array_key_exists('base', $_SESSION))?$_SESSION['base']:"";
   		echo '<div style="background:transparent !important" class="jumbotron">';
   		echo '<div class="container">';
	 	echo '<h3 class="text-center">Public list</h3>';
	 	echo '<div class="table-responsive">';
	 	echo '<table class="table table-hover">';
	 	echo "<thead>";
	 	echo "<tr><th>Points</th><th>Title</th><th>Type</th></tr>";
	 	echo "</thead>";
	 	echo "<tbody>";
	 	echo '<div class="col-sm-6">';
	 	foreach($lists as $list) {
	 		echo '<tr>';
	 		echo '<td>'.$list->getPoints().'</td>';
	 		echo '<td><a href="/'.$base.'/movie/showMovies/'.$list->getListId().'">'.$list->getTitle().'</a></td>';
	 		echo '<td>'.$list->getType().'</td>';
	 		echo '</tr>';
	 	}
	 	echo '</div>';
	 	echo "</tbody>";
	 	echo "</table>";
	 	echo "</div>";
	 	echo "</div>";
	
	 }
	 
	 public static function showLoggedIn() {
	 	// SHow a table of users with links
	 	$user = (array_key_exists('user', $_SESSION))?$_SESSION['user']:null;
	 	 
	 	if (array_key_exists('headertitle', $_SESSION)) {
	 		MasterView::showHeader();
	 		MasterView::showNavBar();
	 	}
	 	$user = (array_key_exists('user', $_SESSION))?$_SESSION['user']:null;
	 	$lists = (array_key_exists('lists', $_SESSION))?$_SESSION['lists']:array();
	 	$base = (array_key_exists('base', $_SESSION))?$_SESSION['base']:"";
	 	echo '<div style="background:transparent !important" class="jumbotron">';
	 	echo '<div class="container">';
	 	echo '<h3 class="text-center">Public list</h3>';
	 	echo '<div class="table-responsive">';
	 	echo '<table class="table table-hover">';
	 	echo "<thead>";
	 	echo "<tr><th>Points</th><th>Title</th><th>Type</th></tr>";
	 	echo "</thead>";
	 	echo "<tbody>";
	 	foreach($lists as $list) {
	 		$vote = PublicListDB::getVote($list->getPublicListId(),$user->getUserId());
	 		$colorUP;
	 		$colorDown;
	 		if(!empty($vote)&&$vote[0]['point'] == 1){
	 			$colorUp = ' upvote ';
	 			$colorDown = ' novote ';
	 		}
	 		elseif(!empty($vote)&&$vote[0]['point'] == -1){
	 			$colorUp = ' novote ';
	 			$colorDown = ' downvote ';
	 		}
	 		else{
	 			$colorUp = ' novote ';
	 			$colorDown = ' novote ';;
	 		}
	 		echo '<tr>';
	 		echo '<td>'. '<a href="/'.$base.'/public/plus/'.$list->getPublicListId().'"><span class="glyphicon glyphicon-arrow-up '.$colorUp.'"></span></a>'.
	 		$list->getPoints().
	 		'<a href="/'.$base.'/public/minus/'.$list->getPublicListId().'"><span class="glyphicon glyphicon-arrow-down'.$colorDown.'"></span></a>'.
	 		'</td>';
	 		echo '<td><a href="/'.$base.'/movie/showLoggedInMovies/'.$list->getListId().'">'.$list->getTitle().'</a></td>';
	 		echo '<td>'.$list->getType().'</td>';
	 		echo '</tr>';
	 	}
	 	echo "</tbody>";
	 	echo "</table>";
	 	echo "</div>";
	 	echo "</div>";
	 
	 }
}?>