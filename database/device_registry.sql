-- Device Registry Database Schema
-- Compatible with MySQL/MariaDB (XAMPP)

CREATE DATABASE IF NOT EXISTS echo_did;
USE echo_did;

-- Table to store device registrations
CREATE TABLE IF NOT EXISTS devices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    device_did VARCHAR(255) NOT NULL UNIQUE,
    wallet_address VARCHAR(42) NOT NULL,
    device_password VARCHAR(255) NOT NULL,
    device_name VARCHAR(255),
    device_type VARCHAR(100),
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_authenticated TIMESTAMP NULL,
    is_active BOOLEAN DEFAULT TRUE,
    blockchain_tx_hash VARCHAR(66),
    INDEX idx_device_did (device_did),
    INDEX idx_wallet_address (wallet_address)
);

-- Table to store authentication logs
CREATE TABLE IF NOT EXISTS authentication_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    device_did VARCHAR(255) NOT NULL,
    wallet_address VARCHAR(42) NOT NULL,
    authentication_status ENUM('success', 'failed') NOT NULL,
    ip_address VARCHAR(45),
    user_agent TEXT,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (device_did) REFERENCES devices(device_did) ON DELETE CASCADE
);

-- Table to store admin users
CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL
);

-- Insert default admin user (password: admin123)
INSERT INTO admin_users (username, password_hash, email) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@deviceregistry.com');

-- View for device statistics
CREATE VIEW device_stats AS
SELECT 
    COUNT(*) as total_devices,
    COUNT(CASE WHEN is_active = TRUE THEN 1 END) as active_devices,
    COUNT(CASE WHEN DATE(registration_date) = CURDATE() THEN 1 END) as registered_today,
    COUNT(CASE WHEN DATE(last_authenticated) = CURDATE() THEN 1 END) as authenticated_today
FROM devices;
