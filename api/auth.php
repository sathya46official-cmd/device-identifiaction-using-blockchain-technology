<?php
require_once 'config.php';

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

switch($method) {
    case 'POST':
        if (isset($_GET['action']) && $_GET['action'] === 'authenticate') {
            authenticateDevice($input);
        } else {
            logAuthentication($input);
        }
        break;
    case 'GET':
        getAuthenticationLogs();
        break;
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
        break;
}

function authenticateDevice($data) {
    global $pdo;
    
    if (!isset($data['device_did']) || !isset($data['device_password'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing device DID or password']);
        return;
    }
    
    try {
        $stmt = $pdo->prepare("SELECT device_password, is_active FROM devices WHERE device_did = ?");
        $stmt->execute([$data['device_did']]);
        $device = $stmt->fetch();
        
        if ($device && password_verify($data['device_password'], $device['device_password'])) {
            if ($device['is_active']) {
                // Update last authenticated timestamp
                $updateStmt = $pdo->prepare("UPDATE devices SET last_authenticated = CURRENT_TIMESTAMP WHERE device_did = ?");
                $updateStmt->execute([$data['device_did']]);
                
                // Log successful authentication
                logAuthenticationAttempt($data['device_did'], $data['wallet_address'] ?? '', 'success');
                
                echo json_encode(['success' => true, 'message' => 'Authentication successful']);
            } else {
                logAuthenticationAttempt($data['device_did'], $data['wallet_address'] ?? '', 'failed');
                http_response_code(403);
                echo json_encode(['error' => 'Device is inactive']);
            }
        } else {
            logAuthenticationAttempt($data['device_did'], $data['wallet_address'] ?? '', 'failed');
            http_response_code(401);
            echo json_encode(['error' => 'Invalid credentials']);
        }
    } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
}

function logAuthenticationAttempt($device_did, $wallet_address, $status) {
    global $pdo;
    
    $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
    
    try {
        $stmt = $pdo->prepare("INSERT INTO authentication_logs (device_did, wallet_address, authentication_status, ip_address, user_agent) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$device_did, $wallet_address, $status, $ip_address, $user_agent]);
    } catch(PDOException $e) {
        // Log error but don't fail the main operation
        error_log("Failed to log authentication: " . $e->getMessage());
    }
}

function getAuthenticationLogs() {
    global $pdo;
    
    $limit = $_GET['limit'] ?? 100;
    $offset = $_GET['offset'] ?? 0;
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM authentication_logs ORDER BY timestamp DESC LIMIT ? OFFSET ?");
        $stmt->execute([$limit, $offset]);
        $logs = $stmt->fetchAll();
        
        echo json_encode(['success' => true, 'logs' => $logs]);
    } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
}
?>
