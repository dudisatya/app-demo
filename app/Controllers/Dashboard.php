<?php

namespace App\Controllers;

use App\Models\ClientModel;
use App\Models\JobModel;
use App\Models\InvoiceModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $clientModel = new ClientModel();
        $jobModel = new JobModel();
        $invoiceModel = new InvoiceModel();

        $data = [
            'title' => 'Dashboard',
            'stats' => [
                'total_clients' => $clientModel->countAll(),
                'active_clients' => $clientModel->where('status', 'active')->countAllResults(),
                'todays_jobs' => count($jobModel->getTodaysJobs()),
                'pending_invoices' => count($invoiceModel->getPendingInvoices()),
                'monthly_revenue' => $invoiceModel->getMonthlyRevenue()
            ],
            'upcoming_jobs' => $jobModel->getUpcomingJobs(5),
            'recent_invoices' => $invoiceModel->getInvoicesWithClients()
        ];

        return view('dashboard/index', $data);
    }
}