<?php
require_once 'config.php';

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

switch($method) {
    case 'GET':
        if (isset($_GET['device_did'])) {
            getDevice($_GET['device_did']);
        } else {
            getAllDevices();
        }
        break;
    case 'POST':
        registerDevice($input);
        break;
    case 'PUT':
        updateDevice($input);
        break;
    case 'DELETE':
        deleteDevice($input['device_did']);
        break;
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
        break;
}

function getAllDevices() {
    global $pdo;
    try {
        $stmt = $pdo->query("SELECT id, device_did, wallet_address, device_name, device_type, registration_date, last_authenticated, is_active FROM devices ORDER BY registration_date DESC");
        $devices = $stmt->fetchAll();
        echo json_encode(['success' => true, 'devices' => $devices]);
    } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
}

function getDevice($device_did) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("SELECT id, device_did, wallet_address, device_name, device_type, registration_date, last_authenticated, is_active FROM devices WHERE device_did = ?");
        $stmt->execute([$device_did]);
        $device = $stmt->fetch();
        
        if ($device) {
            echo json_encode(['success' => true, 'device' => $device]);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Device not found']);
        }
    } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
}

function registerDevice($data) {
    global $pdo;
    
    if (!isset($data['device_did']) || !isset($data['wallet_address']) || !isset($data['device_password'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required fields']);
        return;
    }
    
    try {
        // Hash the password
        $hashed_password = password_hash($data['device_password'], PASSWORD_DEFAULT);
        
        $stmt = $pdo->prepare("INSERT INTO devices (device_did, wallet_address, device_password, device_name, device_type, blockchain_tx_hash) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['device_did'],
            $data['wallet_address'],
            $hashed_password,
            $data['device_name'] ?? null,
            $data['device_type'] ?? 'Unknown',
            $data['blockchain_tx_hash'] ?? null
        ]);
        
        echo json_encode(['success' => true, 'message' => 'Device registered successfully']);
    } catch(PDOException $e) {
        if ($e->getCode() == 23000) { // Duplicate entry
            http_response_code(409);
            echo json_encode(['error' => 'Device DID already exists']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
        }
    }
}

function updateDevice($data) {
    global $pdo;
    
    if (!isset($data['device_did'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Device DID is required']);
        return;
    }
    
    try {
        $stmt = $pdo->prepare("UPDATE devices SET last_authenticated = CURRENT_TIMESTAMP WHERE device_did = ?");
        $stmt->execute([$data['device_did']]);
        
        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Device updated successfully']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Device not found']);
        }
    } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
}

function deleteDevice($device_did) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("DELETE FROM devices WHERE device_did = ?");
        $stmt->execute([$device_did]);
        
        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Device deleted successfully']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Device not found']);
        }
    } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
}
?>
