CREATE DATABASE IF NOT EXISTS gym_management_simple;
USE gym_management_simple;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL
);

CREATE TABLE members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    gender VARCHAR(10) NOT NULL,
    join_date DATE NOT NULL,
    plan VARCHAR(50) NOT NULL
);

CREATE TABLE trainers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    specialization VARCHAR(100) NOT NULL
);

CREATE TABLE attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
    date DATE NOT NULL,
    status VARCHAR(20) NOT NULL
);

CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    date DATE NOT NULL
);

INSERT INTO users(username,password) VALUES ('admin','admin123');
INSERT INTO members(name,phone,gender,join_date,plan) VALUES
('Mithun','9876543210','Male',CURDATE(),'Monthly'),
('Rahul','9876501234','Male',CURDATE(),'Quarterly');
INSERT INTO trainers(name,phone,specialization) VALUES
('Arun','9988776655','Cardio'),
('Kiran','9988771122','Strength Training');
