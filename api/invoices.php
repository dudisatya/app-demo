<?php
require_once 'config.php';

// Handle different HTTP methods
$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            getInvoice($_GET['id']);
        } else {
            getInvoices();
        }
        break;
        
    case 'POST':
        createInvoice();
        break;
        
    case 'PUT':
        updateInvoice();
        break;
        
    case 'DELETE':
        deleteInvoice();
        break;
        
    default:
        sendJSON(['error' => 'Method not allowed'], 405);
}

function getInvoices() {
    global $conn;
    
    $sql = "SELECT * FROM invoices ORDER BY date DESC";
    $result = $conn->query($sql);
    
    $invoices = [];
    while($row = $result->fetch_assoc()) {
        $invoices[] = $row;
    }
    
    sendJSON($invoices);
}

function getInvoice($id) {
    global $conn;
    
    $sql = "SELECT * FROM invoices WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $invoice = $result->fetch_assoc();
    
    if ($invoice) {
        sendJSON($invoice);
    } else {
        sendJSON(['error' => 'Invoice not found'], 404);
    }
}

function createInvoice() {
    global $conn;
    
    $data = getPostData();
    
    $sql = "INSERT INTO invoices (client_id, job_id, amount, status, date, due_date) 
            VALUES (?, ?, ?, ?, ?, ?)";
            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iidsss", 
        $data['client_id'],
        $data['job_id'],
        $data['amount'],
        $data['status'],
        $data['date'],
        $data['due_date']
    );
    
    if ($stmt->execute()) {
        sendJSON(['id' => $conn->insert_id, 'message' => 'Invoice created successfully']);
    } else {
        sendJSON(['error' => 'Failed to create invoice'], 500);
    }
}

function updateInvoice() {
    global $conn;
    
    $data = getPostData();
    $id = $data['id'];
    
    $sql = "UPDATE invoices SET 
            client_id = ?,
            job_id = ?,
            amount = ?,
            status = ?,
            date = ?,
            due_date = ?
            WHERE id = ?";
            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iidsssi", 
        $data['client_id'],
        $data['job_id'],
        $data['amount'],
        $data['status'],
        $data['date'],
        $data['due_date'],
        $id
    );
    
    if ($stmt->execute()) {
        sendJSON(['message' => 'Invoice updated successfully']);
    } else {
        sendJSON(['error' => 'Failed to update invoice'], 500);
    }
}

function deleteInvoice() {
    global $conn;
    
    $data = getPostData();
    $id = $data['id'];
    
    $sql = "DELETE FROM invoices WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        sendJSON(['message' => 'Invoice deleted successfully']);
    } else {
        sendJSON(['error' => 'Failed to delete invoice'], 500);
    }
}