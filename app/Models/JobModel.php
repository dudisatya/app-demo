<?php

namespace App\Models;

use CodeIgniter\Model;

class JobModel extends Model
{
    protected $table = 'jobs';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'client_id', 'title', 'description', 'service_type', 'address',
        'scheduled_date', 'scheduled_time', 'estimated_duration', 'actual_duration',
        'status', 'priority', 'notes', 'before_photos', 'after_photos',
        'price', 'created_at', 'updated_at'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [
        'before_photos' => 'json',
        'after_photos' => 'json',
        'price' => 'decimal'
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
        'title' => 'required|min_length[3]|max_length[200]',
        'service_type' => 'required|in_list[plumbing,electrical,cleaning,landscaping,hvac,general]',
        'scheduled_date' => 'required|valid_date',
        'scheduled_time' => 'required',
        'status' => 'in_list[scheduled,in_progress,completed,cancelled]',
        'priority' => 'in_list[low,medium,high,urgent]'
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

    public function getJobsWithClients()
    {
        return $this->select('jobs.*, clients.name as client_name, clients.phone as client_phone')
                   ->join('clients', 'clients.id = jobs.client_id')
                   ->orderBy('scheduled_date', 'ASC')
                   ->findAll();
    }

    public function getTodaysJobs()
    {
        return $this->select('jobs.*, clients.name as client_name, clients.phone as client_phone')
                   ->join('clients', 'clients.id = jobs.client_id')
                   ->where('DATE(scheduled_date)', date('Y-m-d'))
                   ->orderBy('scheduled_time', 'ASC')
                   ->findAll();
    }

    public function getUpcomingJobs($limit = 5)
    {
        return $this->select('jobs.*, clients.name as client_name, clients.phone as client_phone')
                   ->join('clients', 'clients.id = jobs.client_id')
                   ->where('scheduled_date >=', date('Y-m-d'))
                   ->where('status !=', 'completed')
                   ->orderBy('scheduled_date', 'ASC')
                   ->orderBy('scheduled_time', 'ASC')
                   ->limit($limit)
                   ->findAll();
    }

    public function getJobsByStatus($status)
    {
        return $this->select('jobs.*, clients.name as client_name')
                   ->join('clients', 'clients.id = jobs.client_id')
                   ->where('jobs.status', $status)
                   ->findAll();
    }

    public function getJobsForCalendar($start_date, $end_date)
    {
        return $this->select('jobs.*, clients.name as client_name')
                   ->join('clients', 'clients.id = jobs.client_id')
                   ->where('scheduled_date >=', $start_date)
                   ->where('scheduled_date <=', $end_date)
                   ->findAll();
    }
}