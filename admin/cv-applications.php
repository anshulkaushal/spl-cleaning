<?php
/**
 * Admin CV Applications Management
 */

$pageTitle = 'CV Applications';
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/../includes/helpers.php';
require_once __DIR__ . '/../models/CVApplication.php';

require_once __DIR__ . '/../includes/config.php';

$cvModel = new CVApplication();

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_application'])) {
        $id = intval($_POST['application_id']);
        $data = [
            'status' => sanitize($_POST['status']),
            'notes' => sanitize($_POST['notes'] ?? '')
        ];
        
        if ($cvModel->update($id, $data)) {
            redirectWithMessage('/admin/cv-applications', 'Application updated successfully');
        } else {
            redirectWithMessage('/admin/cv-applications', 'Failed to update application', 'error');
        }
    }
}

// Get filters
$filters = [];
if (!empty($_GET['status'])) {
    $filters['status'] = sanitize($_GET['status']);
}
if (!empty($_GET['position'])) {
    $filters['position'] = sanitize($_GET['position']);
}

$applications = $cvModel->getAll($filters);
?>

<h1 class="h2 mb-4">CV Applications</h1>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All</option>
                        <option value="New" <?php echo ($_GET['status'] ?? '') == 'New' ? 'selected' : ''; ?>>New</option>
                        <option value="Shortlisted" <?php echo ($_GET['status'] ?? '') == 'Shortlisted' ? 'selected' : ''; ?>>Shortlisted</option>
                        <option value="Rejected" <?php echo ($_GET['status'] ?? '') == 'Rejected' ? 'selected' : ''; ?>>Rejected</option>
                        <option value="Hired" <?php echo ($_GET['status'] ?? '') == 'Hired' ? 'selected' : ''; ?>>Hired</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Position</label>
                    <select name="position" class="form-select">
                        <option value="">All</option>
                        <option value="Cleaner" <?php echo ($_GET['position'] ?? '') == 'Cleaner' ? 'selected' : ''; ?>>Cleaner</option>
                        <option value="Supervisor" <?php echo ($_GET['position'] ?? '') == 'Supervisor' ? 'selected' : ''; ?>>Supervisor</option>
                        <option value="Admin" <?php echo ($_GET['position'] ?? '') == 'Admin' ? 'selected' : ''; ?>>Admin</option>
                        <option value="Other" <?php echo ($_GET['position'] ?? '') == 'Other' ? 'selected' : ''; ?>>Other</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Applications Table -->
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
                        <th>Position</th>
                        <th>Work Type</th>
                        <th>Experience</th>
                        <th>Status</th>
                        <th>Submitted</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($applications as $app): ?>
                    <tr>
                        <td><?php echo $app['id']; ?></td>
                        <td><?php echo htmlspecialchars($app['full_name']); ?></td>
                        <td><?php echo htmlspecialchars($app['email']); ?></td>
                        <td><?php echo htmlspecialchars($app['phone']); ?></td>
                        <td><?php echo htmlspecialchars($app['position']); ?></td>
                        <td><?php echo htmlspecialchars($app['preferred_work_type']); ?></td>
                        <td><?php echo $app['experience_years']; ?> years</td>
                        <td><?php echo getStatusBadge($app['status']); ?></td>
                        <td><?php echo formatDate($app['created_at'], 'M j, Y'); ?></td>
                        <td>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#appModal<?php echo $app['id']; ?>">
                                View
                            </button>
                        </td>
                    </tr>

                    <!-- Application Details Modal -->
                    <div class="modal fade" id="appModal<?php echo $app['id']; ?>" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Application Details - #<?php echo $app['id']; ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form method="POST" action="">
                                    <div class="modal-body">
                                        <input type="hidden" name="application_id" value="<?php echo $app['id']; ?>">
                                        
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <strong>Full Name:</strong> <?php echo htmlspecialchars($app['full_name']); ?>
                                            </div>
                                            <div class="col-md-6">
                                                <strong>Email:</strong> <?php echo htmlspecialchars($app['email']); ?>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <strong>Phone:</strong> <?php echo htmlspecialchars($app['phone']); ?>
                                            </div>
                                            <div class="col-md-6">
                                                <strong>Position:</strong> <?php echo htmlspecialchars($app['position']); ?>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <strong>Work Type:</strong> <?php echo htmlspecialchars($app['preferred_work_type']); ?>
                                            </div>
                                            <div class="col-md-6">
                                                <strong>Experience:</strong> <?php echo $app['experience_years']; ?> years
                                            </div>
                                        </div>
                                        <?php if ($app['experience_text']): ?>
                                        <div class="mb-3">
                                            <strong>Experience Details:</strong><br>
                                            <?php echo nl2br(htmlspecialchars($app['experience_text'])); ?>
                                        </div>
                                        <?php endif; ?>
                                        
                                        <div class="mb-3">
                                            <strong>CV File:</strong><br>
                                            <a href="<?php echo UPLOADS_URL . '/' . htmlspecialchars($app['cv_filename']); ?>" 
                                               target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-download"></i> Download CV
                                            </a>
                                        </div>
                                        
                                        <hr>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select name="status" class="form-select" required>
                                                <option value="New" <?php echo $app['status'] == 'New' ? 'selected' : ''; ?>>New</option>
                                                <option value="Shortlisted" <?php echo $app['status'] == 'Shortlisted' ? 'selected' : ''; ?>>Shortlisted</option>
                                                <option value="Rejected" <?php echo $app['status'] == 'Rejected' ? 'selected' : ''; ?>>Rejected</option>
                                                <option value="Hired" <?php echo $app['status'] == 'Hired' ? 'selected' : ''; ?>>Hired</option>
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Internal Notes</label>
                                            <textarea name="notes" class="form-control" rows="3"><?php echo htmlspecialchars($app['notes'] ?? ''); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="update_application" class="btn btn-primary">Update</button>
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

