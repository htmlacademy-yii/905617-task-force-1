CREATE TABLE users (id INT(11) NOT NULL AUTO_INCREMENT, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, `password` VARCHAR(255) NOT NULL, phone VARCHAR(15) NOT NULL, status ENUM('0','1','2') NOT NULL DEFAULT '0', address VARCHAR(255), birthday DATE, info TEXT, avatar VARCHAR(255), skype VARCHAR(255), messenger VARCHAR(255), dt_add DATE NOT NULL, UNIQUE INDEX id(id)) CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE categories (id INT(11) NOT NULL AUTO_INCREMENT, name VARCHAR(50), icon VARCHAR(20), UNIQUE INDEX id(id)) CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE opinions (id INT(11) NOT NULL AUTO_INCREMENT, user_id INT(11), rate INT(11), description VARCHAR(255), dt_add DATE, UNIQUE INDEX id(id), FOREIGN KEY (user_id)  REFERENCES users (id)) CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE cities (id INT(11) NOT NULL AUTO_INCREMENT, city VARCHAR(50), lat DOUBLE, `long` DOUBLE, dt_add DATE, UNIQUE INDEX id(id)) CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE replies (id INT(11) NOT NULL AUTO_INCREMENT, user_id INT(11), rate INT(11), description VARCHAR(255), dt_add DATE, UNIQUE INDEX id(id), FOREIGN KEY (user_id)  REFERENCES users (id)) CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE tasks (id INT(11) NOT NULL AUTO_INCREMENT, user_id INT(11), dt_add DATE, category_id INT(11),description VARCHAR(255),expire DATE, name VARCHAR(50),address VARCHAR(255),budget INT(11), lat DOUBLE, `long` DOUBLE, UNIQUE INDEX id(id), FOREIGN KEY (user_id)  REFERENCES users (id)) CHARACTER SET utf8 COLLATE utf8_general_ci;




