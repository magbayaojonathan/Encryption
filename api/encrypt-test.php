<?php
/**
 * Encryption Test API
 * Allows frontend to test encryption without exposing it
 */

require_once 'includes/Cipher.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $text = $data['text'] ?? '';
    
    $cipher = new Cipher();
    $encrypted = $cipher->encrypt($text);
    
    echo json_encode([
        'success' => true,
        'plain' => $text,
        'encrypted' => $encrypted
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
}
?>
