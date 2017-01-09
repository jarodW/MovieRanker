<?php
class MovieDataController {
	public static function run() {
		// Perform actions related to a review
		$action = $_SESSION['action'];
		$arguments = $_SESSION['arguments'];
		switch ($action) {
			case  "showall":
				$_SESSION['movies'] = MovieDataDB::getMoviesBy();
				$_SESSION['headertitle'] = "Show all users";
				$_SESSION['footertitle'] = "<h3>The footer goes here</h3>";
				MovieDataView::showAll();
				break;
			case "showMovies":
				$lists = ListDB::getListsBy('listId', $arguments);
				$_SESSION['list'] = (!empty($lists))?$lists[0]:null;
				self::showList();
				break;
			case "showLoggedInMovies":
				$lists = ListDB::getListsBy('listId', $arguments);
				$_SESSION['list'] = (!empty($lists))?$lists[0]:null;
				self::showLoggedInList();
				break;
			case "show":
				$lists = ListDB::getListsBy('listId', $arguments);
				$_SESSION['list'] = (!empty($lists))?$lists[0]:null;
				if(!empty($lists)){
				$users = UserDataDB::getUsersBy('userId', $lists[0]->getUserId());
				$_SESSION['user'] = (!empty($users))?$users[0]:null;
				}
				self::show();
				break;
			case "add":
				self::add();
				break;
			case "update":
				self::updateMovie();
				break;
			case "remove":
				self::remove($arguments);
				break;
			case "moveUp":
				self::moveUp($arguments);
				break;
			case "moveDown":
				self::moveDown($arguments);
				break;
			case "watchedMovie":
				self::watchedMovie($arguments);
				break;
			default:
		}
	}
	
	public static function showList(){
		$arguments = (array_key_exists('arguments', $_SESSION))?$_SESSION['arguments']:0;
		$list = $_SESSION['list'];
		if (!is_null($list)) {
			$_SESSION['list'] = $list;
			$_SESSION['movieLists'] = MovieDataDB::getMoviesBy('listId', $list->getListId());
			MovieDataView::showList();
		} else
			HomeView::show();
	}
	
	public static function showLoggedInList(){
		$arguments = (array_key_exists('arguments', $_SESSION))?$_SESSION['arguments']:0;
		$list = $_SESSION['list'];
		if (!is_null($list)) {
			$_SESSION['list'] = $list;
			$_SESSION['movieLists'] = MovieDataDB::getMoviesBy('listId', $list->getListId());
			MovieDataView::showLoggedInList();
		} else
			HomeView::show();
	}
	
	public static function show(){
		$arguments = (array_key_exists('arguments', $_SESSION))?$_SESSION['arguments']:0;
		$list = $_SESSION['list'];
		if (!is_null($list)&& $list->getUserId() == $_SESSION['authenticatedUser']->getUserId()) {
			$_SESSION['list'] = $list;
			$_SESSION['movieLists'] = MovieDataDB::getMoviesBy('listId', $list->getListId());
			if($list->getFinalized() == 0){
				MovieDataView::show();
			}
			else {
				MovieDataView::showFinalized();
			}
		} else
			HomeView::show();
	}
	
	public static function add(){
		$movie = null;
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$list = new MovieData($_POST);
		}
	
		$_SESSION['list'] = $list;
		if (is_null($list) || $list->getErrorCount() != 0){
			header('Location: /'.$_SESSION['base'].'/movie/show/'.$list->getListId());
		}
		else{  // Initial link
			$movie = MovieDataDB::addMovie($list);
			$movies = MovieDataDB::getMoviesBy('listId',$movie->getListId());
			$lists = ListDB::getListsBy('listId', $movie->getListId());
			$_SESSION['movieLists'] = $movies;
			$_SESSION['list'] = $lists[0];
			header('Location: /'.$_SESSION['base'].'/movie/show/'.$lists[0]->getListId());
		}
	
	}
	
	public static function updateMovie(){
		// Process updating review
		$movies = MovieDataDB::getMoviesBy('movieId', $_SESSION['arguments']);
		if (empty($movies) || $movies[0]->getUserId() != $_SESSION['authenticatedUser']->getUserId()) {
			HomeView::show();
		} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
			$_SESSION['movies'] = $movies;
			MovieDataView::showUpdate();
		} else {
	
			$parms = $movies[0]->getParameters();
			$parms['title'] = (array_key_exists('title', $_POST))? $_POST['title']:$movies[0]->getTitle();
			$parms['type'] = $movies[0]->getType();
			$newMovie = new MovieData($parms);
			$newMovie->setMovieId($movies[0]->getMovieId());
			$movie = MovieDataDB::updateMovie($newMovie);
	
			if ($movie->getErrorCount() != 0) {
				$_SESSION['movies'] = array($newMovie);

				MovieDataView::showUpdate();
			} else {
				$_SESSION['movie'] = $movie;
				HomeView::show();
	
			}
		}
	}
	
	public static function remove($id){
		$movies = MovieDataDB::getMoviesBy('movieId', $id);
		if (empty($movies) || $movies[0]->getUserId() != $_SESSION['authenticatedUser']->getUserId()) {
			HomeView::show();
		}else{
		MovieDataDB::remove($id,$movies[0]->getListId(),$movies[0]->getRank());
		header('Location: /'.$_SESSION['base'].'/movie/show/'. $movies[0]->getListId());
		}
	}
	
	public static function moveUp($id){
		$movies = MovieDataDB::getMoviesBy('movieId', $id);
		if (empty($movies) || $movies[0]->getUserId() != $_SESSION['authenticatedUser']->getUserId()) {
			HomeView::show();
		}else{
		MovieDataDB::moveUp($id,$movies[0]->getListId(),$movies[0]->getRank());
		header('Location: /'.$_SESSION['base'].'/movie/show/'. $movies[0]->getListId());
		}
	}
	
	public static function moveDown($id){
		$movies = MovieDataDB::getMoviesBy('movieId', $id);
		if (empty($movies) || $movies[0]->getUserId() != $_SESSION['authenticatedUser']->getUserId()) {
			HomeView::show();
		}else{
		MovieDataDB::moveDown($id,$movies[0]->getListId(),$movies[0]->getRank());
		header('Location: /'.$_SESSION['base'].'/movie/show/'. $movies[0]->getListId());
		}
	}
	
	public static function watchedMovie($id){
		$movies = MovieDataDB::getMoviesBy('movieId', $id);
		if (empty($movies) || $movies[0]->getUserId() != $_SESSION['authenticatedUser']->getUserId()) {
			HomeView::show();
		}else{
			MovieDataDB::watchedMovie($id,$movies[0]->getListId(),$movies[0]->getRank());
			header('Location: /'.$_SESSION['base'].'/movie/show/'. $movies[0]->getListId());
		}
	}
}
?>