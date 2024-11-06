CREATE TABLE category_table (
    category_id INT PRIMARY KEY,
    category_name VARCHAR(50) NOT NULL,
    created_at DATE DEFAULT CURRENT_DATE
);

CREATE TABLE products_table (
    product_id INT PRIMARY KEY,
    product_name VARCHAR(50),
    category_id INT,
    price DECIMAL(6,2),
    quantity INT,
    created_at DATE DEFAULT CURRENT_DATE,
    FOREIGN KEY (category_id) REFERENCES category_table(category_id)
);

CREATE TABLE user_table (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    address VARCHAR(255),
    birthdate DATE NOT NULL,  
    gender VARCHAR(10) NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL,
    date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);