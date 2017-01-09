<?php  
class MovieDataView{
	
	public static function show() {
		$_SESSION['headertitle'] = "MovieData View";
		MasterView::showHeader();
		MasterView::showNavBar();
		MovieDataView::showDetails();
		MasterView::showFooter();
	}
	
	
	 public static function showAll() {
	 	// SHow a table of users with links
	 	if (array_key_exists('headertitle', $_SESSION)) {
	 		MasterView::showHeader();
	 		MasterView::showNavBar();
	 	}
	 	$movies = (array_key_exists('movies', $_SESSION))?$_SESSION['movies']:array();
	 	$base = (array_key_exists('base', $_SESSION))?$_SESSION['base']:"";
	 	echo '<div style="background:transparent !important" class="jumbotron">';
	 	echo '<div class="container">';
	 	echo '<h1 class ="text-center">Entertainment list</h1>';
	 	echo '<div class="table-responsive">';
		echo '<table class="table table-hover">';
	 	echo "<thead>";
	 	echo '<tr><th>Movie Id</th><th>List Id</th><th>Poster</th><th>Title</th><th>Director/s</th><th>'.'<img src="/'.$base.'/resources/imdb.png'.'" alt="HTML5 Icon" style="width:42px;height:20px">'.'</th><th>Update</th></tr>';
	 	echo "</thead>";
	 	echo "<tbody>";
	 
	 	foreach($movies as $movie) {
	 		echo '<tr>';
	 		echo '<td>'.$movie->getMovieId().'</td>';
	 		echo '<td>'.$movie->getListId().'</td>';
	 		echo '<td>'.'<img src = "'.$movie->getMovieInfo()->Poster.'"height="42" width="42">'.'</td>';
	 		echo '<td>'.'<a href="http://www.imdb.com/title/'.$movie->getMovieInfo()->imdbID.'">'.$movie->getTitle().'</td>';
	 		echo '<td>'.$movie->getDirector().'</td>';
	 		echo '<td>'.$movie->getImdbRating().'</td>';
	 		if(!empty($_SESSION['authenticatedUser']))
			if($movie->getUserId() == $_SESSION['authenticatedUser']->getUserId())
	 		echo '<td><a href="/'.$base.'/movie/update/'.$movie->getMovieId().'">Update</a></td>';
	 		echo '</tr>';
	 	}
	 	echo "</tbody>";
	 	echo "</table>";
	 	echo "</div>";
	 	echo "</div>";
	 	if (array_key_exists('footertitle', $_SESSION))
	 		MasterView::showFooter();
	 }
	 
	 public static function showList() {
	 	MasterView::showHeader();
	 	MasterView::showNavBar();
	 	$user = (array_key_exists('user', $_SESSION))?$_SESSION['user']:null;
	 	$base = (array_key_exists('base', $_SESSION))?$_SESSION['base']:"";
	 	$list = (array_key_exists('list', $_SESSION))?$_SESSION['list']:"";
	 	$movieLists = (array_key_exists('movieLists', $_SESSION))?
	 	$_SESSION['movieLists']:array();
	 	if (is_null($movieLists))
	 		echo '<p>List does not exist<p>';
	 	else {
	 		echo '<div style="background:transparent !important" class="jumbotron">';
	 		echo '<div class="container">';
	 		echo '<h2 class ="text-center">'.$list->getTitle().'</h2>';
	 		echo '<div class="table-responsive">';
			echo '<table class="table table-hover">';
	 		echo "<thead>";
	 		echo '<tr><th>Rank</th><th>Poster</th><th>Title</th><th>'.'<img src="/'.$base.'/resources/tomatoesLogo.png'.'" alt="HTML5 Icon" style="width:42px;height:20px">'.'</th><th>'.'<img src="/'.$base.'/resources/imdb.png'.'" alt="HTML5 Icon" style="width:42px;height:20px">'.'</th></tr>';
	 		echo "</thead>";
	 		
	 		echo "<tbody>";
	 		foreach ($movieLists as $movie) {
	 		echo '<tr>';
	 		echo '<td>'.$movie->getRank().'</td>';
	 		echo '<td>'.'<img src = "'.$movie->getMovieInfo()->Poster.'"height="42" width="42">'.'</td>';
	 		if($movie->getMovieInfo()->Website != 'N/A')
	 			echo '<td>'.'<a href="'.$movie->getMovieInfo()->Website.'">'.$movie->getTitle().'</a></td>';
	 		else
	 			echo '<td>'.'<a href="http://www.imdb.com/title/'.$movie->getMovieInfo()->imdbID.'">'.$movie->getTitle().'</a></td>';
	 		if($movie->getType() == 'movie'){
	 			$movieTitle  = str_replace(' ', '_', $movie->getTitle());
	 			$url = '<a href="http://www.rottentomatoes.com/m/'.$movieTitle.'">';
	 		}
	 		else{
	 			$movieTitle  = str_replace(' ', '-', $movie->getTitle());
	 			$url = '<a href="http://www.rottentomatoes.com/tv/'.$movieTitle.'">';
	 		}
	 		echo '<td>';
	 		if($movie->getMovieInfo()->tomatoImage == "certified")
	 			echo $url.'<img src="/'.$base.'/resources/certified.png'.'" alt="HTML5 Icon""></a>';
	 		if($movie->getMovieInfo()->tomatoImage == "rotten")
	 			echo $url.'<img src="/'.$base.'/resources/rotten.png'.'" alt="HTML5 Icon""></a>';
	 		if($movie->getMovieInfo()->tomatoImage == "fresh")
	 			echo $url.'<img src="/'.$base.'/resources/fresh.png'.'" alt="HTML5 Icon""></a>';
	 		echo $url.$movie->getMovieInfo()->tomatoMeter.'</a>';
	 		echo '</td>';
	 		echo '<td><a href="http://www.imdb.com/title/'.$movie->getMovieInfo()->imdbID.'">'.$movie->getImdbRating().'</a></td>';
	 		echo '</tr>';
	 		}
	 		echo "</tbody>";
	 		echo "</table>";
	 		echo "</div>";
	 		echo "</div>";

	 	}

	 }
	 
	 public static function showLoggedInList() {
	 	MasterView::showHeader();
	 	MasterView::showNavBar();
	 	$user = (array_key_exists('user', $_SESSION))?$_SESSION['user']:null;
	 	$base = (array_key_exists('base', $_SESSION))?$_SESSION['base']:"";
	 	$list = (array_key_exists('list', $_SESSION))?$_SESSION['list']:"";
	 	$movieLists = (array_key_exists('movieLists', $_SESSION))?
	 	$_SESSION['movieLists']:array();
	 	if (is_null($movieLists))
	 		echo '<p>List does not exist<p>';
	 	else {
	 		echo '<div style="background:transparent !important" class="jumbotron">';
	 		echo '<div class="container">';
	 		echo '<section class ="text-center">';
	 		echo'<!-- Small modal -->
				 <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm">Use List</button>
				 <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                 <div class="modal-dialog modal-sm">
                 <div class="modal-content">
  			     <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal">
                 <span aria-hidden="true">&times;</span>
                 <span class="sr-only">Close</span>
                 </button>
  			     </div>
	 		
  				 <div class="modal-body">
  				 <p> Are you sure you want to use this list?</p>
                 <form role="form"  action ="/'.$base.'/list/adoptList/'.$list->getListId().'" method = "post">
                 <input type="text" name="title" value ="'.$list->getTitle().'">
                 <input type="hidden" name="public" value = 0>
                 <input type="hidden" name="typeOf" value ="'.$list->getTypeOf().'">
                 <input type="hidden" name="userId" value ="'.$user->getUserId().'">
                 <br>
                 <button type="submit" class="btn btn-success inline">Submit</button>
                 <button type="button" class="btn btn-danger inline"data-dismiss="modal">Close </button>
                 </form>
                 </div>
	 		
	 		
                 </div>
                 </div>
                 </div>
                 </section>';
	 		
	 		echo '<h2 class ="text-center">'.$list->getTitle().'</h2>';
	 		echo '<div class="table-responsive">';
	 		echo '<table class="table table-hover">';
	 		echo "<thead>";
	 		echo '<tr><th>Rank</th><th>Poster</th><th>Title</th><th>'.'<img src="/'.$base.'/resources/tomatoesLogo.png'.'" alt="HTML5 Icon" style="width:42px;height:20px">'.'</th><th>'.'<img src="/'.$base.'/resources/imdb.png'.'" alt="HTML5 Icon" style="width:42px;height:20px">'.'</th></tr>';
	 		echo "</thead>";
	 
	 		echo "<tbody>";
	 		foreach ($movieLists as $movie) {
	 			echo '<tr>';
	 			echo '<td>'.$movie->getRank().'</td>';
	 			echo '<td>'.'<img src = "'.$movie->getMovieInfo()->Poster.'"height="42" width="42">'.'</td>';
	 			echo '<td>'.'<a href="http://www.imdb.com/title/'.$movie->getMovieInfo()->imdbID.'">'.$movie->getTitle().'</td>';
	 		if($movie->getType() == 'movie'){
	 			$movieTitle  = str_replace(' ', '_', $movie->getTitle());
	 			$url = '<a href="http://www.rottentomatoes.com/m/'.$movieTitle.'">';
	 		}
	 		else{
	 			$movieTitle  = str_replace(' ', '-', $movie->getTitle());
	 			$url = '<a href="http://www.rottentomatoes.com/tv/'.$movieTitle.'">';
	 		}
	 		echo '<td>';
	 		if($movie->getMovieInfo()->tomatoImage == "certified")
	 			echo $url.'<img src="/'.$base.'/resources/certified.png'.'" alt="HTML5 Icon""></a>';
	 		if($movie->getMovieInfo()->tomatoImage == "rotten")
	 			echo $url.'<img src="/'.$base.'/resources/rotten.png'.'" alt="HTML5 Icon""></a>';
	 		if($movie->getMovieInfo()->tomatoImage == "fresh")
	 			echo $url.'<img src="/'.$base.'/resources/fresh.png'.'" alt="HTML5 Icon""></a>';
	 		echo $url.$movie->getMovieInfo()->tomatoMeter.'</a>';
	 		echo '</td>';
	 		echo '<td><a href="http://www.imdb.com/title/'.$movie->getMovieInfo()->imdbID.'">'.$movie->getImdbRating().'</a></td>';
	 			echo '</tr>';
	 		}
	 		echo "</tbody>";
	 		echo "</table>";
	 		echo "</div>";
	 		echo "</div>";
	 
	 	}
	 
	 }
	 
	 public static function showDetails() {
	 	$user = (array_key_exists('user', $_SESSION))?$_SESSION['user']:null;
	 	$list = (array_key_exists('list', $_SESSION))?$_SESSION['list']:null;
	 	$base = (array_key_exists('base', $_SESSION))?$_SESSION['base']:"";
	 	$movieLists = (array_key_exists('movieLists', $_SESSION))?
	 	$_SESSION['movieLists']:array();
	 	if (is_null($movieLists))
	 		echo '<p>Unknown List<p>';
	 	else {
	 		
	 		echo '<div style="background:transparent !important" class="jumbotron">';
	 		echo '<div class="container">';
	 		echo '<section class ="text-center">';	 		
	 		
	 		echo '<div class="container">';
  			echo '<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo">Add Movie</button>';
  			echo'<!-- Small modal -->
				 <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm">Finalize</button>
				 <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                 <div class="modal-dialog modal-sm">
                 <div class="modal-content">
  			     <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal">
                 <span aria-hidden="true">&times;</span>
                 <span class="sr-only">Close</span>
                 </button>
  			     </div>
  				 
  				 <div class="modal-body">
  				 <p> Are you sure you want to finalize this list?</p>
                 <form role="form"  action ="/'.$base.'/list/finalize/'.$list->getListId().'" method = "post">
                 <button type="submit" class="btn btn-success inline">Submit</button>
                 <button type="button" class="btn btn-danger inline"data-dismiss="modal">Close </button>
                 </form>
                 </div>
  					
  				 
                 </div>
                 </div>
                 </div>';
  			echo '<div id="demo" class="collapse">';
	  		echo '<form action = "/'.$base.'/movie/add/"'.$list->getListId().' method="Post">';
	 		echo 'Title<br>';
	 		echo '<input type="text" name="title"><br>';
	 		echo 'Year<br>';
	 		echo '<input type="text" name="year"><br>';
	 		echo '<input type="hidden" name="listId" value = "'.$list->getListId().'">';
	 		echo '<input type="hidden" name="type" value = "'.$list->getTypeOf().'">';
	 		echo '<select name="rank">';
            for ($i = sizeof($movieLists)+1; $i > 0; $i--) 
            echo '<option value="'.$i.'">'.$i.'</option>';
			echo '</select>';
	 		echo'<input type="submit" value="Submit"> </section></form>';
	 		echo '</div>'; 
	 		echo '</div>';		
 				
	 		echo '<section><h2 class ="text-center">'.$list->getTitle().'\'s List</h2>';
	 		echo '<ul>';
	 		echo '<div class="table-responsive">';
			echo '<table class="table table-hover">';
	 		echo "<thead>";
	 		echo '<tr><th>Rank</th><th>Poster</th><th>Title</th><th>'.'<img src="/'.$base.'/resources/tomatoesLogo.png'.'" alt="HTML5 Icon" style="width:42px;height:20px">'.'</th><th>'.'<img src="/'.$base.'/resources/imdb.png'.'" alt="HTML5 Icon" style="width:42px;height:20px">'.'</th></tr>';
	 		echo "</thead>";
	 		
	 		echo "<tbody>";
	 		foreach ($movieLists as $movie) {
	 		echo '<tr>';
	 		echo '<td>'.$movie->getRank();
	 		if($movie->getRank() > 1)
	 			echo '<a href="/'.$base.'/movie/moveUp/'.$movie->getMovieId().'"><span class="glyphicon glyphicon-arrow-up"></span></a>';
	 		if($movie->getRank() < sizeof($movieLists))
	 		    echo '<a href="/'.$base.'/movie/moveDown/'.$movie->getMovieId().'"><span class="glyphicon glyphicon-arrow-down"></span></a>';
	 		echo '</td>';
	 		if($movie->getMovieInfo()->Poster != 'N/A')
	 			echo '<td>'.'<img src = "'.$movie->getMovieInfo()->Poster.'"height="42" width="42">'.'</td>';
	 		else
	 			echo '<td> </td>';
	 		echo '<td>'.'<a href="http://www.imdb.com/title/'.$movie->getMovieInfo()->imdbID.'">'.$movie->getTitle().'</td>';
	 		if($movie->getType() == 'movie'){
	 			$movieTitle  = str_replace(' ', '_', $movie->getTitle());
	 			$url = '<a href="http://www.rottentomatoes.com/m/'.$movieTitle.'">';
	 		}
	 		else{
	 			$movieTitle  = str_replace(' ', '-', $movie->getTitle());
	 			$url = '<a href="http://www.rottentomatoes.com/tv/'.$movieTitle.'">';
	 		}
	 		echo '<td>';
	 		if($movie->getMovieInfo()->tomatoImage == "certified")
	 			echo $url.'<img src="/'.$base.'/resources/certified.png'.'" alt="HTML5 Icon""></a>';
	 		if($movie->getMovieInfo()->tomatoImage == "rotten")
	 			echo $url.'<img src="/'.$base.'/resources/rotten.png'.'" alt="HTML5 Icon""></a>';
	 		if($movie->getMovieInfo()->tomatoImage == "fresh")
	 			echo $url.'<img src="/'.$base.'/resources/fresh.png'.'" alt="HTML5 Icon""></a>';
	 		echo $url.$movie->getMovieInfo()->tomatoMeter.'</a>';
	 		echo '</td>';
	 		echo '<td><a href="http://www.imdb.com/title/'.$movie->getMovieInfo()->imdbID.'">'.$movie->getImdbRating().'</a></td>';
	 		echo '<td><a href="/'.$base.'/movie/remove/'.$movie->getMovieId().'"><span class="glyphicon glyphicon-remove-sign"></span></a></td>';
	 		echo '</tr>';
	 		}
	 		echo "</tbody>";
	 		echo "</table>";
	 		echo "</div>";
	 		echo '</ul></section>';
	 		echo '</div>';
	 		
	 		
	 	}
	 }
	 
	 public static function showFinalized() {
	 	MasterView::showHeader();
	 	MasterView::showNavBar();
	 	$user = (array_key_exists('user', $_SESSION))?$_SESSION['user']:null;
	 	$list = (array_key_exists('list', $_SESSION))?$_SESSION['list']:null;
	 	$base = (array_key_exists('base', $_SESSION))?$_SESSION['base']:"";
	 	$movieLists = (array_key_exists('movieLists', $_SESSION))?
	 	$_SESSION['movieLists']:array();
	 	if (is_null($movieLists))
	 		echo '<p>Unknown List<p>';
	 	else {
	 		echo '<div style="background:transparent !important" class="jumbotron">';
	 		echo '<div class="container">';
	 		echo '<section class ="text-center">';
	 		
	 		echo '<div class="container">';
	 		if($list->getPublic() == 0){
	 		echo'<!-- Small modal -->
				 <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm">Make Public</button>
				 <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                 <div class="modal-dialog modal-sm">
                 <div class="modal-content">
  			     <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal">
                 <span aria-hidden="true">&times;</span>
                 <span class="sr-only">Close</span>
                 </button>
  			     </div>
  		
  				 <div class="modal-body">
  				 <p> Are you sure you want to make this list public?</p>
                 <form role="form"  action ="/'.$base.'/list/makePublic/'.$list->getListId().'" method = "post">
                 <button type="submit" class="btn btn-success inline">Submit</button>
                 <button type="button" class="btn btn-danger inline"data-dismiss="modal">Close </button>
                 </form>
                 </div>
  		
  		
                 </div>
                 </div>
                 </div>';
	 		}
	 		echo '<section><h2 class ="text-center">'.$list->getTitle().'\'s List</h2>';
	 		echo '<ul>';
	 		echo '<div class="table-responsive">';
	 		echo '<table class="table table-hover">';
	 		echo "<thead>";
	 		echo '<tr><th>Rank</th><th>Poster</th><th>Title</th><th>'.'<img src="/'.$base.'/resources/tomatoesLogo.png'.'" alt="HTML5 Icon" style="width:42px;height:20px">'.'</th><th>'.'<img src="/'.$base.'/resources/imdb.png'.'" alt="HTML5 Icon" style="width:42px;height:20px">'.'</th></tr>';
	 		echo "</thead>";
	 		echo "</div>";
	 
	 		echo '<tbody >';
	 		foreach ($movieLists as $movie) {
	 			if($movie->getWatched() == 0){
	 			echo '<tr>';
	 			echo '<td>'.$movie->getRank().'</td>';
	 			if($movie->getMovieInfo()->Poster != 'N/A')
	 				echo '<td>'.'<img src = "'.$movie->getMovieInfo()->Poster.'"height="42" width="42">'.'</td>';
	 			else
	 				echo '<td> </td>';
	 			echo '<td>'.'<a href="http://www.imdb.com/title/'.$movie->getMovieInfo()->imdbID.'">'.$movie->getTitle().'</td>';
	 		if($movie->getType() == 'movie'){
	 			$movieTitle  = str_replace(' ', '_', $movie->getTitle());
	 			$url = '<a href="http://www.rottentomatoes.com/m/'.$movieTitle.'">';
	 		}
	 		else{
	 			$movieTitle  = str_replace(' ', '-', $movie->getTitle());
	 			$url = '<a href="http://www.rottentomatoes.com/tv/'.$movieTitle.'">';
	 		}
	 		echo '<td>';
	 		if($movie->getMovieInfo()->tomatoImage == "certified")
	 			echo $url.'<img src="/'.$base.'/resources/certified.png'.'" alt="HTML5 Icon""></a>';
	 		if($movie->getMovieInfo()->tomatoImage == "rotten")
	 			echo $url.'<img src="/'.$base.'/resources/rotten.png'.'" alt="HTML5 Icon""></a>';
	 		if($movie->getMovieInfo()->tomatoImage == "fresh")
	 			echo $url.'<img src="/'.$base.'/resources/fresh.png'.'" alt="HTML5 Icon""></a>';
	 		echo $url.$movie->getMovieInfo()->tomatoMeter.'</a>';
	 		echo '</td>';
	 		echo '<td><a href="http://www.imdb.com/title/'.$movie->getMovieInfo()->imdbID.'">'.$movie->getImdbRating().'</a></td>';
	 			echo '<td><a href="/'.$base.'/movie/watchedMovie/'.$movie->getMovieId().'"><span class="glyphicon glyphicon-ok-circle"></span></a></td>';
	 			echo '</tr>';
	 			}
	 		}
	 		foreach ($movieLists as $movie) {
	 			if($movie->getWatched() == 1){
	 				echo '<tr class="success">';
	 				echo '<td>'.$movie->getRank().'</td>';
	 				if($movie->getMovieInfo()->Poster != 'N/A')
	 					echo '<td>'.'<img src = "'.$movie->getMovieInfo()->Poster.'"height="42" width="42">'.'</td>';
	 				else
	 					echo '<td> </td>';
	 				echo '<td>'.'<a href="http://www.imdb.com/title/'.$movie->getMovieInfo()->imdbID.'">'.$movie->getTitle().'</td>';
	 		if($movie->getType() == 'movie'){
	 			$movieTitle  = str_replace(' ', '_', $movie->getTitle());
	 			$url = '<a href="http://www.rottentomatoes.com/m/'.$movieTitle.'">';
	 		}
	 		else{
	 			$movieTitle  = str_replace(' ', '-', $movie->getTitle());
	 			$url = '<a href="http://www.rottentomatoes.com/tv/'.$movieTitle.'">';
	 		}
	 		echo '<td>';
	 		if($movie->getMovieInfo()->tomatoImage == "certified")
	 			echo $url.'<img src="/'.$base.'/resources/certified.png'.'" alt="HTML5 Icon""></a>';
	 		if($movie->getMovieInfo()->tomatoImage == "rotten")
	 			echo $url.'<img src="/'.$base.'/resources/rotten.png'.'" alt="HTML5 Icon""></a>';
	 		if($movie->getMovieInfo()->tomatoImage == "fresh")
	 			echo $url.'<img src="/'.$base.'/resources/fresh.png'.'" alt="HTML5 Icon""></a>';
	 		echo $url.$movie->getMovieInfo()->tomatoMeter.'</a>';
	 		echo '</td>';
	 		echo '<td><a href="http://www.imdb.com/title/'.$movie->getMovieInfo()->imdbID.'">'.$movie->getImdbRating().'</a></td>';
	 		echo '<td></td>';
	 		echo '</tr>';
	 			}
	 		}
	 		echo "</tbody>";
	 		echo "</table>";
	 		echo "</div>";
	 		echo '</ul></section>';
	 		echo '</div>';
	 	}
	 }
	 
	 public static function showUpdate(){
	 	$movies = (array_key_exists('movies', $_SESSION))?$_SESSION['movies']:null;
	 	$base = (array_key_exists('base', $_SESSION))?$_SESSION['base']:"";
	 
	 	$_SESSION['headertitle'] = "Update Movie";
	 	MasterView::showHeader();
	 	MasterView::showNavBar();
	 	if (is_null($movies) || empty($movies) || is_null($movies[0])) {
	 		echo '<section>Movie does not exist</section>';
	 		return;
	 	}
	 	$movie = $movies[0];
	 	echo '<div style="background:transparent !important" class="jumbotron">';
	 	echo '<div class="container">';
	 	echo '<h1>Your Movie</h1>';
	 	echo '<p>MovieId: ';
	 	if (!is_null($movie)) {echo ($movie->getMovieId());}
	 	echo '</p> <p>Type: ';
	 	if (!is_null($movie)) {echo ($movie->getType());}
	 
	 	if ($movie->getErrors() > 0) {
	 		$errors = $movie->getErrors();
	 		echo '<section><p>Errors:<br>';
	 		foreach($errors as $key => $value)
	 		 echo $value . "<br>";
	 		echo '</p></section>';
	 	}
	 
	 	echo '<form method="post" action="/'.$base.'/movie/update/'.$movie->getMovieId().'">';
	 	echo 'Title<br>';
	 	echo '<input type="text" name="title"';
	 	echo 'value = "'. $movie->getTitle() .'"><br>';
	 	echo '<input type="hidden" name="type" value = "'.$movie->getType().'">';
	 	echo'<input type="submit" value="Submit"> </form>';
	 	echo "</div>";
	 	echo "</div>";
	 }
	 
}