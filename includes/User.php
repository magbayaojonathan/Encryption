<?php
require_once 'Cipher.php';
require_once 'SessionStorage.php';

class User {
    private $conn;
    private $storage;
    private $cipher;
    private $table = 'users';
    private $offline_mode = false;
    
    public $id;
    public $username;
    public $email;
    public $password_encrypted;
    public $full_name;
    public $phone;
    public $role;
    public $created_at;
    
    public function __construct($db) {
        $this->conn = $db->getConnection();
        $this->cipher = new Cipher();
        
        // Check if offline mode
        $this->offline_mode = defined('OFFLINE_MODE') && OFFLINE_MODE === true;
        if ($this->offline_mode) {
            $this->storage = new SessionStorage();
        }
    }
    
    /**
     * Register new user
     */
    public function register($username, $email, $password, $full_name, $phone = '') {
        // Use offline mode
        if ($this->offline_mode) {
            if ($this->storage->getUserByUsername($username)) {
                return ['success' => false, 'message' => 'User already exists'];
            }
            
            $user = $this->storage->registerUser($username, $email, $password, $full_name, $phone);
            
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];
                return ['success' => true, 'message' => 'User registered successfully'];
            }
            return ['success' => false, 'message' => 'Registration failed'];
        }
        
        // Database mode
        // Check if user already exists
        $query = "SELECT id FROM " . $this->table . " WHERE username = ? OR email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ss', $username, $email);
        $stmt->execute();
        
        if ($stmt->get_result()->num_rows > 0) {
            return ['success' => false, 'message' => 'User already exists'];
        }
        
        // Encrypt password
        $encrypted_password = $this->cipher->encrypt($password);
        $role = 'user';
        $created_at = date('Y-m-d H:i:s');
        
        $query = "INSERT INTO " . $this->table . " 
                 (username, email, password_encrypted, full_name, phone, role, created_at) 
                 VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('sssssss', $username, $email, $encrypted_password, $full_name, $phone, $role, $created_at);
        
        if ($stmt->execute()) {
            $_SESSION['user_id'] = $this->conn->insert_id;
            $_SESSION['username'] = $username;
            $_SESSION['full_name'] = $full_name;
            return ['success' => true, 'message' => 'User registered successfully'];
        }
        
        return ['success' => false, 'message' => 'Registration failed'];
    }
    
    /**
     * Login user
     */
    public function login($username, $password) {
        // Use offline mode
        if ($this->offline_mode) {
            $user = $this->storage->getUserByUsername($username);
            
            if ($user && $user['password'] === $password) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];
                return ['success' => true, 'message' => 'Login successful'];
            }
            
            return ['success' => false, 'message' => 'Invalid username or password'];
        }
        
        // Database mode
        $query = "SELECT id, username, email, password_encrypted, full_name, phone, role FROM " . $this->table . " 
                 WHERE (username = ? OR email = ?)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ss', $username, $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            
            // Decrypt stored password and compare with input
            $decrypted_password = $this->cipher->decrypt($row['password_encrypted']);
            
            if ($password === $decrypted_password) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['full_name'] = $row['full_name'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['role'] = $row['role'];
                return ['success' => true, 'message' => 'Login successful'];
            }
        }
        
        return ['success' => false, 'message' => 'Invalid username or password'];
    }
    
    /**
     * Get user by ID
     */
    public function getUserById($id) {
        if ($this->offline_mode) {
            return $this->storage->getUserById($id);
        }
        
        $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    /**
     * Update user profile
     */
    public function updateProfile($id, $full_name, $phone, $email) {
        if ($this->offline_mode) {
            // For offline mode, just update session
            $_SESSION['full_name'] = $full_name;
            return ['success' => true, 'message' => 'Profile updated successfully'];
        }
        
        $query = "UPDATE " . $this->table . " SET full_name = ?, phone = ?, email = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('sssi', $full_name, $phone, $email, $id);
        
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Profile updated successfully'];
        }
        return ['success' => false, 'message' => 'Update failed'];
    }
}
?>
