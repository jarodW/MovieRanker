<?php
class ListController {
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
			case "showUser":
				$users = UserDataDB::getUsersBy('userId', $arguments);
				$_SESSION['user'] = (!empty($users))?$users[0]:null;
				self::showUser();
				break;
			case "add":
				self::add();
				break;
			case  "showall":
				$_SESSION['lists'] = ListDB::getListsBy();
				$_SESSION['headertitle'] = "Show all users";
				$_SESSION['footertitle'] = "<h3>The footer goes here</h3>";
				ListView::showAll();
				break;
			case "update":
				self::updateList();
				break;
			case "update2":
				self::updateList2();
				break;
			case "remove":
				self::remove($arguments);
				break;
			case "finalize":
				self::finalize($arguments);
				break;
			case "makePublic":
				self::makePublic($arguments);
				break;
			case "userNull":
				self::userNull($arguments);
				break;
			case "adoptList":
				self::adoptList($arguments);
				break;
			default:
		}
	}
	public static function show(){
		$arguments = (array_key_exists('arguments', $_SESSION))?$_SESSION['arguments']:0;
		$user = $_SESSION['user'];
		if (!is_null($user) && $_SESSION['user'] == $_SESSION['authenticatedUser']) {
			$_SESSION['user'] = $user;
			$_SESSION['userLists'] = ListDB::getListsBy('userName', $user->getUserName());
			ListView::show();
		} else{
			HomeView::show();
			if(!empty($_SESSION['authenticatedUser']))
			$users = UserDataDB::getUsersBy('userId', $_SESSION['authenticatedUser']->getUserId());
			$_SESSION['user'] = (!empty($users))?$users[0]:null;
			header('Location: /'.$_SESSION['base']);
		}
	}
	public static function showUser(){
		$arguments = (array_key_exists('arguments', $_SESSION))?$_SESSION['arguments']:0;
		$user = $_SESSION['user'];
		if (!is_null($user)) {
			$_SESSION['user'] = $user;
			$_SESSION['userLists'] = ListDB::getListsBy('userName', $user->getUserName());
			ListView::showUser();
		} else
			HomeView::show();
	}
	
	public static function add(){
		$list = null;
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$list = new BucketList($_POST);
		}
		
		$_SESSION['list'] = $list;
		if (is_null($list) || $list->getErrorCount() != 0 ||  $list->getUserId() != $_SESSION['authenticatedUser']->getUserId()){
			ListView::show();
		}
		else{  // Initial link
			$list = ListDB::addList($list);
			$_SESSION['action'] = "show";
			$_SESSION['arguments'] = $list->getUserId();
			self::run();
			header('Location: /'.$_SESSION['base'].'/list/show/'.$list->getUserId());
		}
		
	}
	
	public static function updateList(){
		// Process updating review
		$lists = ListDB::getListsBy('listId', $_SESSION['arguments']);
		if (empty($lists) || $lists[0]->getUserId() != $_SESSION['authenticatedUser']->getUserId()) {
			HomeView::show();
		} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
			$_SESSION['lists'] = $lists;
			ListView::showUpdate();
		} else {
	
			$parms = $lists[0]->getParameters();
			$parms['title'] = (array_key_exists('title', $_POST))? $_POST['title']:$lists[0]->getTitle();
			$newList = new BucketList($parms);
			$newList->setListId($lists[0]->getListId());
			$list = ListDB::updateList($newList);
	
			if ($list->getErrorCount() != 0) {
				$_SESSION['lists'] = array($newList);

				ListView::showUpdate();
			} else {
				$_SESSION['list'] = $list;
				HomeView::show();
	
			}
		}
	}
	
	public static function updateList2(){
		// Process updating review
		$lists = ListDB::getListsBy('listId', $_SESSION['arguments']);
		if (empty($lists)|| $lists[0]->getUserId() != $_SESSION['authenticatedUser']->getUserId()) {
			HomeView::show();
		} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
			$_SESSION['lists'] = $lists;
			ListView::showUpdate2();
		} else {
	
			$parms = $lists[0]->getParameters();
			$parms['title'] = (array_key_exists('title', $_POST))? $_POST['title']:$lists[0]->getTitle();
			$newList = new BucketList($parms);
			$newList->setListId($lists[0]->getListId());
			$list = ListDB::updateList($newList);
	
			if ($list->getErrorCount() != 0) {
				$_SESSION['lists'] = array($newList);
				ListView::showUpdate2();
			} else {
				$_SESSION['list'] = $list;
				HomeView::show();
				header('Location: /'.$_SESSION['base'].'/list/show/'.$lists[0]->getUserId());
	
			}
		}
	}
	
	public static function remove($id){
		$lists = ListDB::getListsBy('listId', $id);
		$users = UserDataDB::getUsersBy('userId', $lists[0]->getUserId());
		if($users[0]->getUserId() != $_SESSION['authenticatedUser']->getUserId())
			HomeView::show();
		else {
		$_SESSION['user'] = (!empty($users))?$users[0]:null;
		ListDB::remove($id);
		header('Location: /'.$_SESSION['base'].'/list/show/'.$users[0]->getUserId());
		}
	}
	
	public static function finalize($id){
		$lists = ListDB::getListsBy('listId', $id);
		$users = UserDataDB::getUsersBy('userId', $lists[0]->getUserId());
		if($users[0]->getUserId() != $_SESSION['authenticatedUser']->getUserId())
			HomeView::show();
		else {
		$_SESSION['user'] = (!empty($users))?$users[0]:null;
		ListDB::finalize($id);
		header('Location: /'.$_SESSION['base'].'/movie/show/'.$lists[0]->getListId());
		}
	}
	
	public static function makePublic($id){
		$lists = ListDB::getListsBy('listId', $id);
		$users = UserDataDB::getUsersBy('userId', $lists[0]->getUserId());
		if($users[0]->getUserId() != $_SESSION['authenticatedUser']->getUserId())
			HomeView::show();
		else {
			$_SESSION['user'] = (!empty($users))?$users[0]:null;
			ListDB::makePublic($id);
			header('Location: /'.$_SESSION['base'].'/movie/show/'.$lists[0]->getListId());
		}
	}
	
	public static function userNull($id){
		$lists = ListDB::getListsBy('listId', $id);
		$users = UserDataDB::getUsersBy('userId', $lists[0]->getUserId());
		if($users[0]->getUserId() != $_SESSION['authenticatedUser']->getUserId())
			HomeView::show();
		else {
			$_SESSION['user'] = (!empty($users))?$users[0]:null;
			ListDB::makeUserNull($id);
			header('Location: /'.$_SESSION['base'].'/list/show/'.$users[0]->getUserId());
		}
	}
	
	public static function adoptList($id){
		$list = new BucketList($_POST);
		$list = ListDB::addList($list);
		$adoptList = MovieDataDB::getMoviesBy('listId',$id);
		foreach($adoptList as $movie){
			$parms = $movie->getParameters();
			$parms['listId'] = $list->getListId();
			$parms['userId'] = $_SESSION['authenticatedUser']->getUserId();
			$parms['watched'] = 0;
			$movie = new MovieData($parms);
			MovieDataDB::addMovie($movie);
		}
		header('Location: /'.$_SESSION['base'].'/movie/show/'.$list->getListId());
	}
}
?>