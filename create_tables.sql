CREATE TABLE users (
user_id INT NOT NULL AUTO_INCREMENT,
username VARCHAR(255) NOT NULL,
email VARCHAR(255) NOT NULL,
psw_hash VARCHAR(255) NOT NULL,
created DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
UNIQUE (user_id),
UNIQUE (username),
PRIMARY KEY(user_id)
);

CREATE TABLE tasks (
task_id INT NOT NULL AUTO_INCREMENT,
user_id INT NOT NULL DEFAULT 1,
title VARCHAR(50) NOT NULL,
description VARCHAR(255) NOT NULL,
completed TINYINT(1) NOT NULL DEFAULT -1,
created DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY(task_id),
FOREIGN KEY (user_id) REFERENCES users(user_id)
);

INSERT INTO `users` (`username`, `email`, `psw_hash`, `created`)
VALUES ('root', 'root@root.com', '$2y$10$jMNOug.OH1RGBPLpSBdVf.vxOf7AHfQ7n30m/I58yE6vpX0uow04.', now());

INSERT INTO `tasks` (`title`, `description`)
VALUES ('Finish this app', 'Really write ALL the code...');

