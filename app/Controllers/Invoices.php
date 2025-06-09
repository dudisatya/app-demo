<?php

namespace App\Controllers;

use App\Models\InvoiceModel;
use App\Models\InvoiceItemModel;
use App\Models\ClientModel;
use App\Models\JobModel;

class Invoices extends BaseController
{
    protected $invoiceModel;
    protected $invoiceItemModel;
    protected $clientModel;
    protected $jobModel;

    public function __construct()
    {
        $this->invoiceModel = new InvoiceModel();
        $this->invoiceItemModel = new InvoiceItemModel();
        $this->clientModel = new ClientModel();
        $this->jobModel = new JobModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Invoices',
            'invoices' => $this->invoiceModel->getInvoicesWithClients()
        ];

        return view('invoices/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Create Invoice',
            'clients' => $this->clientModel->getActiveClients(),
            'jobs' => $this->jobModel->getJobsByStatus('completed')
        ];

        return view('invoices/create', $data);
    }

    public function store()
    {
        $rules = [
            'client_id' => 'required|integer',
            'issue_date' => 'required|valid_date',
            'due_date' => 'required|valid_date'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Calculate totals
        $items = $this->request->getPost('items');
        $subtotal = 0;
        
        foreach ($items as $item) {
            $subtotal += $item['quantity'] * $item['rate'];
        }
        
        $tax_rate = $this->request->getPost('tax_rate') ?: 0;
        $tax_amount = $subtotal * ($tax_rate / 100);
        $total_amount = $subtotal + $tax_amount;

        $invoiceData = [
            'client_id' => $this->request->getPost('client_id'),
            'job_id' => $this->request->getPost('job_id'),
            'issue_date' => $this->request->getPost('issue_date'),
            'due_date' => $this->request->getPost('due_date'),
            'subtotal' => $subtotal,
            'tax_rate' => $tax_rate,
            'tax_amount' => $tax_amount,
            'total_amount' => $total_amount,
            'notes' => $this->request->getPost('notes'),
            'status' => 'draft'
        ];

        if ($invoice_id = $this->invoiceModel->insert($invoiceData)) {
            // Save invoice items
            foreach ($items as $item) {
                $itemData = [
                    'invoice_id' => $invoice_id,
                    'description' => $item['description'],
                    'quantity' => $item['quantity'],
                    'rate' => $item['rate'],
                    'amount' => $item['quantity'] * $item['rate']
                ];
                $this->invoiceItemModel->save($itemData);
            }

            return redirect()->to('/invoices')->with('success', 'Invoice created successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to create invoice.');
        }
    }

    public function view($id)
    {
        $invoice = $this->invoiceModel->select('invoices.*, clients.name as client_name, clients.email as client_email, clients.address as client_address')
                                    ->join('clients', 'clients.id = invoices.client_id')
                                    ->find($id);
        
        if (!$invoice) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Invoice not found');
        }

        $invoice['items'] = $this->invoiceItemModel->getItemsByInvoice($id);

        $data = [
            'title' => 'Invoice Details',
            'invoice' => $invoice
        ];

        return view('invoices/view', $data);
    }

    public function generatePDF($id)
    {
        // PDF generation logic would go here
        // For now, redirect to view
        return redirect()->to("/invoices/view/{$id}");
    }

    public function sendInvoice($id)
    {
        $invoice = $this->invoiceModel->find($id);
        
        if (!$invoice) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invoice not found']);
        }

        // Email sending logic would go here
        // For now, just update status
        $this->invoiceModel->update($id, [
            'status' => 'sent',
            'sent_at' => date('Y-m-d H:i:s')
        ]);

        return $this->response->setJSON(['success' => true, 'message' => 'Invoice sent successfully!']);
    }

    public function delete($id)
    {
        if ($this->invoiceModel->delete($id)) {
            return redirect()->to('/invoices')->with('success', 'Invoice deleted successfully!');
        } else {
            return redirect()->to('/invoices')->with('error', 'Failed to delete invoice.');
        }
    }
}