<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <div class="d-flex align-items-center">
        <a href="<?= base_url('/jobs') ?>" class="btn btn-outline-secondary me-3">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1>Schedule New Job</h1>
            <p class="text-muted mb-0">Create a new job appointment</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form action="<?= base_url('/jobs/store') ?>" method="post">
                    <?= csrf_field() ?>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="client_id" class="form-label">Client *</label>
                            <select class="form-select" id="client_id" name="client_id" required>
                                <option value="">Select a client</option>
                                <?php foreach ($clients as $client): ?>
                                    <option value="<?= $client['id'] ?>" <?= old('client_id') == $client['id'] ? 'selected' : '' ?>>
                                        <?= esc($client['name']) ?> - <?= esc($client['phone']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="service_type" class="form-label">Service Type *</label>
                            <select class="form-select" id="service_type" name="service_type" required>
                                <option value="">Select service type</option>
                                <option value="plumbing" <?= old('service_type') == 'plumbing' ? 'selected' : '' ?>>Plumbing</option>
                                <option value="electrical" <?= old('service_type') == 'electrical' ? 'selected' : '' ?>>Electrical</option>
                                <option value="cleaning" <?= old('service_type') == 'cleaning' ? 'selected' : '' ?>>Cleaning</option>
                                <option value="landscaping" <?= old('service_type') == 'landscaping' ? 'selected' : '' ?>>Landscaping</option>
                                <option value="hvac" <?= old('service_type') == 'hvac' ? 'selected' : '' ?>>HVAC</option>
                                <option value="general" <?= old('service_type') == 'general' ? 'selected' : '' ?>>General</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Job Title *</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?= old('title') ?>" placeholder="e.g., Fix leaking faucet" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Detailed description of the work to be done..."><?= old('description') ?></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="address" class="form-label">Job Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="<?= old('address') ?>" placeholder="Where will this job take place?">
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="scheduled_date" class="form-label">Date *</label>
                            <input type="date" class="form-control" id="scheduled_date" name="scheduled_date" value="<?= old('scheduled_date') ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="scheduled_time" class="form-label">Time *</label>
                            <input type="time" class="form-control" id="scheduled_time" name="scheduled_time" value="<?= old('scheduled_time') ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="estimated_duration" class="form-label">Duration (hours)</label>
                            <input type="number" class="form-control" id="estimated_duration" name="estimated_duration" value="<?= old('estimated_duration') ?>" step="0.5" min="0.5" placeholder="2.5">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="priority" class="form-label">Priority</label>
                            <select class="form-select" id="priority" name="priority">
                                <option value="low" <?= old('priority') == 'low' ? 'selected' : '' ?>>Low</option>
                                <option value="medium" <?= old('priority') == 'medium' || !old('priority') ? 'selected' : '' ?>>Medium</option>
                                <option value="high" <?= old('priority') == 'high' ? 'selected' : '' ?>>High</option>
                                <option value="urgent" <?= old('priority') == 'urgent' ? 'selected' : '' ?>>Urgent</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">Estimated Price</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="price" name="price" value="<?= old('price') ?>" step="0.01" min="0" placeholder="0.00">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Any special instructions or notes..."><?= old('notes') ?></textarea>
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?= base_url('/jobs') ?>" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-calendar-plus me-2"></i>Schedule Job
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>Job Scheduling Tips
                </h6>
            </div>
            <div class="card-body">
                <p class="text-muted small">
                    <strong>Be specific with job titles</strong> - This helps you quickly identify jobs in your schedule.
                </p>
                <p class="text-muted small">
                    <strong>Add detailed descriptions</strong> - Include what tools or materials might be needed.
                </p>
                <p class="text-muted small">
                    <strong>Set realistic durations</strong> - This helps with scheduling and client expectations.
                </p>
                <p class="text-muted small">
                    <strong>Use priority levels</strong> - Urgent jobs will stand out in your schedule.
                </p>
            </div>
        </div>
        
        <?php if (empty($clients)): ?>
            <div class="card mt-3">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-2x text-muted mb-3"></i>
                    <h6>No clients yet</h6>
                    <p class="text-muted small">You need to add clients before scheduling jobs.</p>
                    <a href="<?= base_url('/clients/create') ?>" class="btn btn-sm btn-primary">Add Client</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Auto-populate address from selected client
document.getElementById('client_id').addEventListener('change', function() {
    // In a real application, you would fetch client details via AJAX
    // and populate the address field
});

// Set minimum date to today
document.getElementById('scheduled_date').min = new Date().toISOString().split('T')[0];
</script>
<?= $this->endSection() ?>