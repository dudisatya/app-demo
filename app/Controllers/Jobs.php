<?php

namespace App\Controllers;

use App\Models\JobModel;
use App\Models\ClientModel;

class Jobs extends BaseController
{
    protected $jobModel;
    protected $clientModel;

    public function __construct()
    {
        $this->jobModel = new JobModel();
        $this->clientModel = new ClientModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Jobs',
            'jobs' => $this->jobModel->getJobsWithClients()
        ];

        return view('jobs/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Schedule New Job',
            'clients' => $this->clientModel->getActiveClients()
        ];

        return view('jobs/create', $data);
    }

    public function store()
    {
        $rules = [
            'client_id' => 'required|integer',
            'title' => 'required|min_length[3]|max_length[200]',
            'service_type' => 'required',
            'scheduled_date' => 'required|valid_date',
            'scheduled_time' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'client_id' => $this->request->getPost('client_id'),
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'service_type' => $this->request->getPost('service_type'),
            'address' => $this->request->getPost('address'),
            'scheduled_date' => $this->request->getPost('scheduled_date'),
            'scheduled_time' => $this->request->getPost('scheduled_time'),
            'estimated_duration' => $this->request->getPost('estimated_duration'),
            'priority' => $this->request->getPost('priority') ?: 'medium',
            'notes' => $this->request->getPost('notes'),
            'price' => $this->request->getPost('price'),
            'status' => 'scheduled'
        ];

        if ($this->jobModel->save($data)) {
            return redirect()->to('/jobs')->with('success', 'Job scheduled successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to schedule job.');
        }
    }

    public function view($id)
    {
        $job = $this->jobModel->select('jobs.*, clients.name as client_name, clients.email as client_email, clients.phone as client_phone')
                             ->join('clients', 'clients.id = jobs.client_id')
                             ->find($id);
        
        if (!$job) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Job not found');
        }

        $data = [
            'title' => 'Job Details',
            'job' => $job
        ];

        return view('jobs/view', $data);
    }

    public function edit($id)
    {
        $job = $this->jobModel->find($id);
        
        if (!$job) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Job not found');
        }

        $data = [
            'title' => 'Edit Job',
            'job' => $job,
            'clients' => $this->clientModel->getActiveClients()
        ];

        return view('jobs/edit', $data);
    }

    public function update($id)
    {
        $job = $this->jobModel->find($id);
        
        if (!$job) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Job not found');
        }

        $rules = [
            'client_id' => 'required|integer',
            'title' => 'required|min_length[3]|max_length[200]',
            'service_type' => 'required',
            'scheduled_date' => 'required|valid_date',
            'scheduled_time' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'client_id' => $this->request->getPost('client_id'),
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'service_type' => $this->request->getPost('service_type'),
            'address' => $this->request->getPost('address'),
            'scheduled_date' => $this->request->getPost('scheduled_date'),
            'scheduled_time' => $this->request->getPost('scheduled_time'),
            'estimated_duration' => $this->request->getPost('estimated_duration'),
            'actual_duration' => $this->request->getPost('actual_duration'),
            'priority' => $this->request->getPost('priority'),
            'notes' => $this->request->getPost('notes'),
            'price' => $this->request->getPost('price'),
            'status' => $this->request->getPost('status')
        ];

        if ($this->jobModel->update($id, $data)) {
            return redirect()->to('/jobs')->with('success', 'Job updated successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update job.');
        }
    }

    public function updateStatus($id)
    {
        $status = $this->request->getPost('status');
        $data = ['status' => $status];
        
        if ($status === 'completed') {
            $data['actual_duration'] = $this->request->getPost('actual_duration');
        }

        if ($this->jobModel->update($id, $data)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Job status updated successfully!']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to update job status.']);
        }
    }

    public function delete($id)
    {
        if ($this->jobModel->delete($id)) {
            return redirect()->to('/jobs')->with('success', 'Job deleted successfully!');
        } else {
            return redirect()->to('/jobs')->with('error', 'Failed to delete job.');
        }
    }
}