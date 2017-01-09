DROP DATABASE if EXISTS wj_projectdb;
CREATE DATABASE wj_projectdb;
USE wj_projectdb;

DROP TABLE if EXISTS Users;
CREATE TABLE Users (
  userId             int(11) NOT NULL AUTO_INCREMENT,
  userName           varchar (255) UNIQUE NOT NULL COLLATE utf8_unicode_ci,
  passwordHash           varchar(255) COLLATE utf8_unicode_ci,
  firstName			 varchar(255) COLLATE utf8_unicode_ci,
  lastName			 varchar(255) COLLATE utf8_unicode_ci,
  gender			 varchar(5) COLLATE utf8_unicode_ci,
  birthday           varchar(10) COLLATE utf8_unicode_ci,
  email				varchar(255) COLLATE utf8_unicode_ci,
  phoneNumber		varchar(255) COLLATE utf8_unicode_ci,
  dateCreated    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (userId)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE if EXISTS Lists;
CREATE TABLE Lists (
  listId       	  	 int(11) NOT NULL AUTO_INCREMENT,
  userId             int(11) COLLATE utf8_unicode_ci,
  typeOf			 varchar(6) NOT NULL COLLATE utf8_unicode_ci, 
  title			     varchar(255) NOT NULL COLLATE utf8_unicode_ci,
  finalized	         boolean,
  public             boolean,
  dateCreated    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (listId),
  FOREIGN KEY (userId) REFERENCES Users(userId)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE if EXISTS PublicList;
CREATE TABLE PublicList (
  publicListId 	     int(11) NOT NULL AUTO_INCREMENT,
  listId             int(11) NOT NULL,
  points             int(11),
  title              varchar (255) UNIQUE NOT NULL COLLATE utf8_unicode_ci,
  dateCreated    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (publicListId),
  FOREIGN KEY (listId) REFERENCES Lists(listId)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE if EXISTS PointList;
CREATE TABLE PointList (
  pointListId 	     int(11) NOT NULL AUTO_INCREMENT,
  listId             int(11) NOT NULL,
  userId             int(11),
  point              int(1),
  dateCreated    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (pointListId),
  FOREIGN KEY (listId) REFERENCES PublicList(publicListId),
  FOREIGN KEY (userId) REFERENCES Users(userId)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE if EXISTS MovieLists;
CREATE TABLE MovieLists (
  movieId            int(11) NOT NULL AUTO_INCREMENT,
  listId             int(11) NOT NULL,
  title              varchar (255) NOT NULL COLLATE utf8_unicode_ci,
  year               varchar(4),
  watched            boolean,
  rank               int(12),
  dateCreated    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (movieId),
  FOREIGN KEY (listId) REFERENCES Lists(listId)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO Users (userId, userName, passwordHash, firstName, lastName, gender, birthday, email, phoneNumber) VALUES 
	   (1, 'jwachter', '$2y$10$x2ZrFnogatUKO.fKvaLw/unz1tc4MUKb39DgeCNsomvUALcang8U.', 'bob', 'smith', 'male', '11/16/2015','a@a.com', '555-555-5555');  
INSERT INTO Users (userId, userName, passwordHash, firstName, lastName, gender, birthday, email, phoneNumber) VALUES 
	   (2, 'joe', '$2y$10$x2ZrFnogatUKO.fKvaLw/unz1tc4MUKb39DgeCNsomvUALcang8U.', 'jane', 'doe', 'male', '11/16/2015', 'a@a.com', '555-555-5555');

	  
INSERT INTO Lists (listId, userId, typeOf, title,finalized,public) VALUES 
	   (1, 1, 'movie', 'Action',0,0);  
INSERT INTO Lists(listId, userId, typeOf, title,finalized,public) VALUES 
	   (2, 1, 'movie', 'Fantasy',0,0);
INSERT INTO Lists(listId, userId, typeOf, title,finalized,public) VALUES 
	   (3, 2, 'series', 'Comedy',0,0);
INSERT INTO Lists(listId, userId, typeOf, title,finalized,public) VALUES 
	   (4, 1, 'series', 'drama',0,0);
INSERT INTO Lists(listId, userId, typeOf, title,finalized,public) VALUES 
	   (5, 2, 'movie', 'drama',0,0);
	   
INSERT INTO MovieLists (movieId, listId, title, year,watched,rank) VALUES
	   (1, 3,'How I Met Your Mother','',0,2);	   	   
INSERT INTO MovieLists (movieId, listId, title, year,watched,rank) VALUES
	   (2, 3,'The League','',0,1);
INSERT INTO MovieLists (movieId, listId, title, year,watched,rank) VALUES
	   (5, 3,'Friends','',0,4);
INSERT INTO MovieLists (movieId, listId, title, year,watched,rank) VALUES
	   (6, 3,'Parenthood','',0,3);
INSERT INTO MovieLists (movieId, listId, title, year,watched,rank) VALUES 
	   (3, 1,'City of God','',0,1);
INSERT INTO MovieLists (movieId, listId, title, year,watched,rank) VALUES 
	   (4, 2,'Matrix','',0,1); 
	   
	   
	   
	  	   