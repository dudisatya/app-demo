<?php

namespace App\Controllers;

use App\Models\JobModel;

class Schedule extends BaseController
{
    protected $jobModel;

    public function __construct()
    {
        $this->jobModel = new JobModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Schedule',
            'todays_jobs' => $this->jobModel->getTodaysJobs(),
            'upcoming_jobs' => $this->jobModel->getUpcomingJobs(10)
        ];

        return view('schedule/index', $data);
    }

    public function calendar()
    {
        $data = [
            'title' => 'Calendar View'
        ];

        return view('schedule/calendar', $data);
    }

    public function getEvents()
    {
        $start = $this->request->getGet('start');
        $end = $this->request->getGet('end');
        
        $jobs = $this->jobModel->getJobsForCalendar($start, $end);
        
        $events = [];
        foreach ($jobs as $job) {
            $events[] = [
                'id' => $job['id'],
                'title' => $job['title'] . ' - ' . $job['client_name'],
                'start' => $job['scheduled_date'] . 'T' . $job['scheduled_time'],
                'end' => date('Y-m-d\TH:i:s', strtotime($job['scheduled_date'] . ' ' . $job['scheduled_time'] . ' +' . ($job['estimated_duration'] ?? 1) . ' hours')),
                'backgroundColor' => $this->getStatusColor($job['status']),
                'borderColor' => $this->getStatusColor($job['status']),
                'extendedProps' => [
                    'client_name' => $job['client_name'],
                    'service_type' => $job['service_type'],
                    'status' => $job['status']
                ]
            ];
        }
        
        return $this->response->setJSON($events);
    }

    private function getStatusColor($status)
    {
        switch ($status) {
            case 'scheduled': return '#4B7B5C';
            case 'in_progress': return '#FFA500';
            case 'completed': return '#28a745';
            case 'cancelled': return '#dc3545';
            default: return '#6c757d';
        }
    }
}