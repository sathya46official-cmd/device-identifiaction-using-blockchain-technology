# Device DID Registry System

A complete blockchain-based Device Identity Management System with SQL database integration, built for XAMPP and Ethereum blockchain.

## Features

- **Blockchain Integration**: Ethereum smart contract for decentralized device registration
- **SQL Database**: MySQL/MariaDB backend for device tracking and analytics
- **Admin Panel**: Real-time dashboard for monitoring registered devices
- **Authentication Logs**: Track all authentication attempts with IP and timestamp
- **MetaMask Integration**: Secure wallet connectivity for blockchain transactions
- **XAMPP Compatible**: Designed to work seamlessly with XAMPP stack

## System Architecture

```
Frontend (HTML/CSS/JS) ↔ PHP API ↔ MySQL Database
                    ↓
            Ethereum Blockchain (Smart Contract)
```

## Prerequisites

1. **XAMPP** - Apache, MySQL, PHP stack
2. **MetaMask** - Browser extension for Ethereum wallet
3. **Node.js** (optional) - For development tools
4. **Remix IDE** - For smart contract deployment

## Installation & Setup

### 1. XAMPP Setup

1. Install XAMPP from [https://www.apachefriends.org/](https://www.apachefriends.org/)
2. Start Apache and MySQL services
3. Copy the project folder to `C:\xampp\htdocs\echo-did-interface`

### 2. Database Setup

1. Open phpMyAdmin: `http://localhost/phpmyadmin`
2. Import the database schema:
   ```sql
   -- Run the contents of database/device_registry.sql
   ```
3. Or create database manually:
   - Create database: `device_registry`
   - Import: `database/device_registry.sql`

### 3. Smart Contract Deployment

1. Open [Remix IDE](https://remix.ethereum.org/)
2. Copy the contents of `smart_contract.sol`
3. Compile with Solidity version `^0.8.19`
4. Deploy to your preferred network (Sepolia testnet recommended)
5. Copy the deployed contract address and ABI

### 4. Frontend Configuration

Update `app.js` with your deployed contract details:

```javascript
// Replace with your deployed contract address
const contractAddress = "YOUR_CONTRACT_ADDRESS_HERE";

// Update API URL if needed (default works for XAMPP)
const API_BASE_URL = "http://localhost/echo-did-interface/api";
```

### 5. MetaMask Setup

1. Install MetaMask browser extension
2. Create or import a wallet
3. Add test network (if using testnet)
4. Get test ETH from faucet for transactions

## Usage

### User Interface

1. **Access the application**: `http://localhost/echo-did-interface/`
2. **Register Device**:
   - Enter unique Device DID
   - Provide device name and type
   - Set secure password
   - Confirm MetaMask transaction
3. **Authenticate Device**:
   - Enter Device DID and password
   - System verifies against both database and blockchain

### Admin Panel

1. **Access admin panel**: `http://localhost/echo-did-interface/admin.html`
2. **Features**:
   - View all registered devices
   - Real-time statistics dashboard
   - Authentication logs monitoring
   - Search and filter devices
   - Auto-refresh every 30 seconds

## API Endpoints

### Device Management
- `GET /api/devices.php` - Get all devices
- `GET /api/devices.php?device_did=DID` - Get specific device
- `POST /api/devices.php` - Register new device
- `PUT /api/devices.php` - Update device
- `DELETE /api/devices.php` - Delete device

### Authentication
- `POST /api/auth.php?action=authenticate` - Authenticate device
- `GET /api/auth.php` - Get authentication logs

## Database Schema

### Tables

1. **devices** - Store device registrations
2. **authentication_logs** - Track auth attempts
3. **admin_users** - Admin panel access
4. **device_stats** - Statistics view

### Key Fields

- `device_did` - Unique device identifier
- `wallet_address` - Ethereum wallet address
- `device_password` - Hashed password
- `blockchain_tx_hash` - Transaction hash from registration
- `registration_date` - When device was registered
- `last_authenticated` - Last successful auth

## Smart Contract Functions

### Main Functions

- `registerDevice(deviceDID, passwordHash, deviceName, deviceType)` - Register new device
- `authenticateDevice(deviceDID, passwordHash)` - Authenticate device
- `getDeviceInfo(deviceDID)` - Get device information
- `deactivateDevice(deviceDID)` - Deactivate device
- `getTotalDevices()` - Get total device count

### Events

- `DeviceRegistered` - Emitted on successful registration
- `DeviceAuthenticated` - Emitted on successful authentication
- `DeviceDeactivated` - Emitted when device is deactivated

## Security Features

1. **Password Hashing**: Passwords are hashed using PHP's `password_hash()`
2. **Blockchain Verification**: Dual verification (database + blockchain)
3. **Input Validation**: Server-side validation for all inputs
4. **SQL Injection Protection**: Prepared statements used throughout
5. **CORS Protection**: Proper CORS headers configured

## Troubleshooting

### Common Issues

1. **MetaMask not connecting**:
   - Ensure MetaMask is installed and unlocked
   - Check if correct network is selected
   - Refresh page and try again

2. **Database connection failed**:
   - Verify MySQL is running in XAMPP
   - Check database credentials in `api/config.php`
   - Ensure database exists

3. **API calls failing**:
   - Check if Apache is running
   - Verify file permissions
   - Check browser console for CORS errors

4. **Smart contract errors**:
   - Ensure contract is deployed correctly
   - Verify contract address in `app.js`
   - Check if you have sufficient ETH for gas

### Error Codes

- `400` - Bad Request (missing parameters)
- `401` - Unauthorized (invalid credentials)
- `403` - Forbidden (device inactive)
- `404` - Not Found (device doesn't exist)
- `409` - Conflict (device already exists)
- `500` - Internal Server Error (database/server issue)

## Development

### File Structure

```
echo-did-interface/
├── index.html              # Main user interface
├── admin.html              # Admin dashboard
├── app.js                  # Frontend JavaScript
├── style.css               # Styling
├── smart_contract.sol      # Ethereum smart contract
├── api/
│   ├── config.php          # Database configuration
│   ├── devices.php         # Device management API
│   └── auth.php            # Authentication API
├── database/
│   └── device_registry.sql # Database schema
└── README.md               # This file
```

### Adding New Features

1. **Backend**: Add new endpoints in `api/` directory
2. **Frontend**: Update `app.js` and HTML files
3. **Database**: Modify schema in `database/device_registry.sql`
4. **Smart Contract**: Update `smart_contract.sol` and redeploy

## License

This project is open source and available under the MIT License.

## Support

For issues and questions:
1. Check the troubleshooting section
2. Review browser console for errors
3. Verify XAMPP services are running
4. Ensure MetaMask is properly configured

## Version History

- **v1.0.0** - Initial release with basic registration/authentication
- **v2.0.0** - Added SQL database integration and admin panel
- **v2.1.0** - Enhanced smart contract with better security features
