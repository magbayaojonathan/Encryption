<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'real_estate_db';
    private $user = 'root';
    private $password = '';
    private $conn;
    private $offline_mode = false;
    
    public function __construct() {
        // Check if offline mode is enabled
        $this->offline_mode = defined('OFFLINE_MODE') && OFFLINE_MODE === true;
    }
    
    /**
     * Connect to database or use session storage
     */
    public function connect() {
        if ($this->offline_mode) {
            // Return a mock connection object for compatibility
            $this->conn = new OfflineConnection();
            return $this->conn;
        }
        
        // Try to connect to database
        $this->conn = @new mysqli($this->host, $this->user, $this->password, $this->db_name);
        
        if ($this->conn && $this->conn->connect_error) {
            // Fall back to offline mode if connection fails
            error_log("Database connection failed: " . $this->conn->connect_error . ". Falling back to offline mode.");
            $this->offline_mode = true;
            $this->conn = new OfflineConnection();
            return $this->conn;
        }
        
        if ($this->conn) {
            $this->conn->set_charset("utf8");
        }
        
        return $this->conn;
    }
    
    /**
     * Get connection
     */
    public function getConnection() {
        return $this->conn;
    }
    
    /**
     * Check if in offline mode
     */
    public function isOffline() {
        return $this->offline_mode;
    }
}

/**
 * Mock connection object for offline mode
 */
class OfflineConnection {
    public function query($sql) {
        return new OfflineResult();
    }
    
    public function prepare($sql) {
        return new OfflinePreparedStatement($sql);
    }
}

/**
 * Mock result object for offline mode
 */
class OfflineResult {
    public function fetch_all($type = null) {
        return [];
    }
    
    public function fetch_assoc() {
        return null;
    }
    
    public $num_rows = 0;
}

/**
 * Mock prepared statement for offline mode
 */
class OfflinePreparedStatement {
    private $sql;
    
    public function __construct($sql) {
        $this->sql = $sql;
    }
    
    public function bind_param(...$params) {
        return true;
    }
    
    public function execute() {
        return true;
    }
    
    public function get_result() {
        return new OfflineResult();
    }
}
?>
