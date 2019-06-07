CREATE DATABASE xampp;
use xampp; 


CREATE TABLE users (
	user_id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY, 
	name VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE messages (
	message_id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id INTEGER NOT NULL,
	content TEXT,
	FOREIGN KEY (user_id) REFERENCES users(user_id),
	t_stamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);


SELECT user_id, content, t_stamp FROM messages 
WHERE t_stamp>='2019-6-6 8:18:5' AND t_stamp<'2019-6-6 8:18:7' 
ORDER BY t_stamp