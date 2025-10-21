CREATE TABLE customers (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, 
    phone VARCHAR(20),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO customers (name, email, password) VALUES
('Sari Dewi', 'sari@mail.com', '123456'),
('Budi Santoso', 'budi@mail.com', '123456');

CREATE TABLE cakes (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image_path VARCHAR(255),
    stock INT(11) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO cakes (name, description, price, image_path, stock) VALUES
('Chocolate Dream Cake', 'Rich and moist dark chocolate cake with smooth chocolate ganache and sprinkles.', 250000.00, 'assets/images/1.jpg', 15),
('Fresh Strawberry Delight', 'Light vanilla sponge layered with fresh cream and sweet strawberry slices.', 220000.00, 'assets/images/2.jpg', 10),
('Classic New York Cheesecake', 'Creamy baked cheesecake on a buttery graham cracker crust.', 300000.00, 'assets/images/3.jpg', 8);

CREATE TABLE orders (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    customer_id INT(11),
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total_amount DECIMAL(10, 2) NOT NULL,
    status ENUM('Pending', 'Processing', 'Delivered', 'Cancelled') DEFAULT 'Pending',
    FOREIGN KEY (customer_id) REFERENCES customers(id)
);