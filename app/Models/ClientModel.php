<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table = 'clients';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'name', 'email', 'phone', 'address', 'city', 'state', 'zip_code',
        'notes', 'status', 'created_at', 'updated_at'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'name' => 'required|min_length[2]|max_length[100]',
        'email' => 'required|valid_email|is_unique[clients.email,id,{id}]',
        'phone' => 'required|min_length[10]|max_length[20]',
        'address' => 'required|min_length[5]',
        'status' => 'in_list[active,inactive]'
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    public function getActiveClients()
    {
        return $this->where('status', 'active')->findAll();
    }

    public function getClientWithJobs($id)
    {
        $client = $this->find($id);
        if ($client) {
            $jobModel = new JobModel();
            $client['jobs'] = $jobModel->where('client_id', $id)->findAll();
        }
        return $client;
    }

    public function searchClients($search)
    {
        return $this->like('name', $search)
                   ->orLike('email', $search)
                   ->orLike('phone', $search)
                   ->findAll();
    }
}