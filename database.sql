DROP TABLE IF EXISTS superusers;
CREATE TABLE superusers (username varchar(50) PRIMARY KEY, password varchar(255) NOT NULL,name varchar(50));

DROP TABLE IF EXISTS users;

CREATE TABLE users (username varchar(50) PRIMARY KEY, password varchar(255) NOT NULL, email varchar(255), phone varchar(100), name varchar(50), Approved int (1), Enable int(1));

DROP TABLE IF EXISTS posts;,
CREATE TABLE posts (id int(11) PRIMARY KEY AUTO_INCREMENT,title varchar(255) NOT NULL,text text NOT NULL,published datetime DEFAULT NULL,Enable int (1),owner varchar(50),FOREIGN KEY (owner) REFERENCES users (username) ON DELETE CASCADE);

DROP TABLE IF EXISTS comments;
CREATE TABLE comments (id int(11) PRIMARY KEY AUTO_INCREMENT,title varchar(255) NOT NULL,content text NOT NULL,commenter varchar(255), time datetime DEFAULT NULL,postid int(11),FOREIGN KEY (postid) REFERENCES posts (id) ON DELETE CASCADE);

