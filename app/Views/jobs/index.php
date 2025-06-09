<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1>Jobs</h1>
        <p class="text-muted mb-0">Manage your scheduled jobs and track their progress</p>
    </div>
    <a href="<?= base_url('/jobs/create') ?>" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Schedule New Job
    </a>
</div>

<div class="card">
    <div class="card-body">
        <?php if (empty($jobs)): ?>
            <div class="text-center py-5">
                <i class="fas fa-briefcase fa-4x text-muted mb-4"></i>
                <h4 class="text-muted">No jobs scheduled</h4>
                <p class="text-muted">Start managing your work by scheduling your first job</p>
                <a href="<?= base_url('/jobs/create') ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Schedule Your First Job
                </a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Job</th>
                            <th>Client</th>
                            <th>Service Type</th>
                            <th>Scheduled</th>
                            <th>Duration</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jobs as $job): ?>
                            <tr>
                                <td>
                                    <div>
                                        <strong><?= esc($job['title']) ?></strong>
                                        <?php if ($job['description']): ?>
                                            <br><small class="text-muted"><?= esc(substr($job['description'], 0, 50)) ?>...</small>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <strong><?= esc($job['client_name']) ?></strong>
                                        <?php if ($job['client_phone']): ?>
                                            <br><small class="text-muted"><?= esc($job['client_phone']) ?></small>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary"><?= ucfirst($job['service_type']) ?></span>
                                </td>
                                <td>
                                    <div>
                                        <strong><?= date('M j, Y', strtotime($job['scheduled_date'])) ?></strong>
                                        <br><small class="text-muted"><?= date('g:i A', strtotime($job['scheduled_time'])) ?></small>
                                    </div>
                                </td>
                                <td><?= $job['estimated_duration'] ? $job['estimated_duration'] . ' hrs' : '-' ?></td>
                                <td>
                                    <?php if ($job['price']): ?>
                                        <strong>$<?= number_format($job['price'], 2) ?></strong>
                                    <?php else: ?>
                                        <span class="text-muted">TBD</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="status-badge status-<?= str_replace('_', '-', $job['status']) ?>">
                                        <?= ucfirst(str_replace('_', ' ', $job['status'])) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?= base_url('/jobs/view/' . $job['id']) ?>" class="btn btn-sm btn-outline-primary" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= base_url('/jobs/edit/' . $job['id']) ?>" class="btn btn-sm btn-outline-secondary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <?php if ($job['status'] == 'scheduled'): ?>
                                            <button type="button" class="btn btn-sm btn-outline-success" title="Start Job" onclick="updateJobStatus(<?= $job['id'] ?>, 'in_progress')">
                                                <i class="fas fa-play"></i>
                                            </button>
                                        <?php elseif ($job['status'] == 'in_progress'): ?>
                                            <button type="button" class="btn btn-sm btn-outline-success" title="Complete Job" onclick="updateJobStatus(<?= $job['id'] ?>, 'completed')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function updateJobStatus(jobId, status) {
    const statusText = status.replace('_', ' ');
    if (confirm(`Are you sure you want to mark this job as ${statusText}?`)) {
        fetch(`<?= base_url('/jobs/update-status/') ?>${jobId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Failed to update job status: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating the job status.');
        });
    }
}
</script>
<?= $this->endSection() ?>