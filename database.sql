CREATE DATABASE momoyo_membership;
USE momoyo_membership;


CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    membership_tier ENUM('Free', 'Classic', 'Premium') DEFAULT 'Free',
    profile_picture VARCHAR(255) DEFAULT NULL, 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    status VARCHAR(50) NOT NULL,
    payment_date DATETIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

INSERT INTO payments (user_id, amount, status, payment_date) 
VALUES (1, 250.00, 'Completed', NOW());

SELECT u.username, u.email, p.amount, p.status, p.payment_date
FROM users u
JOIN payments p ON u.user_id = p.user_id
WHERE u.user_id = 1; 



INSERT INTO users (username, email, password, membership_tier) VALUES (
    'testuser',
    'test@example.com',
    '$2y$10$8n3AkBllVcBepJnxWYgH3epSLtrrVm7EmGOKgyaI3kZx8Fyb95nEy', 
    'Classic'
);






