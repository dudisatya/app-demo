<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1>Clients</h1>
        <p class="text-muted mb-0">Manage your client relationships and contact information</p>
    </div>
    <a href="<?= base_url('/clients/create') ?>" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Add New Client
    </a>
</div>

<div class="card">
    <div class="card-body">
        <?php if (empty($clients)): ?>
            <div class="text-center py-5">
                <i class="fas fa-users fa-4x text-muted mb-4"></i>
                <h4 class="text-muted">No clients yet</h4>
                <p class="text-muted">Start building your client base by adding your first client</p>
                <a href="<?= base_url('/clients/create') ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add Your First Client
                </a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($clients as $client): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle me-3">
                                            <?= strtoupper(substr($client['name'], 0, 2)) ?>
                                        </div>
                                        <strong><?= esc($client['name']) ?></strong>
                                    </div>
                                </td>
                                <td><?= esc($client['email']) ?></td>
                                <td><?= esc($client['phone']) ?></td>
                                <td><?= esc($client['address']) ?></td>
                                <td>
                                    <span class="status-badge status-<?= $client['status'] ?>">
                                        <?= ucfirst($client['status']) ?>
                                    </span>
                                </td>
                                <td><?= date('M j, Y', strtotime($client['created_at'])) ?></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?= base_url('/clients/view/' . $client['id']) ?>" class="btn btn-sm btn-outline-primary" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= base_url('/clients/edit/' . $client['id']) ?>" class="btn btn-sm btn-outline-secondary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" title="Delete" onclick="deleteClient(<?= $client['id'] ?>)">
                                            <i class="fas fa-trash"></i>
                                        </button>
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

<style>
.avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.9rem;
}
</style>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function deleteClient(id) {
    if (confirm('Are you sure you want to delete this client? This action cannot be undone.')) {
        fetch(`<?= base_url('/clients/delete/') ?>${id}`, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        }).then(() => {
            location.reload();
        });
    }
}
</script>
<?= $this->endSection() ?>