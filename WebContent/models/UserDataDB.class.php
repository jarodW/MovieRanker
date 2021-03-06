<?php
class UserDataDB {
	
	public static function addUser($user) {
		// Inserts the User object $user into the Users table and returns userId
		$query = "INSERT INTO Users (userName, passwordHash, firstName, lastName, gender, birthday, email, phoneNumber)
		                      VALUES(:userName, :passwordHash, :firstName, :lastName, :gender, :birthday, :email, :phoneNumber)";
		try {
			if (is_null($user) || $user->getErrorCount() > 0)
				return $user;
			$db = Database::getDB ();
			$statement = $db->prepare ($query);
			$statement->bindValue(":userName", $user->getUserName());
			$statement->bindValue(":passwordHash", $user->getPasswordHash());			
			$statement->bindValue(":firstName", $user->getFirstName());
			$statement->bindValue(":lastName", $user->getLastName());
			$statement->bindValue(":gender", $user->getGender());
			$statement->bindValue(":birthday", $user->getBirthday());
			$statement->bindValue(":email", $user->getEmail());
			$statement->bindValue(":phoneNumber", $user->getPhoneNumber());
			$statement->execute ();
			$statement->closeCursor();
			$user->setUserId($db->lastInsertId("userId"));
		} catch (Exception $e) { // Not permanent error handling
			$user->setError('userId', 'USER_INVALID');
		}
		return $user;
	}

	public static function getUserRowSetsBy($type = null, $value = null) {
		// Returns the rows of Users whose $type field has value $value
		$allowedTypes = ["userId", "userName"];
		$userRowSets = array();
		try {
			$db = Database::getDB ();
			$query = "SELECT userId, userName, passwordHash, firstName, lastName, gender, birthday, email, phoneNumber FROM Users";
			if (!is_null($type)) {
			    if (!in_array($type, $allowedTypes))
					throw new PDOException("$type not an allowed search criterion for Users");
			    $query = $query. " WHERE ($type = :$type)";
			    $statement = $db->prepare($query);
			    $statement->bindParam(":$type", $value);
			} else 
				$statement = $db->prepare($query);
			$statement->execute ();
			$userRowSets = $statement->fetchAll(PDO::FETCH_ASSOC);
			$statement->closeCursor ();
		} catch (Exception $e) { // Not permanent error handling
			echo "<p>Error getting user rows by $type: " . $e->getMessage () . "</p>";
		}
		return $userRowSets;
	}
	
	public static function getUsersArray($rowSets) {
		// Returns an array of User objects extracted from $rowSets
		$users = array();
	 	if (!empty($rowSets)) {
			foreach ($rowSets as $userRow ) {
				$user = new UserData($userRow);
				$user->setUserId($userRow['userId']);
				array_push ($users, $user );
			}
	 	}
		return $users;
	}
	
	public static function getUsersBy($type=null, $value=null) {
		// Returns User objects whose $type field has value $value
		$userRows = UserDataDB::getUserRowSetsBy($type, $value);
		return UserDataDB::getUsersArray($userRows);
	}
	
	public static function getUserValues($rowSets, $column) {
		// Returns an array of values from $column extracted from $rowSets
		$userValues = array();
		foreach ($rowSets as $userRow )  {
			$userValue = $userRow[$column];
			array_push ($userValues, $userValue);
		}
		return $userValues;
	}
	
	public static function getUserValuesBy($column, $type=null, $value=null) {
		// Returns the $column of Users whose $type field has value $value
		$userRows = UserDataDB::getUserRowSetsBy($type, $value);
		return UserDataDB::getUserValues($userRows, $column);
	}
	
	public static function updateUser($user) {
		// Update a user
		try {
			$db = Database::getDB ();
			if (is_null($user) || $user->getErrorCount() > 0)
				return $user;
			$checkUser = UserDataDB::getUsersBy('userId', $user->getUserId());
			if (empty($checkUser))
				$user->setError('userId', 'USER_DOES_NOT_EXIST');
			if ($user->getErrorCount() > 0)
				return $user;
	
			$query = "UPDATE Users SET email = :email, phoneNumber = :phoneNumber WHERE userId = :userId";
	
			$statement = $db->prepare ($query);
			$statement->bindValue(":email", $user->getEmail());
			$statement->bindValue(":phoneNumber", $user->getPhoneNumber());
			$statement->bindValue(":userId", $user->getUserId());
			$statement->execute ();
			$statement->closeCursor();
		} catch (Exception $e) { // Not permanent error handling
			$user->setError('userId', 'USER_COULD_NOT_BE_UPDATED');
		}
		return $user;
	}
}
?>