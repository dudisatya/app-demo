<?php
require_once 'config.php';

// Handle different HTTP methods
$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            getClient($_GET['id']);
        } else {
            getClients();
        }
        break;
        
    case 'POST':
        createClient();
        break;
        
    case 'PUT':
        updateClient();
        break;
        
    case 'DELETE':
        deleteClient();
        break;
        
    default:
        sendJSON(['error' => 'Method not allowed'], 405);
}

function getClients() {
    global $conn;
    
    $sql = "SELECT * FROM clients ORDER BY name ASC";
    $result = $conn->query($sql);
    
    $clients = [];
    while($row = $result->fetch_assoc()) {
        $clients[] = $row;
    }
    
    sendJSON($clients);
}

function getClient($id) {
    global $conn;
    
    $sql = "SELECT * FROM clients WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $client = $result->fetch_assoc();
    
    if ($client) {
        sendJSON($client);
    } else {
        sendJSON(['error' => 'Client not found'], 404);
    }
}

function createClient() {
    global $conn;
    
    $data = getPostData();
    
    $sql = "INSERT INTO clients (name, email, phone, address, status) 
            VALUES (?, ?, ?, ?, ?)";
            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", 
        $data['name'],
        $data['email'],
        $data['phone'],
        $data['address'],
        $data['status']
    );
    
    if ($stmt->execute()) {
        sendJSON(['id' => $conn->insert_id, 'message' => 'Client created successfully']);
    } else {
        sendJSON(['error' => 'Failed to create client'], 500);
    }
}

function updateClient() {
    global $conn;
    
    $data = getPostData();
    $id = $data['id'];
    
    $sql = "UPDATE clients SET 
            name = ?,
            email = ?,
            phone = ?,
            address = ?,
            status = ?
            WHERE id = ?";
            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", 
        $data['name'],
        $data['email'],
        $data['phone'],
        $data['address'],
        $data['status'],
        $id
    );
    
    if ($stmt->execute()) {
        sendJSON(['message' => 'Client updated successfully']);
    } else {
        sendJSON(['error' => 'Failed to update client'], 500);
    }
}

function deleteClient() {
    global $conn;
    
    $data = getPostData();
    $id = $data['id'];
    
    $sql = "DELETE FROM clients WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        sendJSON(['message' => 'Client deleted successfully']);
    } else {
        sendJSON(['error' => 'Failed to delete client'], 500);
    }
}