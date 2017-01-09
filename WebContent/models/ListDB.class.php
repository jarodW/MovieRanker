<?php
class ListDB {
	
	public static function addList($list) {
		// Inserts $review into the Reviews table and returns reviewId
		$query = "INSERT INTO Lists (userId, typeOf, title, finalized,public)
		                      VALUES(:userId, :typeOf, :title, :finalized,:public)";
		try {
			$db = Database::getDB ();
			if (is_null($list) || $list->getErrorCount() > 0)
				return $list;

			$statement = $db->prepare ($query);
			$statement->bindValue(":userId", $list->getUserId());
			$statement->bindValue(":typeOf",  $list->getTypeOf());
			$statement->bindValue(":title",  $list->getTitle());
			$statement->bindValue(":finalized",  $list->getFinalized());
			$statement->bindValue(":public", $list->getPublic());
			$statement->execute ();
			$statement->closeCursor();
			$list->setListId($db->lastInsertId("listId"));
		} catch (Exception $e) { // Not permanent error handling
			$list->setError('listId', 'LIST_INVALID');
		}
		return $list;
	}
	
	public static function getListRowSetsBy($type = null, $value = null) {
		// Returns the rows of Users whose $type field has value $value
		$allowedTypes = ["listId", "userId", "userName"];
		$typeAlias = array("userName" => "Users.userName");
		$listRowSets = array();
		try {
			$db = Database::getDB ();
			$query = "SELECT Lists.listId, Lists.userId, Lists.typeOf, Lists.title, Lists.finalized, Lists.public,
					Users.userName as userName FROM Lists LEFT JOIN Users ON Lists.userId = Users.userId";
			if (!is_null($type)) {
			    if (!in_array($type, $allowedTypes))
					throw new PDOException("$type not an allowed search criterion for Lists");
				$typeValue = (isset($typeAlias[$type]))?$typeAlias[$type]:$type; 
			    $query = $query. " WHERE ($typeValue = :$type)";
			    $statement = $db->prepare($query);
			    $statement->bindParam(":$type", $value);
			} else 
				$statement = $db->prepare($query);
			$statement->execute ();
			$listRowSets = $statement->fetchAll(PDO::FETCH_ASSOC);
			$statement->closeCursor ();
		} catch (Exception $e) { // Not permanent error handling
			echo "<p>Error getting user rows by $type: " . $e->getMessage () . "</p>";
		}
		return $listRowSets;
	}

		public static function getListsArray($rowSets) {
		// Returns an array of User objects extracted from $rowSets
		$lists = array();
	 	if (!empty($rowSets)) {
			foreach ($rowSets as $listRow ) {
				$list = new BucketList($listRow);
				$list->setListId($listRow['listId']);
				array_push ($lists, $list );
			}
	 	}
		return $lists;
	}
	
	public static function getListsBy($type=null, $value=null) {
		// Returns User objects whose $type field has value $value
		$listRows = ListDB::getListRowSetsBy($type, $value);
		return ListDB::getListsArray($listRows);
	}
	
	public static function getListValues($rowSets, $column) {
		// Returns an array of values from $column extracted from $rowSets
		$listValues = array();
		foreach ($rowSets as $listRow )  {
			$listValue = $listRow[$column];
			array_push ($listValues, $listValue);
		}
		return $listValues;
	}
	
	public static function getListValuesBy($column, $type=null, $value=null) {
		// Returns the $column of Users whose $type field has value $value
		$listRows = ListDB::getListRowSetsBy($type, $value);
		return ListDB::getListValues($listRows, $column);
	}
	
	public static function updateList($list) {
		// Update a user
		try {
			$db = Database::getDB ();
			if (is_null($list) || $list->getErrorCount() > 0)
				return $list;
			$checkList = ListDB::getListsBy('listId', $list->getListId());
			if (empty($checkList))
				$list->setError('listId', 'LIST_DOES_NOT_EXIST');
			if ($list->getErrorCount() > 0)
				return $list;
	
			$query = "UPDATE Lists SET title = :title WHERE listId = :listId";
			
			$statement = $db->prepare ($query);
			$statement->bindValue(":title", $list->getTitle());
			$statement->bindValue(":listId", $list->getListId());
			$statement->execute ();
			$statement->closeCursor();
		} catch (Exception $e) { // Not permanent error handling
			$list->setError('listId', 'LIST_COULD_NOT_BE_UPDATED');
		}
		return $list;
	}
	
	public static function remove($id){
		try {
		$db = Database::getDB ();
		$query = "DELETE From movieLists WHERE listId = :listId";
		$statement = $db->prepare ($query);
		$statement->bindValue(":listId", $id);
		$statement->execute();
		$statement->closeCursor();
		} catch (Exception $e) { // Not permanent error handling
			echo 'cannot delete from MovieList';
		}
		try {
			$db = Database::getDB ();
			$query = "DELETE From Lists WHERE listId = :listId";
			$statement = $db->prepare ($query);
			$statement->bindValue(":listId", $id);
			$statement->execute();
			$statement->closeCursor();
		} catch (Exception $e) { // Not permanent error handling
			echo 'cannot delete from MovieList';
		}
	}
	
	public static function getLists($id){
		$db = Database::getDB();
		$lists= array();
		$db = Database::getDB();
		try{
			$query = "SELECT listId FROM Lists where userId =".$id;
			$statement = $db->prepare ($query);
			$statement->execute ();
			$lists = $statement->fetchAll(PDO::FETCH_ASSOC);
	
			$statement->closeCursor();
		} catch (Exception $e) {
			echo 'wont work';
		}
		return $lists;
	}
	
	public static function finalize($id){
		try {
			$db = Database::getDB ();
			$query = "Update Lists set lists.finalized = 1 WHERE listId = :id";
			$statement = $db->prepare ($query);
			$statement->bindValue(":id", $id);
			$statement->execute();
			$statement->closeCursor();
		} catch (Exception $e) { // Not permanent error handling
			echo 'cannot delete from MovieList';
		}
	}
	
	public static function makePublic($id){
		try {
			$db = Database::getDB ();
			$query = "Update Lists set lists.public = 1 WHERE listId = :id";
			$statement = $db->prepare ($query);
			$statement->bindValue(":id", $id);
			$statement->execute();
			$statement->closeCursor();
		} catch (Exception $e) { // Not permanent error handling
			echo 'cannot delete from MovieList';
		}
	}
	
	public static function makeUserNull($id){
		try {
			$db = Database::getDB ();
			$query = "Update Lists set lists.userId = null WHERE listId = :id";
			$statement = $db->prepare ($query);
			$statement->bindValue(":id", $id);
			$statement->execute();
			$statement->closeCursor();
		} catch (Exception $e) { // Not permanent error handling
			echo 'cannot delete from MovieList';
		}
	}
}
?>