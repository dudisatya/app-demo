<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1>Dashboard</h1>
        <p class="text-muted mb-0">Welcome back! Here's what's happening with your business today.</p>
    </div>
    <div>
        <a href="<?= base_url('/jobs/create') ?>" class="btn btn-primary me-2">
            <i class="fas fa-plus me-2"></i>Schedule Job
        </a>
        <a href="<?= base_url('/invoices/create') ?>" class="btn btn-outline-primary">
            <i class="fas fa-file-invoice me-2"></i>Create Invoice
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <h3>Total Clients</h3>
            <div class="value"><?= $stats['total_clients'] ?></div>
            <div class="change">
                <i class="fas fa-arrow-up me-1"></i>
                <?= $stats['active_clients'] ?> active
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <h3>Today's Jobs</h3>
            <div class="value"><?= $stats['todays_jobs'] ?></div>
            <div class="change">
                <i class="fas fa-calendar me-1"></i>
                Scheduled for today
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <h3>Pending Invoices</h3>
            <div class="value"><?= $stats['pending_invoices'] ?></div>
            <div class="change">
                <i class="fas fa-clock me-1"></i>
                Awaiting payment
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <h3>Monthly Revenue</h3>
            <div class="value">$<?= number_format($stats['monthly_revenue'], 0) ?></div>
            <div class="change">
                <i class="fas fa-dollar-sign me-1"></i>
                This month
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Upcoming Jobs -->
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-calendar-check me-2 text-primary"></i>
                    Upcoming Jobs
                </h5>
                <a href="<?= base_url('/schedule') ?>" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                <?php if (empty($upcoming_jobs)): ?>
                    <div class="text-center py-4">
                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No upcoming jobs scheduled</p>
                        <a href="<?= base_url('/jobs/create') ?>" class="btn btn-primary">Schedule Your First Job</a>
                    </div>
                <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($upcoming_jobs as $job): ?>
                            <div class="list-group-item border-0 px-0">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1"><?= esc($job['title']) ?></h6>
                                        <p class="mb-1 text-muted">
                                            <i class="fas fa-user me-1"></i><?= esc($job['client_name']) ?>
                                            <span class="mx-2">•</span>
                                            <i class="fas fa-map-marker-alt me-1"></i><?= esc($job['address']) ?>
                                        </p>
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            <?= date('M j, Y', strtotime($job['scheduled_date'])) ?> at 
                                            <?= date('g:i A', strtotime($job['scheduled_time'])) ?>
                                        </small>
                                    </div>
                                    <div class="text-end">
                                        <span class="status-badge status-<?= $job['status'] ?>"><?= ucfirst($job['status']) ?></span>
                                        <div class="mt-2">
                                            <a href="<?= base_url('/jobs/view/' . $job['id']) ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Recent Invoices -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-file-invoice-dollar me-2 text-primary"></i>
                    Recent Invoices
                </h5>
                <a href="<?= base_url('/invoices') ?>" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                <?php if (empty($recent_invoices)): ?>
                    <div class="text-center py-4">
                        <i class="fas fa-file-invoice fa-2x text-muted mb-3"></i>
                        <p class="text-muted">No invoices yet</p>
                        <a href="<?= base_url('/invoices/create') ?>" class="btn btn-primary btn-sm">Create Invoice</a>
                    </div>
                <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach (array_slice($recent_invoices, 0, 5) as $invoice): ?>
                            <div class="list-group-item border-0 px-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1"><?= esc($invoice['invoice_number']) ?></h6>
                                        <small class="text-muted"><?= esc($invoice['client_name']) ?></small>
                                    </div>
                                    <div class="text-end">
                                        <div class="fw-bold">$<?= number_format($invoice['total_amount'], 2) ?></div>
                                        <span class="status-badge status-<?= $invoice['status'] ?>"><?= ucfirst($invoice['status']) ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>