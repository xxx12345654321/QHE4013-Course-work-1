--CREATE DATABASE car_sales;
--USE car_sales;

CREATE TABLE sellers (
    seller_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    address VARCHAR(255),
    phone VARCHAR(20),
    email VARCHAR(100) UNIQUE NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE cars (
    car_id INT AUTO_INCREMENT PRIMARY KEY,
    seller_id INT NOT NULL,
    colour VARCHAR(50),
    model VARCHAR(100),
    year INT,
    location VARCHAR(100),
    price DECIMAL(10,2),
    car_image VARCHAR(255),
    FOREIGN KEY (seller_id) REFERENCES sellers(seller_id)
);