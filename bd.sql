CREATE TABLE cities
(
    id INT(11) NOT NULL AUTO_INCREMENT,
    city VARCHAR(50) NOT NULL,
    lat DOUBLE NOT NULL,
    `long` DOUBLE NOT NULL,
    dt_add DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE INDEX id(id)
)
    CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE users
(
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    status ENUM('0','1','2') NOT NULL DEFAULT '0',
    city_id INT NULL,
    avatar_file_id INT NULL,
    other_contact VARCHAR(255) NULL,
    dt_add DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    photo_id INT NULL,
    new_message TINYINT NOT NULL DEFAULT 1,
    action_task TINYINT NOT NULL DEFAULT 1,
    new_review TINYINT NOT NULL DEFAULT 1,
    show_contact TINYINT NOT NULL DEFAULT 1,
    show_profile TINYINT NOT NULL DEFAULT 1,
    UNIQUE INDEX id(id),
    FOREIGN KEY (city_id)  REFERENCES cities (id)
);

CREATE TABLE profiles
(
    id INT(11) NOT NULL AUTO_INCREMENT,
    user_id INT(11) NOT NULL,
    phone VARCHAR(15) NULL,
    address VARCHAR(255) NULL,
    bd DATE NULL,
    about TEXT NULL,
    skype VARCHAR(255) NULL,
    UNIQUE INDEX id(id),
    FOREIGN KEY (user_id)  REFERENCES users (id)
);

CREATE TABLE files
(
    id INT(11) NOT NULL AUTO_INCREMENT,
    user_id INT(11) NOT NULL,
    address_file VARCHAR(255) NOT NULL,
    UNIQUE INDEX id(id),
    FOREIGN KEY (user_id)  REFERENCES users (id)
);

CREATE TABLE categories
(
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    icon VARCHAR(20) NOT NULL,
    UNIQUE INDEX id(id)
);

CREATE TABLE tasks
(
    id INT(11) NOT NULL AUTO_INCREMENT,
    author_id INT(11) NOT NULL,
    executor_id INT NULL,
    dt_add DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    category_id INT(11) NOT NULL,
    description VARCHAR(1000) NOT NULL,
    expire DATE NULL,
    name VARCHAR(50) NOT NULL,
    address VARCHAR(255) NULL,
    city_id INT NULL,
    budget INT(11) NULL,
    lat DOUBLE NULL,
    `long` DOUBLE NULL,
    status TINYINT NOT NULL DEFAULT 1,
    UNIQUE INDEX id(id),
    FOREIGN KEY (executor_id)  REFERENCES users (id),
    FOREIGN KEY (author_id)  REFERENCES users (id),
    FOREIGN KEY (category_id)  REFERENCES categories (id),
    FOREIGN KEY (city_id)  REFERENCES cities (id)
);

CREATE TABLE replies
(
    id INT(11) NOT NULL AUTO_INCREMENT,
    executor_id INT(11) NOT NULL,
    task_id INT NOT NULL,
    rate INT(11) NULL,
    description VARCHAR(1000) NULL,
    dt_add DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE INDEX id(id),
    FOREIGN KEY (executor_id)  REFERENCES users (id),
    FOREIGN KEY (task_id)  REFERENCES tasks (id)
);

CREATE TABLE opinions
(
    id INT(11) NOT NULL AUTO_INCREMENT,
    executor_id INT(11) NOT NULL,
    task_id INT NOT NULL,
    rate TINYINT NULL,
    description VARCHAR(1000) NULL,
    dt_add DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE INDEX id(id),
    FOREIGN KEY (executor_id)  REFERENCES users (id),
    FOREIGN KEY (task_id)  REFERENCES tasks (id)
);

CREATE TABLE messages
(
    id INT(11) NOT NULL AUTO_INCREMENT,
    task_id INT NOT NULL,
    sender_id INT NOT NULL,
    recipient_id INT NOT NULL,
    dt_add DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    text TEXT NOT NULL,
    viewed TINYINT NOT NULL,
    UNIQUE INDEX id(id),
    FOREIGN KEY (sender_id)  REFERENCES users (id),
    FOREIGN KEY (recipient_id)  REFERENCES users (id)
);

CREATE TABLE category_user
(
    id INT(11) NOT NULL AUTO_INCREMENT,
    category_id INT(11) NOT NULL,
    user_id INT(11) NOT NULL,
    UNIQUE INDEX id(id),
    FOREIGN KEY (category_id)  REFERENCES categories (id),
    FOREIGN KEY (user_id)  REFERENCES users (id)
);








