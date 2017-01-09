<?php
class PublicListController {
	public static function run() {
		// Perform actions related to a review
		$action = $_SESSION['action'];
		$arguments = $_SESSION['arguments'];
		switch ($action) {
			case  "showall":
				$_SESSION['lists'] = PublicListDB::getPublicListsBy();
				PublicListView::showAll();
				break;
			case  "showLoggedIn":
				if(empty($_SESSION['authenticatedUser']))
					HomeView::show();
				else{
					$_SESSION['lists'] = PublicListDB::getPublicListsBy();
					PublicListView::showLoggedIn();
				}
				break;
			case "plus":
				if(empty($_SESSION['authenticatedUser']))
					HomeView::show();
				else{
				self::plus($arguments);
				}
				break;
			case "minus":
				if(empty($_SESSION['authenticatedUser']))
					HomeView::show();
					else{
						self::minus($arguments);
					}
					break;
			default:
		}
	}
	
	public static function plus($id){
			$lists = PublicListDB::getPublicListsBy('publicListId',$id);
			PublicListDB::addPoint($_SESSION['authenticatedUser']->getUserId(),$id);
			header('Location: /'.$_SESSION['base'].'/public/showLoggedIn/');
	}
	
	public static function minus($id){
		$lists = PublicListDB::getPublicListsBy('publicListId',$id);
		PublicListDB::minusPoint($_SESSION['authenticatedUser']->getUserId(),$id);
		header('Location: /'.$_SESSION['base'].'/public/showLoggedIn/');
	}
}
?>