<?php
/**
 * Session Storage - Alternative to Database for offline mode
 * Stores user data in session and mock data for properties
 */
class SessionStorage {
    private const USERS_KEY = 'offline_users';
    private const PROPERTIES_KEY = 'offline_properties';
    private const FAVORITES_KEY = 'offline_favorites';
    
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->initializeData();
    }
    
    /**
     * Initialize sample data if not exists
     */
    private function initializeData() {
        // Initialize users
        if (!isset($_SESSION[self::USERS_KEY])) {
            $_SESSION[self::USERS_KEY] = [
                [
                    'id' => 1,
                    'username' => 'demo',
                    'email' => 'demo@example.com',
                    'password' => 'password123',
                    'password_encrypted' => 'demo_encrypted',
                    'full_name' => 'Demo User',
                    'phone' => '555-0000',
                    'role' => 'user',
                    'created_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 2,
                    'username' => 'agent',
                    'email' => 'agent@example.com',
                    'password' => 'password123',
                    'password_encrypted' => 'agent_encrypted',
                    'full_name' => 'Real Estate Agent',
                    'phone' => '555-0001',
                    'role' => 'agent',
                    'created_at' => date('Y-m-d H:i:s')
                ]
            ];
        }
        
        // Initialize properties
        if (!isset($_SESSION[self::PROPERTIES_KEY])) {
            $_SESSION[self::PROPERTIES_KEY] = [
                [
                    'id' => 1,
                    'title' => 'Luxury Penthouse Downtown',
                    'description' => 'Stunning penthouse with panoramic city views',
                    'price' => 2500000,
                    'location' => 'Downtown',
                    'bedrooms' => 4,
                    'bathrooms' => 3,
                    'area_sqft' => 3500,
                    'property_type' => 'apartment',
                    'agent_id' => 2,
                    'created_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 2,
                    'title' => 'Modern Family Home',
                    'description' => 'Beautiful suburban home with large backyard',
                    'price' => 850000,
                    'location' => 'Suburban Heights',
                    'bedrooms' => 4,
                    'bathrooms' => 2,
                    'area_sqft' => 2800,
                    'property_type' => 'house',
                    'agent_id' => 2,
                    'created_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 3,
                    'title' => 'Beachfront Villa',
                    'description' => 'Exclusive beachfront property with direct ocean access',
                    'price' => 3200000,
                    'location' => 'Coastal Area',
                    'bedrooms' => 5,
                    'bathrooms' => 4,
                    'area_sqft' => 4200,
                    'property_type' => 'villa',
                    'agent_id' => 2,
                    'created_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 4,
                    'title' => 'City Studio Apartment',
                    'description' => 'Cozy studio perfect for professionals',
                    'price' => 450000,
                    'location' => 'City Center',
                    'bedrooms' => 1,
                    'bathrooms' => 1,
                    'area_sqft' => 650,
                    'property_type' => 'apartment',
                    'agent_id' => 2,
                    'created_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 5,
                    'title' => 'Historic Manor House',
                    'description' => 'Charming historic property with original features',
                    'price' => 1200000,
                    'location' => 'Historic District',
                    'bedrooms' => 6,
                    'bathrooms' => 3,
                    'area_sqft' => 3800,
                    'property_type' => 'house',
                    'agent_id' => 2,
                    'created_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 6,
                    'title' => 'Mountain Retreat',
                    'description' => 'Private cabin with mountain views and hiking trails',
                    'price' => 750000,
                    'location' => 'Mountain Region',
                    'bedrooms' => 3,
                    'bathrooms' => 2,
                    'area_sqft' => 2200,
                    'property_type' => 'cabin',
                    'agent_id' => 2,
                    'created_at' => date('Y-m-d H:i:s')
                ]
            ];
        }
        
        // Initialize favorites
        if (!isset($_SESSION[self::FAVORITES_KEY])) {
            $_SESSION[self::FAVORITES_KEY] = [];
        }
    }
    
    /**
     * Get user by username or email
     */
    public function getUserByUsername($username) {
        $users = $_SESSION[self::USERS_KEY] ?? [];
        foreach ($users as $user) {
            if ($user['username'] === $username || $user['email'] === $username) {
                return $user;
            }
        }
        return null;
    }
    
    /**
     * Get user by ID
     */
    public function getUserById($id) {
        $users = $_SESSION[self::USERS_KEY] ?? [];
        foreach ($users as $user) {
            if ($user['id'] == $id) {
                return $user;
            }
        }
        return null;
    }
    
    /**
     * Register new user
     */
    public function registerUser($username, $email, $password, $full_name, $phone = '') {
        $users = $_SESSION[self::USERS_KEY] ?? [];
        
        // Check if user exists
        foreach ($users as $user) {
            if ($user['username'] === $username || $user['email'] === $email) {
                return false;
            }
        }
        
        // Create new user
        $newUser = [
            'id' => max(array_column($users, 'id')) + 1,
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'password_encrypted' => password_hash($password, PASSWORD_DEFAULT),
            'full_name' => $full_name,
            'phone' => $phone,
            'role' => 'user',
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $users[] = $newUser;
        $_SESSION[self::USERS_KEY] = $users;
        return $newUser;
    }
    
    /**
     * Get all properties
     */
    public function getProperties($filter = 'all', $agent_id = null) {
        $properties = $_SESSION[self::PROPERTIES_KEY] ?? [];
        
        if ($filter === 'my_listings' && $agent_id) {
            $properties = array_filter($properties, function($p) use ($agent_id) {
                return $p['agent_id'] == $agent_id;
            });
        }
        
        return array_values($properties);
    }
    
    /**
     * Get property by ID
     */
    public function getPropertyById($id) {
        $properties = $_SESSION[self::PROPERTIES_KEY] ?? [];
        foreach ($properties as $property) {
            if ($property['id'] == $id) {
                return $property;
            }
        }
        return null;
    }
    
    /**
     * Add favorite
     */
    public function addFavorite($user_id, $property_id) {
        $favorites = $_SESSION[self::FAVORITES_KEY] ?? [];
        
        // Check if already favorited
        foreach ($favorites as $fav) {
            if ($fav['user_id'] == $user_id && $fav['property_id'] == $property_id) {
                return false; // Already favorited
            }
        }
        
        $favorites[] = [
            'id' => max(array_column($favorites, 'id') ?: [0]) + 1,
            'user_id' => $user_id,
            'property_id' => $property_id
        ];
        
        $_SESSION[self::FAVORITES_KEY] = $favorites;
        return true;
    }
    
    /**
     * Remove favorite
     */
    public function removeFavorite($user_id, $property_id) {
        $favorites = $_SESSION[self::FAVORITES_KEY] ?? [];
        
        foreach ($favorites as $key => $fav) {
            if ($fav['user_id'] == $user_id && $fav['property_id'] == $property_id) {
                unset($favorites[$key]);
                $_SESSION[self::FAVORITES_KEY] = array_values($favorites);
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Get user favorites
     */
    public function getUserFavorites($user_id) {
        $favorites = $_SESSION[self::FAVORITES_KEY] ?? [];
        $properties = $_SESSION[self::PROPERTIES_KEY] ?? [];
        $favoriteIds = array_column(
            array_filter($favorites, function($f) use ($user_id) {
                return $f['user_id'] == $user_id;
            }),
            'property_id'
        );
        
        return array_filter($properties, function($p) use ($favoriteIds) {
            return in_array($p['id'], $favoriteIds);
        });
    }
}
?>
