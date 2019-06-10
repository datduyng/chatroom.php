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


-- view message between a certain period
SELECT u.user_id, u.name as username, m.content, m.t_stamp FROM messages as m
INNER JOIN users as u ON u.user_id=m.user_id
WHERE t_stamp>='2019-6-7 9:44:44' AND t_stamp<'2019-6-7 9:52:52' 
ORDER BY t_stamp;
