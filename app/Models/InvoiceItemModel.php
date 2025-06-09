<?php

namespace App\Models;

use CodeIgniter\Model;

class InvoiceItemModel extends Model
{
    protected $table = 'invoice_items';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'invoice_id', 'description', 'quantity', 'rate', 'amount'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [
        'quantity' => 'decimal',
        'rate' => 'decimal',
        'amount' => 'decimal'
    ];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;

    // Validation
    protected $validationRules = [
        'invoice_id' => 'required|integer',
        'description' => 'required|min_length[3]',
        'quantity' => 'required|decimal',
        'rate' => 'required|decimal',
        'amount' => 'required|decimal'
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    public function getItemsByInvoice($invoice_id)
    {
        return $this->where('invoice_id', $invoice_id)->findAll();
    }
}