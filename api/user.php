<?php
require_once '../includes/config.php';
require_once '../includes/Database.php';
require_once '../includes/User.php';

if (!isLoggedIn()) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

header('Content-Type: application/json');

$db = new Database();
$db->connect();
$user_obj = new User($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $action = $data['action'] ?? '';
    $user_id = getCurrentUser();
    
    switch ($action) {
        case 'update_profile':
            $full_name = $data['full_name'] ?? '';
            $email = $data['email'] ?? '';
            $phone = $data['phone'] ?? '';
            
            $result = $user_obj->updateProfile($user_id, $full_name, $phone, $email);
            
            if ($result['success']) {
                $_SESSION['full_name'] = $full_name;
                $_SESSION['email'] = $email;
            }
            
            echo json_encode($result);
            break;
            
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
