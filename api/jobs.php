<?php
require_once 'config.php';

// Handle different HTTP methods
$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            getJob($_GET['id']);
        } else {
            getJobs();
        }
        break;
        
    case 'POST':
        createJob();
        break;
        
    case 'PUT':
        updateJob();
        break;
        
    case 'DELETE':
        deleteJob();
        break;
        
    default:
        sendJSON(['error' => 'Method not allowed'], 405);
}

function getJobs() {
    global $conn;
    
    $sql = "SELECT * FROM jobs ORDER BY date DESC";
    $result = $conn->query($sql);
    
    $jobs = [];
    while($row = $result->fetch_assoc()) {
        $jobs[] = $row;
    }
    
    sendJSON($jobs);
}

function getJob($id) {
    global $conn;
    
    $sql = "SELECT * FROM jobs WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $job = $result->fetch_assoc();
    
    if ($job) {
        sendJSON($job);
    } else {
        sendJSON(['error' => 'Job not found'], 404);
    }
}

function createJob() {
    global $conn;
    
    $data = getPostData();
    
    $sql = "INSERT INTO jobs (client_id, type, address, date, time, duration, description, price, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssdsds", 
        $data['client_id'],
        $data['type'],
        $data['address'],
        $data['date'],
        $data['time'],
        $data['duration'],
        $data['description'],
        $data['price'],
        $data['status']
    );
    
    if ($stmt->execute()) {
        sendJSON(['id' => $conn->insert_id, 'message' => 'Job created successfully']);
    } else {
        sendJSON(['error' => 'Failed to create job'], 500);
    }
}

function updateJob() {
    global $conn;
    
    $data = getPostData();
    $id = $data['id'];
    
    $sql = "UPDATE jobs SET 
            client_id = ?,
            type = ?,
            address = ?,
            date = ?,
            time = ?,
            duration = ?,
            description = ?,
            price = ?,
            status = ?
            WHERE id = ?";
            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssdsdsi", 
        $data['client_id'],
        $data['type'],
        $data['address'],
        $data['date'],
        $data['time'],
        $data['duration'],
        $data['description'],
        $data['price'],
        $data['status'],
        $id
    );
    
    if ($stmt->execute()) {
        sendJSON(['message' => 'Job updated successfully']);
    } else {
        sendJSON(['error' => 'Failed to update job'], 500);
    }
}

function deleteJob() {
    global $conn;
    
    $data = getPostData();
    $id = $data['id'];
    
    $sql = "DELETE FROM jobs WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        sendJSON(['message' => 'Job deleted successfully']);
    } else {
        sendJSON(['error' => 'Failed to delete job'], 500);
    }
}