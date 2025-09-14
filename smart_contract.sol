// SPDX-License-Identifier: MIT
pragma solidity ^0.8.19;

contract DeviceRegistry {
    struct Device {
        string did;
        string passwordHash;
        string deviceName;
        string deviceType;
        uint256 registrationTime;
        uint256 lastAuthenticated;
        bool isActive;
        bool registered;
    }

    mapping(address => mapping(string => Device)) public devices;
    mapping(string => address) public deviceOwners; // DID => Owner address
    
    address public owner;
    uint256 public totalDevices;
    
    event DeviceRegistered(
        address indexed owner, 
        string indexed deviceDID, 
        string deviceName,
        string deviceType,
        uint256 timestamp
    );
    
    event DeviceAuthenticated(
        address indexed owner,
        string indexed deviceDID,
        uint256 timestamp
    );
    
    event DeviceDeactivated(
        address indexed owner,
        string indexed deviceDID,
        uint256 timestamp
    );

    modifier onlyOwner() {
        require(msg.sender == owner, "Only contract owner can call this function");
        _;
    }

    modifier deviceExists(string memory deviceDID) {
        require(devices[msg.sender][deviceDID].registered, "Device not registered");
        _;
    }

    constructor() {
        owner = msg.sender;
    }

    function registerDevice(
        string memory deviceDID,
        string memory passwordHash,
        string memory deviceName,
        string memory deviceType
    ) public {
        require(bytes(deviceDID).length > 0, "Device DID cannot be empty");
        require(bytes(passwordHash).length > 0, "Password hash cannot be empty");
        require(!devices[msg.sender][deviceDID].registered, "Device already registered");
        require(deviceOwners[deviceDID] == address(0), "Device DID already exists globally");

        devices[msg.sender][deviceDID] = Device({
            did: deviceDID,
            passwordHash: passwordHash,
            deviceName: deviceName,
            deviceType: deviceType,
            registrationTime: block.timestamp,
            lastAuthenticated: 0,
            isActive: true,
            registered: true
        });

        deviceOwners[deviceDID] = msg.sender;
        totalDevices++;

        emit DeviceRegistered(msg.sender, deviceDID, deviceName, deviceType, block.timestamp);
    }

    function authenticateDevice(
        string memory deviceDID,
        string memory passwordHash
    ) public deviceExists(deviceDID) returns (bool) {
        Device storage device = devices[msg.sender][deviceDID];
        
        require(device.isActive, "Device is deactivated");
        
        bool isValid = keccak256(abi.encodePacked(device.passwordHash)) == keccak256(abi.encodePacked(passwordHash));
        
        if (isValid) {
            device.lastAuthenticated = block.timestamp;
            emit DeviceAuthenticated(msg.sender, deviceDID, block.timestamp);
        }
        
        return isValid;
    }

    function deactivateDevice(string memory deviceDID) public deviceExists(deviceDID) {
        devices[msg.sender][deviceDID].isActive = false;
        emit DeviceDeactivated(msg.sender, deviceDID, block.timestamp);
    }

    function reactivateDevice(string memory deviceDID) public deviceExists(deviceDID) {
        devices[msg.sender][deviceDID].isActive = true;
    }

    function getDeviceInfo(string memory deviceDID) public view returns (
        string memory did,
        string memory deviceName,
        string memory deviceType,
        uint256 registrationTime,
        uint256 lastAuthenticated,
        bool isActive,
        bool registered
    ) {
        Device memory device = devices[msg.sender][deviceDID];
        return (
            device.did,
            device.deviceName,
            device.deviceType,
            device.registrationTime,
            device.lastAuthenticated,
            device.isActive,
            device.registered
        );
    }

    function isDeviceRegistered(address deviceOwner, string memory deviceDID) public view returns (bool) {
        return devices[deviceOwner][deviceDID].registered;
    }

    function getDeviceOwner(string memory deviceDID) public view returns (address) {
        return deviceOwners[deviceDID];
    }

    function getTotalDevices() public view returns (uint256) {
        return totalDevices;
    }

    // Get all device DIDs for an owner (useful for admin panel)
    function getUserDevices(address user) public view returns (string[] memory) {
        // Note: This is a simplified version. In production, you'd implement pagination
        // For now, return empty array as this would require additional mapping
        string[] memory empty;
        return empty;
    }
}
