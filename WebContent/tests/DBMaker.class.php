<?php

class DBMaker {
	public static function create($dbName) {
		// Creates a database named $dbName for testing and returns connection
		$db = null;
		try {
			$dbspec = 'mysql:host=localhost;dbname=' . "". ";charset=utf8";
			$passArray = parse_ini_file(Configuration::getConfigurationPath());
			$username = $passArray["username"];
			$password = $passArray["password"];
			$options = array (PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION );
			$options = array (PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION );
			$db = new PDO ( $dbspec, $username, $password, $options );
			$st = $db->prepare ( "DROP DATABASE if EXISTS $dbName" );
			$st->execute ();
			$st = $db->prepare ( "CREATE DATABASE $dbName" );
			$st->execute ();
			$st = $db->prepare ( "USE $dbName" );
			$st->execute ();
			$st = $db->prepare ( "DROP TABLE if EXISTS Users" );
			$st->execute ();
			$st = $db->prepare ( "CREATE TABLE Users (
  userId             int(11) NOT NULL AUTO_INCREMENT,
  userName           varchar (255) UNIQUE NOT NULL COLLATE utf8_unicode_ci,
  password           varchar(255) COLLATE utf8_unicode_ci,
  firstName			 varchar(255) COLLATE utf8_unicode_ci,
  lastName			 varchar(255) COLLATE utf8_unicode_ci,
  gender			 varchar(5) COLLATE utf8_unicode_ci,
  birthday           varchar(10) COLLATE utf8_unicode_ci,
  email				varchar(255) COLLATE utf8_unicode_ci,
  phoneNumber		varchar(255) COLLATE utf8_unicode_ci,
  dateCreated    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (userId)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;" );
			$st->execute ();
			
			$st = $db->prepare ( "DROP TABLE if EXISTS Lists" );
			$st->execute ();
			$st = $db->prepare ("CREATE TABLE Lists (
  listId       	  	 int(11) NOT NULL AUTO_INCREMENT,
  userId             int(11) NOT NULL COLLATE utf8_unicode_ci,
  typeOf			 varchar(6) NOT NULL COLLATE utf8_unicode_ci, 
  title			     varchar(255) NOT NULL COLLATE utf8_unicode_ci,
  dateCreated    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (listId),
  FOREIGN KEY (userId) REFERENCES Users(userId)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;" );
			$st->execute ();
			
			$st = $db->prepare ("DROP TABLE if EXISTS MovieLists");
			$st->execute ();
			
			$st = $db->prepare ("CREATE TABLE MovieLists (
		  			             movieId           int(11) NOT NULL AUTO_INCREMENT,
					             listId     	   int(11) NOT NULL,
					             title             varchar (255) NOT NULL COLLATE utf8_unicode_ci,
					             year              varchar(4),
					             dateCreated    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
					             PRIMARY KEY (movieId),
					             FOREIGN KEY (listId) REFERENCES Lists(listId)
			                 )ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;"
					        );
			$st->execute ();
			
		$sql = "INSERT INTO Users (userId, userName, password, firstName, lastName, gender, birthday, email, phoneNumber) VALUES
		                          (:userId, :userName, :password, :firstName, :lastName, :gender, :birthday, :email, :phoneNumber)";
		$st = $db->prepare($sql);
		$st->execute(array(':userId' => 1, ':userName' => 'jwachter', ':password' => 'superman', ':firstName'=>'bob', ':lastName'=>'smith', ':gender'=>'male', ':birthday'=>'2015-10', ':email'=>'a@a.com', ':phoneNumber'=>'555-555-5555'));
		$st->execute(array(':userId' => 2, ':userName' => 'joe', ':password' => 'superman', ':firstName'=>'bob', ':lastName'=>'smith', ':gender'=>'male', ':birthday'=>'2015-10', ':email'=>'a@a.com', ':phoneNumber'=>'555-555-5555'));
		
		$sql = "INSERT INTO Lists (listId, userId, typeOf, title)
	                             VALUES (:listId, :userId, :typeOf, :title)";
		$st = $db->prepare($sql);
		$st->execute(array(':listId'=> '1', ':userId' => '1', ':typeOf' => 'movie', ':title' => 'Action'));
		$st->execute(array(':listId'=> '2', ':userId' => '1', ':typeOf' => 'movie', ':title' => 'Fantasy'));
		$st->execute(array(':listId'=> '3', ':userId' => '2', ':typeOf' => 'series', ':title' => 'Comedy'));

		$sql = "INSERT INTO MovieLists (movieId, listId, title, year)
	                             VALUES (:movieId, :listId, :title, :year)";
		$st = $db->prepare($sql);
		$st->execute(array(':movieId'=> '1', ':listId' => '3', ':title' => 'How I Met Your Mother', ':year' => ''));
		$st->execute(array(':movieId'=> '2', ':listId' => '3', ':title' => 'The League', ':year' => ''));
		$st->execute(array(':movieId'=> '3', ':listId' => '1', ':title' => 'City of God', ':year' => ''));
		$st->execute(array(':movieId'=> '4', ':listId' => '2', ':title' => 'Matrix', ':year' => ''));
				
		} catch ( PDOException $e ) {
			echo $e->getMessage (); // not final error handling
		}
		
		return $db;
	}
	public static function delete($dbName) {
		// Delete a database named $dbName
		try {
			$dbspec = 'mysql:host=localhost;dbname=' . $dbName . ";charset=utf8";
			$passArray = parse_ini_file(Configuration::getConfigurationPath());
			$username = $passArray["username"];
			$password = $passArray["password"];
			$options = array (PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
			$db = new PDO ($dbspec, $username, $password, $options);
			$st = $db->prepare ("DROP DATABASE if EXISTS $dbName");
			$st->execute ();
		} catch ( PDOException $e ) {
			echo $e->getMessage (); // not final error handling
		}
	}
}
?>