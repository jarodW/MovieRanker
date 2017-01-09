<?php
class MovieDataDB {
	
	public static function addMovie($movie) {
		// Inserts $review into the Reviews table and returns reviewId
		
		$exist= array();
		try{
			$db = Database::getDB();
			$query = 'SELECT * from movielists where rank = :rank and listId = :list';
			$statement = $db->prepare ($query);
			$statement->bindValue(":rank",  $movie->getRank());
			$statement->bindValue(":list", $movie->getListId());
			$statement = $db->prepare ($query);
			$statement->execute ();
			$exist = $statement->fetchAll(PDO::FETCH_ASSOC);
		
			$statement->closeCursor();
		} catch (Exception $e) {
			echo 'wont work';
		}
		print_r($exist);
		if(!is_null($exist)){
		try {
			$db = Database::getDB ();
			$query = "Update movieLists set movieLists.rank = rank + 1 WHERE movieLists.rank >= :rank and listId = :list";
			$statement = $db->prepare ($query);
			$statement->bindValue(":rank", $movie->getRank());
			$statement->bindValue(":list", $movie->getListId());
			$statement->execute();
			$statement->closeCursor();
		} catch (Exception $e) { // Not permanent error handling
			echo 'cannot delete from MovieList';
		}
		}
		
		$query = "INSERT INTO MovieLists (listId, year, title, rank, watched)
		                      VALUES(:listId, :year, :title, :rank, :watched)";
		try {
			$db = Database::getDB ();
			if (is_null($movie) || $movie->getErrorCount() > 0)
				return $movie;

			$statement = $db->prepare ($query);
			$statement->bindValue(":listId", $movie->getListId());
			$statement->bindValue(":title",  $movie->getTitle());
			$statement->bindValue(":year",  $movie->getYear());
			$statement->bindValue(":rank",  $movie->getRank());
			$statement->bindValue(":watched",  $movie->getWatched());
			$statement->execute ();
			$statement->closeCursor();
			$movie->setMovieId($db->lastInsertId("movieId"));
		} catch (Exception $e) { // Not permanent error handling
			$movie->setError('movieId', 'LIST_INVALID');
		}
		return $movie;
	} 
	
	public static function getMovieRowSetsBy($type = null, $value = null) {
		// Returns the rows of Users whose $type field has value $value
		$allowedTypes = ["listId", "movieId"];
		$typeAlias = array("listId" => "MovieLists.listId");
		$movieRowSets = array();
		try {
			$db = Database::getDB ();
			$query = "SELECT MovieLists.movieId, MovieLists.listId, MovieLists.title, MovieLists.year, MovieLists.rank, MovieLists.watched,
					Lists.typeOf as type,Lists.userId as userId  FROM MovieLists LEFT JOIN Lists ON MovieLists.listId = Lists.listId";
			if (!is_null($type)) {
			    if (!in_array($type, $allowedTypes))
					throw new PDOException("$type not an allowed search criterion for MovieLists");
				$typeValue = (isset($typeAlias[$type]))?$typeAlias[$type]:$type; 
			    $query = $query. " WHERE ($typeValue = :$type)";
			    $query = $query. "ORDER BY MovieLists.rank";
			    $statement = $db->prepare($query);
			    $statement->bindParam(":$type", $value);
			} else 
				$statement = $db->prepare($query);
			$statement->execute ();
			$movieRowSets = $statement->fetchAll(PDO::FETCH_ASSOC);
			$statement->closeCursor ();
		} catch (Exception $e) { // Not permanent error handling
			echo "<p>Error getting user rows by $type: " . $e->getMessage () . "</p>";
		}
		return $movieRowSets;
	}

		public static function getMoviesArray($rowSets) {
		// Returns an array of User objects extracted from $rowSets
		$movies = array();
	 	if (!empty($rowSets)) {
			foreach ($rowSets as $movieRow ) {
				$movie = new MovieData($movieRow);
				$movie->setMovieId($movieRow['movieId']);
				array_push ($movies, $movie );
			}
	 	}
		return $movies;
	}
	
	public static function getMoviesBy($type=null, $value=null) {
		// Returns User objects whose $type field has value $value
		$movieRows = MovieDataDB::getMovieRowSetsBy($type, $value);
		return MovieDataDB::getMoviesArray($movieRows);
	}
	
	public static function getMovieValues($rowSets, $column) {
		// Returns an array of values from $column extracted from $rowSets
		$movieValues = array();
		foreach ($rowSets as $movieRow )  {
			$movieValue = $movieRow[$column];
			array_push ($movieValues, $movieValue);
		}
		return $movieValues;
	}
	
	public static function getMovieValuesBy($column, $type=null, $value=null) {
		// Returns the $column of Users whose $type field has value $value
		$movieRows = MovieDataDB::getMovieRowSetsBy($type, $value);
		return MovieDataDB::getMovieValues($movieRows, $column);
	}
	
	public static function updateMovie($movie) {
		// Update a Movie
		try {
			$db = Database::getDB ();
			if (is_null($movie) || $movie->getErrorCount() > 0)
				return $movie;
			$checkMovie = MovieDataDB::getMoviesBy('movieId', $movie->getMovieId());
			if (empty($checkMovie))
				$movie->setError('movieId', 'MOVIE_DOES_NOT_EXIST');
			if ($movie->getErrorCount() > 0)
				return $movie;
	
			$query = "UPDATE MovieLists SET title = :title WHERE movieId = :movieId";
				
			$statement = $db->prepare ($query);
			$statement->bindValue(":title", $movie->getTitle());
			$statement->bindValue(":movieId", $movie->getMovieId());
			$statement->execute ();
			$statement->closeCursor();
		} catch (Exception $e) { // Not permanent error handling
			$movie->setError('movieId', 'MOVIE_COULD_NOT_BE_UPDATED');
		}
		return $movie;
	}
	
	public static function remove($id,$list,$rank){
		try {
			$db = Database::getDB ();
			$query = "DELETE From movieLists WHERE movieId = :movieId and listId = :list";
			$statement = $db->prepare ($query);
			$statement->bindValue(":movieId", $id);
			$statement->bindValue(":list", $list);
			$statement->execute();
			$statement->closeCursor();
		} catch (Exception $e) { // Not permanent error handling
			echo 'cannot remove from MovieList';
		}
		
		try {
			$db = Database::getDB ();
			$query = "Update movieLists set movieLists.rank = rank - 1 WHERE movieLists.rank > :rank and listId = :list";
			$statement = $db->prepare ($query);
			$statement->bindValue(":rank", $rank);
			$statement->bindValue(":list", $list);
			$statement->execute();
			$statement->closeCursor();
		} catch (Exception $e) { // Not permanent error handling
			echo 'cannot update from MovieList';
		}
	}
	
	public static function moveUp($id,$list,$rank){
			try {
			$db = Database::getDB ();
			$query = "Update movieLists set movieLists.rank = rank + 1 WHERE movieLists.rank = :rank and listId = :list";
			$statement = $db->prepare ($query);
			$statement->bindValue(":rank", $rank-1);
			$statement->bindValue(":list", $list);
			$statement->execute();
			$statement->closeCursor();
		} catch (Exception $e) { // Not permanent error handling
			echo 'cannot delete from MovieList';
		}
	
		try {
			$db = Database::getDB ();
			$query = "Update movieLists set movieLists.rank = rank - 1 WHERE movieLists.movieId = :id and listId = :list";
			$statement = $db->prepare ($query);
			$statement->bindValue(":id", $id);
			$statement->bindValue(":list", $list);
			$statement->execute();
			$statement->closeCursor();
		} catch (Exception $e) { // Not permanent error handling
			echo 'cannot delete from MovieList';
		}
	}
	
	public static function moveDown($id,$list,$rank){
		try {
			$db = Database::getDB ();
			$query = "Update movieLists set movieLists.rank = rank - 1 WHERE movieLists.rank = :rank and listId = :list";
			$statement = $db->prepare ($query);
			$statement->bindValue(":rank", $rank+1);
			$statement->bindValue(":list", $list);
			$statement->execute();
			$statement->closeCursor();
		} catch (Exception $e) { // Not permanent error handling
			echo 'cannot update from MovieList';
		}
	
		try {
			$db = Database::getDB ();
			$query = "Update movieLists set movieLists.rank = rank + 1 WHERE movieLists.movieId = :id and listId = :list";
			$statement = $db->prepare ($query);
			$statement->bindValue(":id", $id);
			$statement->bindValue(":list", $list);
			$statement->execute();
			$statement->closeCursor();
		} catch (Exception $e) { // Not permanent error handling
			echo 'cannot update from MovieList';
		}
	}
	
	public static function watchedMovie($id,$list,$rank){
		try {
			$db = Database::getDB ();
			$query = "Update movieLists set movieLists.watched = 1 WHERE movieId = :id";
			$statement = $db->prepare ($query);
			$statement->bindValue(":id", $id);
			$statement->execute();
			$statement->closeCursor();
		} catch (Exception $e) { // Not permanent error handling
			echo 'cannot update from MovieList';
		}
	}
}
?>