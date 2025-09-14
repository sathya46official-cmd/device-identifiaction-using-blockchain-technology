<?php
// Start session and check authentication
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Device Registry - Admin Panel</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .admin-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background-color: #444;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        
        .stat-number {
            font-size: 2em;
            color: #ffcc00;
            font-weight: bold;
        }
        
        .devices-table {
            background-color: #333;
            border-radius: 10px;
            overflow: hidden;
            margin-top: 20px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #555;
        }
        
        th {
            background-color: #444;
            color: #ffcc00;
            font-weight: bold;
        }
        
        .status-active {
            color: #4CAF50;
        }
        
        .status-inactive {
            color: #f44336;
        }
        
        .refresh-btn {
            background-color: #ffcc00;
            color: #333;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 20px;
        }
        
        .refresh-btn:hover {
            background-color: #e6b800;
        }
        
        .search-box {
            width: 300px;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #555;
            border-radius: 5px;
            background-color: #222;
            color: white;
        }
        
        .auth-logs {
            margin-top: 40px;
        }
        
        .log-entry {
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            background-color: #444;
        }
        
        .log-success {
            border-left: 4px solid #4CAF50;
        }
        
        .log-failed {
            border-left: 4px solid #f44336;
        }
    </style>
</head>
<body>
    
    <div class="admin-container">
        <div id="adminContent">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h1>Device Registry - Admin Panel</h1>
                <div>
                    <span id="adminUsername" style="color: #ffcc00; margin-right: 20px;">
                        Welcome, <?php echo htmlspecialchars($_SESSION['admin_user']); ?>
                    </span>
                    <button onclick="logout()" style="background-color: #f44336; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer;">Logout</button>
                </div>
            </div>
        
        <!-- Statistics Dashboard -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number" id="totalDevices">0</div>
                <div>Total Devices</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" id="activeDevices">0</div>
                <div>Active Devices</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" id="todayRegistrations">0</div>
                <div>Registered Today</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" id="todayAuthentications">0</div>
                <div>Authenticated Today</div>
            </div>
        </div>
        
        <!-- Controls -->
        <button class="refresh-btn" onclick="loadDevices()">Refresh Data</button>
        <input type="text" class="search-box" id="searchBox" placeholder="Search devices..." onkeyup="filterDevices()">
        
        <!-- Devices Table -->
        <div class="devices-table">
            <table>
                <thead>
                    <tr>
                        <th>Device DID</th>
                        <th>Device Name</th>
                        <th>Device Type</th>
                        <th>Wallet Address</th>
                        <th>Registration Date</th>
                        <th>Last Authenticated</th>
                        <th>Status</th>
                        <th>Blockchain TX</th>
                    </tr>
                </thead>
                <tbody id="devicesTableBody">
                    <!-- Devices will be loaded here -->
                </tbody>
            </table>
        </div>
        
        <!-- Authentication Logs -->
        <div class="auth-logs">
            <h2 style="color: #333; background: rgba(255, 255, 255, 0.9); padding: 15px; border-radius: 8px; margin-bottom: 20px;">Recent Authentication Logs</h2>
            <div id="authLogsContainer" style="background: rgba(255, 255, 255, 0.9); padding: 20px; border-radius: 12px; min-height: 200px;">
                <!-- Logs will be loaded here -->
            </div>
        </div>
        </div>
    </div>

    <script>
        const API_BASE_URL = "http://localhost/echo-did-interface/api";
        
        function logout() {
            window.location.href = 'logout.php';
        }
        
        async function loadDevices() {
            try {
                const response = await fetch(`${API_BASE_URL}/devices.php`);
                const result = await response.json();
                
                if (result.success) {
                    displayDevices(result.devices);
                    updateStatistics(result.devices);
                } else {
                    console.error('Failed to load devices:', result.error);
                }
            } catch (error) {
                console.error('Error loading devices:', error);
            }
        }
        
        function displayDevices(devices) {
            const tbody = document.getElementById('devicesTableBody');
            tbody.innerHTML = '';
            
            devices.forEach(device => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${device.device_did}</td>
                    <td>${device.device_name || 'N/A'}</td>
                    <td>${device.device_type || 'N/A'}</td>
                    <td title="${device.wallet_address}">${device.wallet_address.substring(0, 10)}...</td>
                    <td>${new Date(device.registration_date).toLocaleDateString()}</td>
                    <td>${device.last_authenticated ? new Date(device.last_authenticated).toLocaleDateString() : 'Never'}</td>
                    <td class="${device.is_active ? 'status-active' : 'status-inactive'}">
                        ${device.is_active ? 'Active' : 'Inactive'}
                    </td>
                    <td title="${device.blockchain_tx_hash || 'N/A'}">
                        ${device.blockchain_tx_hash ? device.blockchain_tx_hash.substring(0, 10) + '...' : 'N/A'}
                    </td>
                `;
                tbody.appendChild(row);
            });
        }
        
        function updateStatistics(devices) {
            const today = new Date().toDateString();
            
            document.getElementById('totalDevices').textContent = devices.length;
            document.getElementById('activeDevices').textContent = devices.filter(d => d.is_active).length;
            document.getElementById('todayRegistrations').textContent = devices.filter(d => 
                new Date(d.registration_date).toDateString() === today
            ).length;
            document.getElementById('todayAuthentications').textContent = devices.filter(d => 
                d.last_authenticated && new Date(d.last_authenticated).toDateString() === today
            ).length;
        }
        
        function filterDevices() {
            const searchTerm = document.getElementById('searchBox').value.toLowerCase();
            const rows = document.querySelectorAll('#devicesTableBody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        }
        
        async function loadAuthenticationLogs() {
            try {
                const response = await fetch(`${API_BASE_URL}/auth.php?limit=20`);
                const result = await response.json();
                
                if (result.success) {
                    displayAuthLogs(result.logs);
                }
            } catch (error) {
                console.error('Error loading auth logs:', error);
            }
        }
        
        function displayAuthLogs(logs) {
            const container = document.getElementById('authLogsContainer');
            container.innerHTML = '';
            
            logs.forEach(log => {
                const logEntry = document.createElement('div');
                logEntry.className = `log-entry log-${log.authentication_status}`;
                logEntry.innerHTML = `
                    <strong>${log.device_did}</strong> - ${log.authentication_status}
                    <br>
                    <small>
                        ${new Date(log.timestamp).toLocaleString()} | 
                        IP: ${log.ip_address} | 
                        Wallet: ${log.wallet_address.substring(0, 10)}...
                    </small>
                `;
                container.appendChild(logEntry);
            });
        }
        
        window.onload = function() {
            loadDevices();
            loadAuthenticationLogs();
            
            setInterval(() => {
                loadDevices();
                loadAuthenticationLogs();
            }, 30000);
        };
    </script>
</body>
</html>
