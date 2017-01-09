<?php
class PublicListDB {
	
	public static function getPublicListRowSetsBy($type = null, $value = null) {
		// Returns the rows of Users whose $type field has value $value
		$allowedTypes = ["publicListId", "listId"];
		$userRowSets = array();
		try {
			$db = Database::getDB ();
			$query = "SELECT publicListId, publiclist.listId, points, publiclist.title, Lists.typeOf as type FROM PublicList Left Join Lists on PublicList.listId = Lists.listId ";
			if (!is_null($type)) {
			    if (!in_array($type, $allowedTypes))
					throw new PDOException("$type not an allowed search criterion for Users");
			    $query = $query. " WHERE ($type = :$type)";
			    $statement = $db->prepare($query);
			    $statement->bindParam(":$type", $value);
			} else
				$query = $query. " ORDER BY publiclist.points DESC";
				$statement = $db->prepare($query);
			$statement->execute ();
			$userRowSets = $statement->fetchAll(PDO::FETCH_ASSOC);
			$statement->closeCursor ();
		} catch (Exception $e) { // Not permanent error handling
			echo "<p>Error getting user rows by $type: " . $e->getMessage () . "</p>";
		}
		return $userRowSets;
	}

		public static function getPublicListsArray($rowSets) {
		// Returns an array of User objects extracted from $rowSets
		$lists = array();
	 	if (!empty($rowSets)) {
			foreach ($rowSets as $listRow ) {
				$list = new PublicList($listRow);
				$list->setPublicListId($listRow['publicListId']);
				array_push ($lists, $list );
			}
	 	}
		return $lists;
	}
	
	public static function getPublicListsBy($type=null, $value=null) {
		// Returns User objects whose $type field has value $value
		$listRows = PublicListDB::getPublicListRowSetsBy($type, $value);
		return PublicListDB::getPublicListsArray($listRows);
	}
	
	public static function addPoint($userId, $listId){
		$lists= array();
		$sum= array();
		$db = Database::getDB();
		try{
			$query =  'SELECT point FROM PointList where userId = :userId and listId = :listId';
			$statement = $db->prepare ($query);
			$statement->bindValue(":userId",  $userId);
			$statement->bindValue(":listId", $listId);
			$statement->execute ();
			$lists = $statement->fetchAll(PDO::FETCH_ASSOC);
	
			$statement->closeCursor();
		} catch (Exception $e) {
			echo 'Cannot select from pointList';
		}
		if(empty($lists)){
			try{
				$query = "INSERT INTO PointList (userId, listId, point)
		                      VALUES(:userId, :listId, 1)";
				$statement = $db->prepare ($query);
				$statement->bindValue(":userId",  $userId);
				$statement->bindValue(":listId", $listId);
				$statement->execute ();
			
				$statement->closeCursor();
			} catch (Exception $e) {
				echo 'Cannot insert into pointList';
			}
		}
		else{
			if($lists[0]['point'] == 1){
				try{
					$query  = "Update PointList set point = 0 where userId = :userId and listId = :listId";
					$statement = $db->prepare ($query);
					$statement->bindValue(":userId",  $userId);
					$statement->bindValue(":listId", $listId);
					$statement->execute ();
					$statement->closeCursor();
				} catch (Exception $e) {
					echo 'Cannot add point to pointList';
				}
			}
			else{
				try{
					$query  = "Update PointList set point = 1 where userId = :userId and listId = :listId";
					$statement = $db->prepare ($query);
					$statement->bindValue(":userId",  $userId);
					$statement->bindValue(":listId", $listId);
					$statement->execute ();
					$statement->closeCursor();
				} catch (Exception $e) {
					echo 'Cannot negate point from pointList';
				}
			}
		}
		
		try{
			$query = "Select SUM(point) as total from pointList where listId = :listId";
			$statement = $db->prepare ($query);
			$statement->bindValue(":listId", $listId);
			$statement->execute ();
			$sum = $statement->fetchAll(PDO::FETCH_ASSOC);	
			$statement->closeCursor();
		} catch (Exception $e) {
			echo 'Cannot select from pointList';;
		}
		try{
			$query = "Update PublicList set points = :sum where publicListId = :listId";
			$statement = $db->prepare ($query);	
			$statement->bindValue(":listId", $listId);
			$statement->bindValue(":sum", $sum[0]['total']);
			$statement->execute ();
			$statement->closeCursor();
		} catch (Exception $e) {
			echo 'Cannot update from pointList';
		}
		
	}
	
	public static function minusPoint($userId, $listId){
		$lists= array();
		$db = Database::getDB();
		try{
			$query = 'SELECT point FROM PointList where userId = :userId and listId = :listId';
			$statement = $db->prepare ($query);
			$statement->bindValue(":userId",  $userId);
			$statement->bindValue(":listId", $listId);
			$statement->execute ();
			$lists = $statement->fetchAll(PDO::FETCH_ASSOC);
	
			$statement->closeCursor();
		} catch (Exception $e) {
			echo 'Cannot select from pointList';
		}
		
		if(empty($lists)){
			$db = Database::getDB();
			try{
				$query = $sql = "INSERT INTO PointList (userId, listId, point)
		                      VALUES(:userId, :listId, -1)";
				$statement = $db->prepare ($query);
				$statement->bindValue(":userId",  $userId);
				$statement->bindValue(":listId", $listId);
				$statement->execute ();
				$lists = $statement->fetchAll(PDO::FETCH_ASSOC);
					
				$statement->closeCursor();
			} catch (Exception $e) {
				echo 'Cannot insert from pointList';
			}
		}
			else{
			if($lists[0]['point'] == -1){
				try{
					$query  = "Update PointList set point = 0 where userId = :userId and listId = :listId";
					$statement = $db->prepare ($query);
					$statement->bindValue(":userId",  $userId);
					$statement->bindValue(":listId", $listId);
					$statement->execute ();
					$statement->closeCursor();
				} catch (Exception $e) {
					echo 'Cannot add point to pointList';
				}
			}
			else{
				try{
					$query  = "Update PointList set point = -1 where userId = :userId and listId = :listId";
					$statement = $db->prepare ($query);
					$statement->bindValue(":userId",  $userId);
					$statement->bindValue(":listId", $listId);
					$statement->execute ();
					$statement->closeCursor();
				} catch (Exception $e) {
					echo 'Cannot negate point from pointList';
				}
			}
		}
		
		try{
			$query = "Select SUM(point) as total from pointList where listId = :listId";
			$statement = $db->prepare ($query);
			$statement->bindValue(":listId", $listId);
			$statement->execute ();
			$sum = $statement->fetchAll(PDO::FETCH_ASSOC);
			$statement->closeCursor();
		} catch (Exception $e) {
			echo 'Cannot select from pointList';
		}
		try{
			$query = "Update PublicList set points = :sum where publicListId = :listId";
			$statement = $db->prepare ($query);
			$statement->bindValue(":listId", $listId);
			$statement->bindValue(":sum", $sum[0]['total']);
			$statement->execute ();
			$statement->closeCursor();
		} catch (Exception $e) {
			echo 'Cannot update from PublicList';
		}
	}
	
	public static function getVote($id, $userId){
		$db = Database::getDB();
		$lists= array();
		$db = Database::getDB();
		try{
			$query = "SELECT point FROM PointList where listId = :listId and userId= :userId";
			$statement = $db->prepare ($query);
			$statement->bindValue(":listId", $id);
			$statement->bindValue(":userId", $userId);
			$statement->execute ();
			$lists = $statement->fetchAll(PDO::FETCH_ASSOC);
	
			$statement->closeCursor();
		} catch (Exception $e) {
			echo 'Cannot select from PointList';
		}
		return $lists;
	}
}?>