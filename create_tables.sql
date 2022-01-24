CREATE TABLE users (
user_id INT NOT NULL AUTO_INCREMENT,
first_name VARCHAR(255) NOT NULL,
last_name VARCHAR(255) NOT NULL,
email VARCHAR(255) NOT NULL,
password_hash BINARY(20) NOT NULL,
created DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
UNIQUE (user_id),
UNIQUE (email),
PRIMARY KEY(user_id)
);

CREATE TABLE tasks (
task_id INT NOT NULL AUTO_INCREMENT,
user_id INT DEFAULT 1,
title VARCHAR(50),
description VARCHAR(255),
completed TINYINT(1) NOT NULL DEFAULT 0,
created DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY(task_id),
FOREIGN KEY (user_id) REFERENCES users(user_id)
);

INSERT INTO `users` (`first_name`, `last_name`, `email`, `password_hash`, `created`)
VALUES ('root', 'root', 'root', UNHEX(md5('root')), now());

INSERT INTO `tasks` (`title`, `description`)
VALUES ('Finish this app', 'Really write ALL the code...');

