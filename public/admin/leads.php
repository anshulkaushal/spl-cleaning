<?php
/**
 * Admin Leads Management
 */

$pageTitle = 'Manage Leads';
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../models/Lead.php';
require_once __DIR__ . '/../../models/Employee.php';

$leadModel = new Lead();
$employeeModel = new Employee();

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_lead'])) {
        $leadId = intval($_POST['lead_id']);
        $data = [
            'status' => sanitize($_POST['status']),
            'assigned_employee_id' => !empty($_POST['assigned_employee_id']) ? intval($_POST['assigned_employee_id']) : null,
            'notes' => sanitize($_POST['notes'] ?? '')
        ];
        
        if ($leadModel->update($leadId, $data)) {
            redirectWithMessage('/admin/leads.php', 'Lead updated successfully');
        } else {
            redirectWithMessage('/admin/leads.php', 'Failed to update lead', 'error');
        }
    }
}

// Get filters
$filters = [];
if (!empty($_GET['status'])) {
    $filters['status'] = sanitize($_GET['status']);
}
if (!empty($_GET['service_type'])) {
    $filters['service_type'] = sanitize($_GET['service_type']);
}
if (!empty($_GET['date_from'])) {
    $filters['date_from'] = sanitize($_GET['date_from']);
}
if (!empty($_GET['date_to'])) {
    $filters['date_to'] = sanitize($_GET['date_to']);
}

$leads = $leadModel->getAll($filters);
$employees = $employeeModel->getAll(true);
?>

<h1 class="h2 mb-4">Manage Leads</h1>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All</option>
                        <option value="New" <?php echo ($_GET['status'] ?? '') == 'New' ? 'selected' : ''; ?>>New</option>
                        <option value="In Progress" <?php echo ($_GET['status'] ?? '') == 'In Progress' ? 'selected' : ''; ?>>In Progress</option>
                        <option value="Completed" <?php echo ($_GET['status'] ?? '') == 'Completed' ? 'selected' : ''; ?>>Completed</option>
                        <option value="Cancelled" <?php echo ($_GET['status'] ?? '') == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Service Type</label>
                    <input type="text" name="service_type" class="form-control" value="<?php echo htmlspecialchars($_GET['service_type'] ?? ''); ?>" placeholder="Filter by service">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Date From</label>
                    <input type="date" name="date_from" class="form-control" value="<?php echo htmlspecialchars($_GET['date_from'] ?? ''); ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Date To</label>
                    <input type="date" name="date_to" class="form-control" value="<?php echo htmlspecialchars($_GET['date_to'] ?? ''); ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Leads Table -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Service</th>
                        <th>Status</th>
                        <th>Assigned To</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($leads as $lead): ?>
                    <tr>
                        <td><?php echo $lead['id']; ?></td>
                        <td><?php echo htmlspecialchars($lead['name']); ?></td>
                        <td><?php echo htmlspecialchars($lead['email']); ?></td>
                        <td><?php echo htmlspecialchars($lead['phone']); ?></td>
                        <td><?php echo htmlspecialchars($lead['service_type']); ?></td>
                        <td><?php echo getStatusBadge($lead['status']); ?></td>
                        <td><?php echo htmlspecialchars($lead['employee_name'] ?? 'Unassigned'); ?></td>
                        <td><?php echo formatDate($lead['created_at'], 'M j, Y'); ?></td>
                        <td>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#leadModal<?php echo $lead['id']; ?>">
                                View/Edit
                            </button>
                        </td>
                    </tr>

                    <!-- Lead Details Modal -->
                    <div class="modal fade" id="leadModal<?php echo $lead['id']; ?>" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Lead Details - #<?php echo $lead['id']; ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form method="POST" action="">
                                    <div class="modal-body">
                                        <input type="hidden" name="lead_id" value="<?php echo $lead['id']; ?>">
                                        
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <strong>Name:</strong> <?php echo htmlspecialchars($lead['name']); ?>
                                            </div>
                                            <div class="col-md-6">
                                                <strong>Email:</strong> <?php echo htmlspecialchars($lead['email']); ?>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <strong>Phone:</strong> <?php echo htmlspecialchars($lead['phone']); ?>
                                            </div>
                                            <div class="col-md-6">
                                                <strong>Service:</strong> <?php echo htmlspecialchars($lead['service_type']); ?>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <strong>Address:</strong> <?php echo htmlspecialchars($lead['address']); ?>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <strong>Property Type:</strong> <?php echo htmlspecialchars($lead['property_type']); ?>
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Preferred Date:</strong> <?php echo $lead['preferred_date'] ? formatDate($lead['preferred_date']) : 'N/A'; ?>
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Time Window:</strong> <?php echo htmlspecialchars($lead['preferred_time_window'] ?? 'N/A'); ?>
                                            </div>
                                        </div>
                                        <?php if ($lead['message']): ?>
                                        <div class="mb-3">
                                            <strong>Message:</strong><br>
                                            <?php echo nl2br(htmlspecialchars($lead['message'])); ?>
                                        </div>
                                        <?php endif; ?>
                                        
                                        <hr>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select name="status" class="form-select" required>
                                                <option value="New" <?php echo $lead['status'] == 'New' ? 'selected' : ''; ?>>New</option>
                                                <option value="In Progress" <?php echo $lead['status'] == 'In Progress' ? 'selected' : ''; ?>>In Progress</option>
                                                <option value="Completed" <?php echo $lead['status'] == 'Completed' ? 'selected' : ''; ?>>Completed</option>
                                                <option value="Cancelled" <?php echo $lead['status'] == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Assign to Employee</label>
                                            <select name="assigned_employee_id" class="form-select">
                                                <option value="">Unassigned</option>
                                                <?php foreach ($employees as $emp): ?>
                                                <option value="<?php echo $emp['id']; ?>" <?php echo $lead['assigned_employee_id'] == $emp['id'] ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($emp['name']); ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Internal Notes</label>
                                            <textarea name="notes" class="form-control" rows="3"><?php echo htmlspecialchars($lead['notes'] ?? ''); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="update_lead" class="btn btn-primary">Update Lead</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>

