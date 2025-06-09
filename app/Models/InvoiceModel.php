<?php

namespace App\Models;

use CodeIgniter\Model;

class InvoiceModel extends Model
{
    protected $table = 'invoices';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'invoice_number', 'client_id', 'job_id', 'issue_date', 'due_date',
        'subtotal', 'tax_rate', 'tax_amount', 'total_amount', 'status',
        'notes', 'sent_at', 'paid_at', 'created_at', 'updated_at'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [
        'subtotal' => 'decimal',
        'tax_rate' => 'decimal',
        'tax_amount' => 'decimal',
        'total_amount' => 'decimal'
    ];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'client_id' => 'required|integer',
        'issue_date' => 'required|valid_date',
        'due_date' => 'required|valid_date',
        'subtotal' => 'required|decimal',
        'total_amount' => 'required|decimal',
        'status' => 'in_list[draft,sent,paid,overdue,cancelled]'
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = ['generateInvoiceNumber'];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    protected function generateInvoiceNumber(array $data)
    {
        if (!isset($data['data']['invoice_number'])) {
            $year = date('Y');
            $lastInvoice = $this->selectMax('id')->first();
            $nextNumber = ($lastInvoice['id'] ?? 0) + 1;
            $data['data']['invoice_number'] = 'INV-' . $year . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        }
        return $data;
    }

    public function getInvoicesWithClients()
    {
        return $this->select('invoices.*, clients.name as client_name, clients.email as client_email')
                   ->join('clients', 'clients.id = invoices.client_id')
                   ->orderBy('issue_date', 'DESC')
                   ->findAll();
    }

    public function getPendingInvoices()
    {
        return $this->select('invoices.*, clients.name as client_name')
                   ->join('clients', 'clients.id = invoices.client_id')
                   ->whereIn('status', ['sent', 'overdue'])
                   ->findAll();
    }

    public function getOverdueInvoices()
    {
        return $this->select('invoices.*, clients.name as client_name')
                   ->join('clients', 'clients.id = invoices.client_id')
                   ->where('due_date <', date('Y-m-d'))
                   ->where('status !=', 'paid')
                   ->findAll();
    }

    public function getMonthlyRevenue($month = null, $year = null)
    {
        $month = $month ?? date('m');
        $year = $year ?? date('Y');
        
        $result = $this->selectSum('total_amount')
                      ->where('status', 'paid')
                      ->where('MONTH(paid_at)', $month)
                      ->where('YEAR(paid_at)', $year)
                      ->first();
        
        return $result['total_amount'] ?? 0;
    }
}