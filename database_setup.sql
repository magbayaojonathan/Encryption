-- Real Estate Login Database Setup

CREATE DATABASE IF NOT EXISTS real_estate_db;
USE real_estate_db;

-- Users Table with encrypted passwords
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_encrypted VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    role ENUM('admin', 'agent', 'user') DEFAULT 'user',
    profile_image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    is_active BOOLEAN DEFAULT TRUE,
    INDEX idx_username (username),
    INDEX idx_email (email)
);

-- Properties Table
CREATE TABLE IF NOT EXISTS properties (
    id INT PRIMARY KEY AUTO_INCREMENT,
    agent_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description LONGTEXT,
    price DECIMAL(12, 2) NOT NULL,
    location VARCHAR(255) NOT NULL,
    bedrooms INT,
    bathrooms INT,
    area_sqft INT,
    property_type ENUM('house', 'apartment', 'commercial', 'land') DEFAULT 'house',
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (agent_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_agent (agent_id),
    INDEX idx_price (price)
);

-- Favorites Table
CREATE TABLE IF NOT EXISTS favorites (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    property_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (property_id) REFERENCES properties(id) ON DELETE CASCADE,
    UNIQUE KEY unique_favorite (user_id, property_id)
);

-- Sample Users (Passwords are encrypted using custom cipher, NOT hashed)
-- Cipher Encryption Examples:
-- 'password123' → '>=||_@(/JTA' (p→>, a→=, s→|, s→|, w→_, o→@, r→(, d→/, 1→J, 2→T, 3→A)
-- 'Pass123' → '>=||JTA' (P→>, a→=, s→|, s→|, 1→J, 2→T, 3→A)
-- 'demo' → '/,<@' (d→/, e→,, m→<, o→@)
INSERT IGNORE INTO users (username, email, password_encrypted, full_name, phone, role) 
VALUES 
('demo', 'demo@realestate.com', '>=||_@(/JTA', 'Demo User', '555-1234', 'user'),
('agent', 'agent@realestate.com', '>=||_@(/JTA', 'Real Estate Agent', '555-5678', 'agent'),
('admin', 'admin@realestate.com', '>=||_@(/JTA', 'Admin User', '555-9999', 'admin');
