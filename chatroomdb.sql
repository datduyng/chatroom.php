/** 
 * Author: Dat Nguyen 
 * Version of Date: 5/20/19
 * Chatroom Database design
 */ 


DROP DATABASE simple_chatroom;
CREATE DATABASE simple_chatroom;
use simple_chatroom;

CREATE TABLE users (
	user_id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY, 
	name VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE chatrooms (
	room_id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY, 
	name VARCHAR(255) NOT NULL UNIQUE
);

/* 
 * Join table for user and chatroom
 * since, user can join multiple room
 * and one room can have multiple user.
 */
CREATE TABLE user_chatroom (
    room_id INTEGER NOT NULL,
    user_id INTEGER NOT NULL,
	FOREIGN KEY (room_id) REFERENCES chatrooms(room_id),
	FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE messages (
	message_id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    room_id INTEGER NOT NULL,
    user_id INTEGER NOT NULL,
	content TEXT,
	FOREIGN KEY (room_id) REFERENCES chatrooms(room_id),
	FOREIGN KEY (user_id) REFERENCES users(user_id)
);

/** 
 * Testing
 */
INSERT INTO users (name) VALUES ("messi");
INSERT INTO users (name) VALUES ("mzberg"); 
INSERT INTO users (name) VALUES ("sjob");
SELECT * FROM users;

INSERT INTO chatrooms (name) VALUES ("deeplearning"); 
INSERT INTO chatrooms (name) VALUES ("tech");
SELECT * FROM chatrooms;

INSERT INTO user_chatroom (user_id, room_id) VALUES (2, 1);
INSERT INTO user_chatroom (user_id, room_id) VALUES (1, 1);
INSERT INTO user_chatroom (user_id, room_id) VALUES (3, 2); 
SELECT * FROM user_chatroom;