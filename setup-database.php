<?php
/**
 * Database Setup Script
 * Run this script once to initialize the database with encrypted passwords
 */

header('Content-Type: text/html; charset=utf-8');

$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'real_estate_db';

// Create connection
$conn = new mysqli($host, $user, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h1>🏠 Elite Homes - Database Setup</h1>";
echo "<hr>";

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS " . $dbname;
if ($conn->query($sql) === TRUE) {
    echo "✓ Database created successfully<br>";
} else {
    echo "✗ Error creating database: " . $conn->error . "<br>";
}

// Select database
$conn->select_db($dbname);

// Create users table
$sql = "CREATE TABLE IF NOT EXISTS users (
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
)";

if ($conn->query($sql) === TRUE) {
    echo "✓ Users table created successfully<br>";
} else {
    echo "✗ Error creating users table: " . $conn->error . "<br>";
}

// Create properties table
$sql = "CREATE TABLE IF NOT EXISTS properties (
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
)";

if ($conn->query($sql) === TRUE) {
    echo "✓ Properties table created successfully<br>";
} else {
    echo "✗ Error creating properties table: " . $conn->error . "<br>";
}

// Create favorites table
$sql = "CREATE TABLE IF NOT EXISTS favorites (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    property_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (property_id) REFERENCES properties(id) ON DELETE CASCADE,
    UNIQUE KEY unique_favorite (user_id, property_id)
)";

if ($conn->query($sql) === TRUE) {
    echo "✓ Favorites table created successfully<br>";
} else {
    echo "✗ Error creating favorites table: " . $conn->error . "<br>";
}

// Clear existing test users
$sql = "DELETE FROM users WHERE username IN ('demo', 'agent', 'admin')";
$conn->query($sql);

// Insert test users with encrypted passwords
// Encrypted using Custom Cipher:
// 'password123' → '>=||_@(/JTA'
$sql = "INSERT INTO users (username, email, password_encrypted, full_name, phone, role) 
VALUES 
('demo', 'demo@realestate.com', '>=||_@(/JTA', 'Demo User', '555-1234', 'user'),
('agent', 'agent@realestate.com', '>=||_@(/JTA', 'Real Estate Agent', '555-5678', 'agent'),
('admin', 'admin@realestate.com', '>=||_@(/JTA', 'Admin User', '555-9999', 'admin')";

if ($conn->query($sql) === TRUE) {
    echo "✓ Test users inserted with encrypted passwords<br>";
} else {
    echo "✗ Error inserting test users: " . $conn->error . "<br>";
}

// Insert sample properties
$sql = "INSERT IGNORE INTO properties (agent_id, title, description, price, location, bedrooms, bathrooms, area_sqft, property_type) 
VALUES 
(2, 'Luxury Penthouse Downtown', 'Stunning penthouse with panoramic city views', 2500000, 'Downtown', 4, 3, 3500, 'apartment'),
(2, 'Modern Family Home', 'Beautiful suburban home with large backyard', 850000, 'Suburban Heights', 4, 2, 2800, 'house'),
(2, 'Beachfront Villa', 'Exclusive oceanfront property with private beach access', 5200000, 'Beach Haven', 5, 4, 4200, 'house'),
(2, 'Downtown Office Space', 'Prime commercial space with modern amenities', 1500000, 'Business District', 0, 0, 2500, 'commercial'),
(2, 'Cozy Apartment', 'Perfect starter home in vibrant neighborhood', 425000, 'Arts District', 2, 1, 900, 'apartment'),
(2, 'Investment Land Opportunity', 'Prime land ready for development', 750000, 'Industrial Zone', 0, 0, 5000, 'land')";

if ($conn->query($sql) === TRUE) {
    echo "✓ Sample properties inserted<br>";
} else {
    echo "✗ Error inserting properties: " . $conn->error . "<br>";
}

echo "<hr>";
echo "<h2>✓ Database Setup Complete!</h2>";
echo "<h3>Test Login Credentials:</h3>";
echo "<ul>";
echo "<li><strong>Username:</strong> demo | <strong>Password:</strong> password123</li>";
echo "<li><strong>Username:</strong> agent | <strong>Password:</strong> password123</li>";
echo "<li><strong>Username:</strong> admin | <strong>Password:</strong> password123</li>";
echo "</ul>";
echo "<h3>Encryption Details:</h3>";
echo "<p>All passwords are encrypted using a custom cipher (not hashed):</p>";
echo "<ul>";
echo "<li><strong>Original:</strong> password123</li>";
echo "<li><strong>Encrypted:</strong> >=||_@(/JTA</li>";
echo "<li><strong>Cipher:</strong> p→>, a→=, s→|, s→|, w→_, o→@, r→(, d→/, 1→J, 2→T, 3→A</li>";
echo "</ul>";
echo "<p><a href='login.php'>← Back to Login</a></p>";

$conn->close();
?>
