CREATE DATABASE jm_informatica
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE jm_informatica;

CREATE TABLE user (
    id_user BIGINT(20) NOT NULL AUTO_INCREMENT,
    name VARCHAR(150),
    email VARCHAR(100),
    password VARCHAR(255), -- para usar a senha com password_hash
    created_at DATETIME,
    update_at DATETIME,
    ativo TINYINT(1),
    PRIMARY KEY (id_user)
);

CREATE TABLE service (
    id_service BIGINT(20) NOT NULL AUTO_INCREMENT,
    description VARCHAR(45),
    price DECIMAL(11,3),
    created_at DATETIME,
    update_at DATETIME,
    finished_at DATETIME,
    commission_user DECIMAL(11,3),
    user_id_user BIGINT(20),
    PRIMARY KEY (id_service),
    FOREIGN KEY (user_id_user) REFERENCES user(id_user)
);