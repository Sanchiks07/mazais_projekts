CREATE DATABASE ipb23_sm;

USE ipb23_sm;

CREATE TABLE users (
    id INT(10) AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    phone VARCHAR(25) NOT NULL,
    email VARCHAR(255) NOT NULL,
    birthday DATE NOT NULL,
    password VARCHAR(255) NOT NULL
)