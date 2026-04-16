<?php
require_once '../includes/config.php';
require_once '../includes/Database.php';
require_once '../includes/SessionStorage.php';

if (!isLoggedIn()) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$db = new Database();
$db->connect();

// Check if offline mode
$offline_mode = defined('OFFLINE_MODE') && OFFLINE_MODE === true;
$storage = $offline_mode ? new SessionStorage() : null;

if ($method === 'GET') {
    $action = $_GET['action'] ?? 'list';
    $filter = $_GET['filter'] ?? 'all';
    
    if ($action === 'list') {
        $user_id = getCurrentUser();
        
        if ($offline_mode) {
            $properties = $storage->getProperties($filter, $user_id);
            echo json_encode(['success' => true, 'properties' => $properties]);
        } else {
            $conn = $db->getConnection();
            $query = "SELECT id, title, description, price, location, bedrooms, bathrooms, area_sqft, property_type 
                     FROM properties 
                     WHERE 1=1";
            
            if ($filter === 'my_listings') {
                $query .= " AND agent_id = $user_id";
            }
            
            $query .= " LIMIT 12";
            
            $result = $conn->query($query);
            $properties = $result->fetch_all(MYSQLI_ASSOC);
            
            echo json_encode(['success' => true, 'properties' => $properties]);
        }
    }
} elseif ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $action = $data['action'] ?? '';
    $user_id = getCurrentUser();
    
    switch ($action) {
        case 'toggle_favorite':
            $property_id = $data['property_id'] ?? 0;
            
            if ($offline_mode) {
                // Check if already favorited
                $favorites = $storage->getUserFavorites($user_id);
                $is_favorited = false;
                
                foreach ($favorites as $fav) {
                    if ($fav['id'] == $property_id) {
                        $is_favorited = true;
                        break;
                    }
                }
                
                if ($is_favorited) {
                    $storage->removeFavorite($user_id, $property_id);
                } else {
                    $storage->addFavorite($user_id, $property_id);
                }
                
                echo json_encode(['success' => true, 'message' => 'Favorite updated']);
            } else {
                $conn = $db->getConnection();
                // Check if already favorited
                $query = "SELECT id FROM favorites WHERE user_id = ? AND property_id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param('ii', $user_id, $property_id);
                $stmt->execute();
                
                if ($stmt->get_result()->num_rows > 0) {
                    // Remove favorite
                    $query = "DELETE FROM favorites WHERE user_id = ? AND property_id = ?";
                } else {
                    // Add favorite
                    $query = "INSERT INTO favorites (user_id, property_id) VALUES (?, ?)";
                }
                
                $stmt = $conn->prepare($query);
                $stmt->bind_param('ii', $user_id, $property_id);
                
                if ($stmt->execute()) {
                    echo json_encode(['success' => true, 'message' => 'Favorite updated']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to update']);
                }
            }
            break;
            
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
