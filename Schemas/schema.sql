CREATE DATABASE bank;

USE bank;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    profile_pic VARCHAR(255),
    status ENUM('active', 'suspended') NOT NULL DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE accounts(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    account_type ENUM('current', 'savings') NOT NULL,
    balance DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    status ENUM('active', 'suspended') NOT NULL DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE transactions(
    id INT AUTO_INCREMENT PRIMARY KEY,
    account_id INT NOT NULL,
    transaction_type ENUM('deposit', 'withdrawal', 'transfer') NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    beneficiary_account_id INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (account_id) REFERENCES accounts(id) ON DELETE CASCADE
);

ALTER TABLE users
    ADD COLUMN role ENUM('admin', 'client') NOT NULL DEFAULT 'client';

ALTER TABLE accounts MODIFY COLUMN account_type ENUM('current', 'savings') NOT NULL;
