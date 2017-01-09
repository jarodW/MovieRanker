<?php  
class ListView{
	
	public static function show() {
		$_SESSION['headertitle'] = "Profile View";
		MasterView::showHeader();
		MasterView::showNavBar();
		ListView::showDetails();
	}
	
	
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
	 	echo '<h1 class="text-center">Lists list</h1>';
	 	echo '<div class="table-responsive">';
	 	echo '<table class="table table-hover">';
	 	echo "<thead>";
	 	echo "<tr><th>List Id</th><th>User Name</th><th>Title</th><th>Type</th><th>List</th><th>Update</th></tr>";
	 	echo "</thead>";
	 	echo "<tbody>";
	 
	 	foreach($lists as $list) {
	 		echo '<tr>';
	 		echo '<td>'.$list->getListId().'</td>';
	 		echo '<td>'.$list->getUserName().'</td>';
	 		echo '<td>'.$list->getTitle().'</td>';
	 		echo '<td>'.$list->getTypeOf().'</td>';
	 		echo '<td><a href="/'.$base.'/movie/showMovies/'.$list->getListId().'">List</a></td>';
	 		if(!empty($_SESSION['authenticatedUser']))
	 		if($list->getUserId() == $_SESSION['authenticatedUser']->getUserId())
	 		echo '<td><a href="/'.$base.'/list/update/'.$list->getListId().'">Update</a></td>';
	 		echo '</tr>';
	 	}
	 	echo "</tbody>";
	 	echo "</table>";
	 	echo "</div>";
	 	echo "</div>";
	 	if (array_key_exists('footertitle', $_SESSION))
	 		MasterView::showFooter();
	 }
	 
	 public static function showUser() {
	 	MasterView::showHeader();
	 	MasterView::showNavBar();
	 	$user = (array_key_exists('user', $_SESSION))?$_SESSION['user']:null;
	 	$base = (array_key_exists('base', $_SESSION))?$_SESSION['base']:"";
	 	$userLists = (array_key_exists('userLists', $_SESSION))?$_SESSION['userLists']:array();
	 	echo '<div style="background:transparent !important" class="jumbotron">';
	 	echo '<div class="container">';
	 	if (is_null($user))
	 		echo '<p>Unknown user<p>';
	 	else {
	 		echo '<div class="container">';
	 		echo '<h1>List for '. $user->getUserName().'</h1>';
	 		echo '<section><h2>My Lists</h2>';
	 		echo '<ul class="list-group">';
	 		foreach ($userLists as $list) {
	 			echo '<li class="list-group-item"><a href="/'.$base.'/movie/showMovies/'.$list->getListId().'">'.$list->getTitle().'</a></li>';
	 		}
	 		echo '</ul></section>';
	 		echo "</div>";
	 		echo "</div>";
	 	}
	 }
	 
	 public static function showDetails() {
	 	$user = (array_key_exists('user', $_SESSION))?$_SESSION['user']:null;
	 	$base = (array_key_exists('base', $_SESSION))?$_SESSION['base']:"";
	 	$userLists = (array_key_exists('userLists', $_SESSION))?
	 	$_SESSION['userLists']:array();
	 	if (is_null($user))
	 		echo '<p>Unknown user<p>';
	 	else {
	 		echo '<div style="background:transparent !important" class="jumbotron">';
	 		echo '<div class="container">';
	 		echo '<section class ="text-center">';
	 		echo '<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo">Add List</button>';
	 		echo '<div id="demo" class="collapse out">';
	 		echo '<form action = "/'.$base.'/list/add/"'.$user->getUserId().' method="Post">';
	 		echo 'Title<br>';
	 		echo '<input type="text" name="title"><br>';
	 		echo '<select name = "typeOf">';
	 		echo '<option value="movie">Movie</option>';
	 		echo '<option value="series">Tv Show</option>';
	 		echo'</select>';
	 		echo '<input type="hidden" name="userId" value = "'.$user->getUserId().'">';
	 		echo '<input type="hidden" name="public" value = 0">';
	 		echo'<input type="submit" value="Submit"> </section> </form>';
	 		
	 		echo '<div class="row">';
	 		echo '<div class="col-sm-6">';
	 		echo '<div class="form-group">';
	 		echo '<section><h2 class = "text-center">Movie Lists</h2>';
	 		echo '<ul class="list-group text-center">';
	 		foreach ($userLists as $list) {
	 			if($list->getTypeOf() == 'movie'){
	 				echo '<li class="list-group-item"><a href="/'.$base.'/movie/show/'.$list->getListId().'">'.$list->getTitle().'</a>
	 				<a href="/'.$base.'/list/update2/'.$list->getListId().'"><span class="glyphicon glyphicon-edit"></span></a>';
	 			    if($list->getPublic() == 0){
	 					echo '<a href="/'.$base.'/list/remove/'.$list->getListId().'"><span class="glyphicon glyphicon-remove-sign"></span></a>';
	 				}
	 				else{
	 					echo '<a href="/'.$base.'/list/userNull/'.$list->getListId().'"><span class="glyphicon glyphicon-remove-sign"></span></a>';
	 				}
	 			echo '</li>';
	 			}
	 		}
	 		echo '</ul></section>';
	 		echo '</div>';
	 		echo '</div>';
	 		echo '<div class="col-sm-6">';
	 		echo '<div class="form-group text-center">';
	 		echo '<section><h2 class = "text-center">TV Lists</h2>';
	 		echo '<ul class="list-group">';
	 		foreach ($userLists as $list) {
	 			if($list->getTypeOf() == 'series'){
	 				echo '<li class="list-group-item"><a href="/'.$base.'/movie/show/'.$list->getListId().'">'.$list->getTitle().'</a>
	 				<a href="/'.$base.'/list/update2/'.$list->getListId().'"><span class="glyphicon glyphicon-edit"></span></a>';
	 			    if($list->getPublic() == 0){
	 					echo '<a href="/'.$base.'/list/remove/'.$list->getListId().'"><span class="glyphicon glyphicon-remove-sign"></span></a>';
	 				}
	 				else{
	 					echo '<a href="/'.$base.'/list/userNull/'.$list->getListId().'"><span class="glyphicon glyphicon-remove-sign"></span></a>';
	 				}
	 			echo '</li>';
	 			}
	 		}
	 		echo '</ul></section>';
	 		echo '</div>';
	 		echo '</div>';
	 		echo "</div>";
	 		echo "</div>";
	 		echo "</div>";
	 	}
	 }
	 
	 public static function showUpdate(){
	 	$lists = (array_key_exists('lists', $_SESSION))?$_SESSION['lists']:null;
	 	$base = (array_key_exists('base', $_SESSION))?$_SESSION['base']:"";
	 	 
	 	$_SESSION['headertitle'] = "Update List";
	 	MasterView::showHeader();
	 	MasterView::showNavBar();
	 	if (is_null($lists) || empty($lists) || is_null($lists[0])) {
	 		echo '<section>List does not exist</section>';
	 		return;
	 	}
	 	echo '<div style="background:transparent !important" class="jumbotron">';
	 	echo '<div class="container">';
	 	$list = $lists[0];
	 	echo '<h1>Your List</h1>';
	 	echo '<p>ListId: ';
	 	if (!is_null($list)) {echo ($list->getListId());}
	 	echo '</p> <p>User Name: ';
	 	if (!is_null($list)) {echo ($list->getUserName());}
	 	echo '</p> <p>Type: ';
	 	if (!is_null($list)) {echo ($list->getTypeOf());}

	 if ($list->getErrors() > 0) {
	 	$errors = $list->getErrors();
	 	echo '<section><p>Errors:<br>';
		 foreach($errors as $key => $value)
		 echo $value . "<br>";
		 echo '</p></section>';
	 }
	 
	 echo '<form method="post" action="/'.$base.'/list/update/'.$list->getListId().'">';
	 echo 'Title<br>';
	 echo '<input type="text" name="title"';
	 echo 'value = "'. $list->getTitle() .'"><br>';
	 echo'<input type="submit" value="Submit"> </form>';
	 echo "</div>";
	 echo "</div>";
	 }
	 
	 public static function showUpdate2(){
	 	$lists = (array_key_exists('lists', $_SESSION))?$_SESSION['lists']:null;
	 	$base = (array_key_exists('base', $_SESSION))?$_SESSION['base']:"";
	 
	 	$_SESSION['headertitle'] = "Update List";
	 	MasterView::showHeader();
	 	MasterView::showNavBar();
	 	if (is_null($lists) || empty($lists) || is_null($lists[0])) {
	 		echo '<section>List does not exist</section>';
	 		return;
	 	}
	 	echo '<div style="background:transparent !important" class="jumbotron">';
	 	echo '<div class="container">';
	 	$list = $lists[0];
	 	echo '<h1>List Title</h1>';
	 	echo '<form method="post" action="/'.$base.'/list/update2/'.$list->getListId().'">';
	 	echo 'Title<br>';
	 	echo '<input type="text" name="title"';
	 	echo 'value = "'. $list->getTitle() .'"><br>';
	 	echo'<input type="submit" value="Submit"> </form>';
	 	echo "</div>";
	 	echo "</div>";
	 }
}