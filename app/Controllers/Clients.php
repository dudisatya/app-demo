<?php

namespace App\Controllers;

use App\Models\ClientModel;

class Clients extends BaseController
{
    protected $clientModel;

    public function __construct()
    {
        $this->clientModel = new ClientModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Clients',
            'clients' => $this->clientModel->findAll()
        ];

        return view('clients/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Add New Client'
        ];

        return view('clients/create', $data);
    }

    public function store()
    {
        $rules = [
            'name' => 'required|min_length[2]|max_length[100]',
            'email' => 'required|valid_email|is_unique[clients.email]',
            'phone' => 'required|min_length[10]|max_length[20]',
            'address' => 'required|min_length[5]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'city' => $this->request->getPost('city'),
            'state' => $this->request->getPost('state'),
            'zip_code' => $this->request->getPost('zip_code'),
            'notes' => $this->request->getPost('notes'),
            'status' => 'active'
        ];

        if ($this->clientModel->save($data)) {
            return redirect()->to('/clients')->with('success', 'Client added successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to add client.');
        }
    }

    public function view($id)
    {
        $client = $this->clientModel->getClientWithJobs($id);
        
        if (!$client) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Client not found');
        }

        $data = [
            'title' => 'Client Details',
            'client' => $client
        ];

        return view('clients/view', $data);
    }

    public function edit($id)
    {
        $client = $this->clientModel->find($id);
        
        if (!$client) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Client not found');
        }

        $data = [
            'title' => 'Edit Client',
            'client' => $client
        ];

        return view('clients/edit', $data);
    }

    public function update($id)
    {
        $client = $this->clientModel->find($id);
        
        if (!$client) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Client not found');
        }

        $rules = [
            'name' => 'required|min_length[2]|max_length[100]',
            'email' => "required|valid_email|is_unique[clients.email,id,{$id}]",
            'phone' => 'required|min_length[10]|max_length[20]',
            'address' => 'required|min_length[5]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'city' => $this->request->getPost('city'),
            'state' => $this->request->getPost('state'),
            'zip_code' => $this->request->getPost('zip_code'),
            'notes' => $this->request->getPost('notes'),
            'status' => $this->request->getPost('status')
        ];

        if ($this->clientModel->update($id, $data)) {
            return redirect()->to('/clients')->with('success', 'Client updated successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update client.');
        }
    }

    public function delete($id)
    {
        if ($this->clientModel->delete($id)) {
            return redirect()->to('/clients')->with('success', 'Client deleted successfully!');
        } else {
            return redirect()->to('/clients')->with('error', 'Failed to delete client.');
        }
    }
}