CREATE DATABASE car_sales;
USE car_sales;
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
INSERT INTO sellers (name,email,username, password) VALUES ('admin','admin@qq.com','admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

drop table cars;
CREATE TABLE cars (
    car_id INT AUTO_INCREMENT PRIMARY KEY,
    seller_id INT NOT NULL,
    make VARCHAR(100),
    model VARCHAR(100),
    year INT,
    price DECIMAL(10,2),
    description TEXT,
    car_image VARCHAR(255),
    FOREIGN KEY (seller_id) REFERENCES sellers(seller_id)
);