// Updated ABI for the new smart contract - REPLACE WITH YOUR DEPLOYED CONTRACT ABI
const contractABI =[
	{
		"inputs": [],
		"stateMutability": "nonpayable",
		"type": "constructor"
	},
	{
		"anonymous": false,
		"inputs": [
			{
				"indexed": true,
				"internalType": "address",
				"name": "owner",
				"type": "address"
			},
			{
				"indexed": true,
				"internalType": "string",
				"name": "deviceDID",
				"type": "string"
			},
			{
				"indexed": false,
				"internalType": "uint256",
				"name": "timestamp",
				"type": "uint256"
			}
		],
		"name": "DeviceAuthenticated",
		"type": "event"
	},
	{
		"anonymous": false,
		"inputs": [
			{
				"indexed": true,
				"internalType": "address",
				"name": "owner",
				"type": "address"
			},
			{
				"indexed": true,
				"internalType": "string",
				"name": "deviceDID",
				"type": "string"
			},
			{
				"indexed": false,
				"internalType": "uint256",
				"name": "timestamp",
				"type": "uint256"
			}
		],
		"name": "DeviceDeactivated",
		"type": "event"
	},
	{
		"anonymous": false,
		"inputs": [
			{
				"indexed": true,
				"internalType": "address",
				"name": "owner",
				"type": "address"
			},
			{
				"indexed": true,
				"internalType": "string",
				"name": "deviceDID",
				"type": "string"
			},
			{
				"indexed": false,
				"internalType": "string",
				"name": "deviceName",
				"type": "string"
			},
			{
				"indexed": false,
				"internalType": "string",
				"name": "deviceType",
				"type": "string"
			},
			{
				"indexed": false,
				"internalType": "uint256",
				"name": "timestamp",
				"type": "uint256"
			}
		],
		"name": "DeviceRegistered",
		"type": "event"
	},
	{
		"inputs": [
			{
				"internalType": "string",
				"name": "deviceDID",
				"type": "string"
			},
			{
				"internalType": "string",
				"name": "passwordHash",
				"type": "string"
			}
		],
		"name": "authenticateDevice",
		"outputs": [
			{
				"internalType": "bool",
				"name": "",
				"type": "bool"
			}
		],
		"stateMutability": "nonpayable",
		"type": "function"
	},
	{
		"inputs": [
			{
				"internalType": "string",
				"name": "deviceDID",
				"type": "string"
			}
		],
		"name": "deactivateDevice",
		"outputs": [],
		"stateMutability": "nonpayable",
		"type": "function"
	},
	{
		"inputs": [
			{
				"internalType": "string",
				"name": "",
				"type": "string"
			}
		],
		"name": "deviceOwners",
		"outputs": [
			{
				"internalType": "address",
				"name": "",
				"type": "address"
			}
		],
		"stateMutability": "view",
		"type": "function"
	},
	{
		"inputs": [
			{
				"internalType": "address",
				"name": "",
				"type": "address"
			},
			{
				"internalType": "string",
				"name": "",
				"type": "string"
			}
		],
		"name": "devices",
		"outputs": [
			{
				"internalType": "string",
				"name": "did",
				"type": "string"
			},
			{
				"internalType": "string",
				"name": "passwordHash",
				"type": "string"
			},
			{
				"internalType": "string",
				"name": "deviceName",
				"type": "string"
			},
			{
				"internalType": "string",
				"name": "deviceType",
				"type": "string"
			},
			{
				"internalType": "uint256",
				"name": "registrationTime",
				"type": "uint256"
			},
			{
				"internalType": "uint256",
				"name": "lastAuthenticated",
				"type": "uint256"
			},
			{
				"internalType": "bool",
				"name": "isActive",
				"type": "bool"
			},
			{
				"internalType": "bool",
				"name": "registered",
				"type": "bool"
			}
		],
		"stateMutability": "view",
		"type": "function"
	},
	{
		"inputs": [
			{
				"internalType": "string",
				"name": "deviceDID",
				"type": "string"
			}
		],
		"name": "getDeviceInfo",
		"outputs": [
			{
				"internalType": "string",
				"name": "did",
				"type": "string"
			},
			{
				"internalType": "string",
				"name": "deviceName",
				"type": "string"
			},
			{
				"internalType": "string",
				"name": "deviceType",
				"type": "string"
			},
			{
				"internalType": "uint256",
				"name": "registrationTime",
				"type": "uint256"
			},
			{
				"internalType": "uint256",
				"name": "lastAuthenticated",
				"type": "uint256"
			},
			{
				"internalType": "bool",
				"name": "isActive",
				"type": "bool"
			},
			{
				"internalType": "bool",
				"name": "registered",
				"type": "bool"
			}
		],
		"stateMutability": "view",
		"type": "function"
	},
	{
		"inputs": [
			{
				"internalType": "string",
				"name": "deviceDID",
				"type": "string"
			}
		],
		"name": "getDeviceOwner",
		"outputs": [
			{
				"internalType": "address",
				"name": "",
				"type": "address"
			}
		],
		"stateMutability": "view",
		"type": "function"
	},
	{
		"inputs": [],
		"name": "getTotalDevices",
		"outputs": [
			{
				"internalType": "uint256",
				"name": "",
				"type": "uint256"
			}
		],
		"stateMutability": "view",
		"type": "function"
	},
	{
		"inputs": [
			{
				"internalType": "address",
				"name": "user",
				"type": "address"
			}
		],
		"name": "getUserDevices",
		"outputs": [
			{
				"internalType": "string[]",
				"name": "",
				"type": "string[]"
			}
		],
		"stateMutability": "view",
		"type": "function"
	},
	{
		"inputs": [
			{
				"internalType": "address",
				"name": "deviceOwner",
				"type": "address"
			},
			{
				"internalType": "string",
				"name": "deviceDID",
				"type": "string"
			}
		],
		"name": "isDeviceRegistered",
		"outputs": [
			{
				"internalType": "bool",
				"name": "",
				"type": "bool"
			}
		],
		"stateMutability": "view",
		"type": "function"
	},
	{
		"inputs": [],
		"name": "owner",
		"outputs": [
			{
				"internalType": "address",
				"name": "",
				"type": "address"
			}
		],
		"stateMutability": "view",
		"type": "function"
	},
	{
		"inputs": [
			{
				"internalType": "string",
				"name": "deviceDID",
				"type": "string"
			}
		],
		"name": "reactivateDevice",
		"outputs": [],
		"stateMutability": "nonpayable",
		"type": "function"
	},
	{
		"inputs": [
			{
				"internalType": "string",
				"name": "deviceDID",
				"type": "string"
			},
			{
				"internalType": "string",
				"name": "passwordHash",
				"type": "string"
			},
			{
				"internalType": "string",
				"name": "deviceName",
				"type": "string"
			},
			{
				"internalType": "string",
				"name": "deviceType",
				"type": "string"
			}
		],
		"name": "registerDevice",
		"outputs": [],
		"stateMutability": "nonpayable",
		"type": "function"
	},
	{
		"inputs": [],
		"name": "totalDevices",
		"outputs": [
			{
				"internalType": "uint256",
				"name": "",
				"type": "uint256"
			}
		],
		"stateMutability": "view",
		"type": "function"
	}
];

// REPLACE THIS WITH YOUR DEPLOYED CONTRACT ADDRESS
const contractAddress = "0x5133BD76C46671E214FaC048742eF2A90Cd7b12B";

// Check if contract is deployed
function isContractDeployed() {
    return contractAddress !== "YOUR_CONTRACT_ADDRESS_HERE" && contractAddress.length === 42;
}

// API Base URL for XAMPP (adjust if needed)
const API_BASE_URL = "http://localhost/echo-did-interface/api";

let web3;
let contract;

async function init() {
    if (window.ethereum) {
        web3 = new Web3(window.ethereum);
        await window.ethereum.request({ method: "eth_requestAccounts" });
        const accounts = await web3.eth.getAccounts();
        contract = new web3.eth.Contract(contractABI, contractAddress);
        console.log("Connected with account:", accounts[0]);
        
        // Device statistics removed from main interface
    } else {
        alert("MetaMask not detected. Please install MetaMask.");
    }
}

// Hash password for blockchain storage
function hashPassword(password) {
    return web3.utils.keccak256(password);
}

async function registerDevice() {
    const deviceDID = document.getElementById("deviceDID").value;
    const devicePassword = document.getElementById("devicePassword").value;
    const deviceName = document.getElementById("deviceName")?.value || "Unknown Device";
    const deviceType = document.getElementById("deviceType")?.value || "IoT Device";
    
    if (!deviceDID || !devicePassword) {
        document.getElementById("result").innerText = "Please fill in all required fields.";
        return;
    }

    const accounts = await web3.eth.getAccounts();
    const passwordHash = hashPassword(devicePassword);

    try {
        // Check if device already exists in database first
        const checkResponse = await fetch(`${API_BASE_URL}/devices.php?device_did=${encodeURIComponent(deviceDID)}`);
        const checkResult = await checkResponse.json();
        
        if (checkResult.success && checkResult.device) {
            document.getElementById("result").innerText = `Device DID '${deviceDID}' already exists!`;
            document.getElementById("result").style.color = "#f44336";
            return;
        }

        // Check if device exists on blockchain
        if (isContractDeployed() && web3) {
            try {
                const isRegistered = await contract.methods.isDeviceRegistered(accounts[0], deviceDID).call();
                if (isRegistered) {
                    document.getElementById("result").innerText = `Device '${deviceDID}' is already registered on blockchain!`;
                    document.getElementById("result").style.color = "#f44336";
                    return;
                }
            } catch (blockchainCheckError) {
                console.log("Blockchain check failed, proceeding with registration");
            }
        }

        // Register on blockchain first
        let tx = null;
        if (isContractDeployed() && web3) {
            tx = await contract.methods.registerDevice(
                deviceDID, 
                passwordHash, 
                deviceName, 
                deviceType
            ).send({ from: accounts[0] });
        }

        // Register in database
        const dbResponse = await fetch(`${API_BASE_URL}/devices.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                device_did: deviceDID,
                wallet_address: accounts[0],
                device_password: devicePassword,
                device_name: deviceName,
                device_type: deviceType,
                blockchain_tx_hash: tx ? tx.transactionHash : null
            })
        });

        const dbResult = await dbResponse.json();
        
        if (dbResult.success) {
            document.getElementById("result").innerText = "Device registered successfully!";
            document.getElementById("result").style.color = "#4caf50";
            
            // Add success particle effect
            if (window.createSuccessParticles) {
                window.createSuccessParticles();
            }
            
            // Clear form
            document.getElementById("deviceDID").value = "";
            document.getElementById("devicePassword").value = "";
            document.getElementById("deviceName").value = "";
            document.getElementById("deviceType").value = "";
        } else {
            document.getElementById("result").innerText = dbResult.message || "Registration failed";
            document.getElementById("result").style.color = "#f44336";
            throw new Error(dbResult.error);
        }
    } catch (error) {
        console.error(error);
        
        // Better error handling for different types of errors
        if (error.message.includes("Device already registered")) {
            document.getElementById("result").innerText = `Device '${deviceDID}' is already registered!`;
        } else if (error.message.includes("Device DID already exists globally")) {
            document.getElementById("result").innerText = `Device DID '${deviceDID}' already exists in the system!`;
        } else if (error.message.includes("Internal JSON-RPC error")) {
            document.getElementById("result").innerText = `Registration failed: Device '${deviceDID}' may already exist on blockchain!`;
        } else if (error.message.includes("execution reverted")) {
            document.getElementById("result").innerText = `Registration rejected: Device '${deviceDID}' already exists or invalid data!`;
        } else {
            document.getElementById("result").innerText = `Error: ${error.message}`;
        }
        
        document.getElementById("result").style.color = "#f44336";
    }
}

async function authenticate() {
    const deviceDID = document.getElementById("authDeviceDID").value;
    const authPassword = document.getElementById("authPassword").value;
    
    if (!deviceDID || !authPassword) {
        document.getElementById("result").innerText = "Please fill in all required fields.";
        return;
    }

    try {
        // Authenticate with database first
        const dbResponse = await fetch(`${API_BASE_URL}/auth.php?action=authenticate`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                device_did: deviceDID,
                device_password: authPassword,
                wallet_address: web3 ? (await web3.eth.getAccounts())[0] : 'N/A'
            })
        });

        const dbResult = await dbResponse.json();
        
        if (dbResult.success) {
            // Only verify on blockchain if contract is deployed
            if (isContractDeployed() && web3) {
                const accounts = await web3.eth.getAccounts();
                const passwordHash = hashPassword(authPassword);
                const blockchainResult = await contract.methods.authenticateDevice(deviceDID, passwordHash).call({ from: accounts[0] });
                
                if (!blockchainResult) {
                    throw new Error("Blockchain authentication failed");
                }
            }
            
            document.getElementById("result").innerText = "Authentication successful!";
            document.getElementById("result").style.color = "#4CAF50";
            
            // Update device last authenticated in database
            await fetch(`${API_BASE_URL}/devices.php`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    device_did: deviceDID
                })
            });
        } else {
            throw new Error(dbResult.error);
        }
    } catch (error) {
        console.error(error);
        if (error.message.includes("Parameter decoding error")) {
            document.getElementById("result").innerText = "Authentication failed: Smart contract not deployed. Using database authentication only.";
        } else {
            document.getElementById("result").innerText = `Authentication failed: ${error.message}`;
        }
        document.getElementById("result").style.color = "#f44336";
    }
}

// Device stats removed from main interface - only available in admin panel

// Initialize the app when the page loads
window.addEventListener('load', function() {
    showTab('register');
    checkMetaMask();
    addInteractiveElements();
});

// Add interactive elements and animations
function addInteractiveElements() {
    // Add loading states to buttons
    const buttons = document.querySelectorAll('button');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            if (!this.classList.contains('loading')) {
                this.classList.add('loading');
                const originalText = this.textContent;
                this.innerHTML = '<span class="loading"></span> ' + originalText;
                
                // Remove loading state after 2 seconds (or when operation completes)
                setTimeout(() => {
                    this.classList.remove('loading');
                    this.textContent = originalText;
                }, 2000);
            }
        });
    });

    // Add focus animations to inputs
    const inputs = document.querySelectorAll('input[type="text"], input[type="password"], select');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('input-focused');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('input-focused');
        });
    });

    // Add typing animation to result messages
    const resultDiv = document.getElementById('result');
    if (resultDiv) {
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'childList' || mutation.type === 'characterData') {
                    resultDiv.style.opacity = '0';
                    resultDiv.style.transform = 'translateY(10px)';
                    setTimeout(() => {
                        resultDiv.style.opacity = '1';
                        resultDiv.style.transform = 'translateY(0)';
                    }, 100);
                }
            });
        });
        observer.observe(resultDiv, { childList: true, subtree: true, characterData: true });
    }

    // Add particle effect on successful operations
    window.createSuccessParticles = function() {
        const container = document.querySelector('.container');
        for (let i = 0; i < 20; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            particle.style.cssText = `
                position: absolute;
                width: 4px;
                height: 4px;
                background: #667eea;
                border-radius: 50%;
                pointer-events: none;
                animation: particleFloat 2s ease-out forwards;
                left: ${Math.random() * 100}%;
                top: ${Math.random() * 100}%;
                z-index: 1000;
            `;
            container.appendChild(particle);
            
            setTimeout(() => {
                if (particle.parentNode) {
                    particle.parentNode.removeChild(particle);
                }
            }, 2000);
        }
    };

    // Add CSS for particle animation
    if (!document.getElementById('particle-styles')) {
        const style = document.createElement('style');
        style.id = 'particle-styles';
        style.textContent = `
            @keyframes particleFloat {
                0% {
                    opacity: 1;
                    transform: translateY(0) scale(1);
                }
                100% {
                    opacity: 0;
                    transform: translateY(-100px) scale(0);
                }
            }
            
            .input-focused {
                transform: scale(1.02);
            }
        `;
        document.head.appendChild(style);
    }
}

// Show Password toggle for Register Section
document.getElementById("registerShowPassword").addEventListener("change", function() {
    const passwordField = document.getElementById("devicePassword");
    if (this.checked) {
        passwordField.type = "text";
    } else {
        passwordField.type = "password";
    }
});

// Show Password toggle for Authenticate Section
document.getElementById("showPassword").addEventListener("change", function() {
    const passwordField = document.getElementById("authPassword");
    if (this.checked) {
        passwordField.type = "text";
    } else {
        passwordField.type = "password";
    }
});

document.getElementById("registerDevice").addEventListener("click", registerDevice);
document.getElementById("authenticate").addEventListener("click", authenticate);

document.getElementById("registerTab").addEventListener("click", () => {
    document.getElementById("registerTabContent").classList.add("active");
    document.getElementById("authenticateTabContent").classList.remove("active");
    document.getElementById("registerTab").classList.add("active");
    document.getElementById("authenticateTab").classList.remove("active");
});

document.getElementById("authenticateTab").addEventListener("click", () => {
    document.getElementById("authenticateTabContent").classList.add("active");
    document.getElementById("registerTabContent").classList.remove("active");
    document.getElementById("authenticateTab").classList.add("active");
    document.getElementById("registerTab").classList.remove("active");
});

window.onload = init;
