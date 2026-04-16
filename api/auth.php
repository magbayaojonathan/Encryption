<?php
require_once '../includes/config.php';
require_once '../includes/Database.php';
require_once '../includes/User.php';

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $action = $data['action'] ?? '';
    
    $db = new Database();
    $db->connect();
    $user = new User($db);
    
    switch ($action) {
        case 'login':
            $username = $data['username'] ?? '';
            $password = $data['password'] ?? '';
            
            $result = $user->login($username, $password);
            echo json_encode($result);
            break;
            
        case 'register':
            $username = $data['username'] ?? '';
            $email = $data['email'] ?? '';
            $password = $data['password'] ?? '';
            $full_name = $data['full_name'] ?? '';
            $phone = $data['phone'] ?? '';
            
            $result = $user->register($username, $email, $password, $full_name, $phone);
            echo json_encode($result);
            break;
            
        case 'logout':
            session_destroy();
            echo json_encode(['success' => true, 'message' => 'Logged out successfully']);
            break;
            
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
