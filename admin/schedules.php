<?php
/**
 * Admin Schedules Management
 */

$pageTitle = 'Manage Schedules';
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/../includes/helpers.php';
require_once __DIR__ . '/../models/Schedule.php';
require_once __DIR__ . '/../models/Employee.php';
require_once __DIR__ . '/../models/Lead.php';

$scheduleModel = new Schedule();
$employeeModel = new Employee();
$leadModel = new Lead();

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create_schedule'])) {
        $data = [
            'employee_id' => intval($_POST['employee_id']),
            'lead_id' => !empty($_POST['lead_id']) ? intval($_POST['lead_id']) : null,
            'job_title' => sanitize($_POST['job_title']),
            'job_description' => sanitize($_POST['job_description'] ?? ''),
            'job_address' => sanitize($_POST['job_address']),
            'job_date' => sanitize($_POST['job_date']),
            'start_time' => sanitize($_POST['start_time']),
            'end_time' => sanitize($_POST['end_time']),
            'status' => sanitize($_POST['status'] ?? 'Scheduled')
        ];
        
        if ($scheduleModel->create($data)) {
            redirectWithMessage('/admin/schedules.php', 'Schedule created successfully');
        } else {
            redirectWithMessage('/admin/schedules.php', 'Failed to create schedule', 'error');
        }
    } elseif (isset($_POST['update_schedule'])) {
        $id = intval($_POST['schedule_id']);
        $data = [
            'employee_id' => intval($_POST['employee_id']),
            'lead_id' => !empty($_POST['lead_id']) ? intval($_POST['lead_id']) : null,
            'job_title' => sanitize($_POST['job_title']),
            'job_description' => sanitize($_POST['job_description'] ?? ''),
            'job_address' => sanitize($_POST['job_address']),
            'job_date' => sanitize($_POST['job_date']),
            'start_time' => sanitize($_POST['start_time']),
            'end_time' => sanitize($_POST['end_time']),
            'status' => sanitize($_POST['status'])
        ];
        
        if ($scheduleModel->update($id, $data)) {
            redirectWithMessage('/admin/schedules.php', 'Schedule updated successfully');
        } else {
            redirectWithMessage('/admin/schedules.php', 'Failed to update schedule', 'error');
        }
    }
}

// Get filters
$filters = [];
if (!empty($_GET['employee_id'])) {
    $filters['employee_id'] = intval($_GET['employee_id']);
}
if (!empty($_GET['date_from'])) {
    $filters['date_from'] = sanitize($_GET['date_from']);
}
if (!empty($_GET['date_to'])) {
    $filters['date_to'] = sanitize($_GET['date_to']);
}
if (!empty($_GET['status'])) {
    $filters['status'] = sanitize($_GET['status']);
}

$schedules = $scheduleModel->getAll($filters);
$employees = $employeeModel->getAll(true);
$leads = $leadModel->getAll();
?>

<h1 class="h2 mb-4">Manage Schedules</h1>

<!-- Filters and Create Button -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row align-items-end">
            <div class="col-md-3">
                <label class="form-label">Employee</label>
                <form method="GET" action="" class="d-flex gap-2">
                    <select name="employee_id" class="form-select" onchange="this.form.submit()">
                        <option value="">All Employees</option>
                        <?php foreach ($employees as $emp): ?>
                        <option value="<?php echo $emp['id']; ?>" <?php echo ($_GET['employee_id'] ?? '') == $emp['id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($emp['name']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>
            <div class="col-md-3">
                <label class="form-label">Date From</label>
                <input type="date" class="form-control" id="date_from" value="<?php echo htmlspecialchars($_GET['date_from'] ?? ''); ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Date To</label>
                <input type="date" class="form-control" id="date_to" value="<?php echo htmlspecialchars($_GET['date_to'] ?? ''); ?>">
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#createScheduleModal">
                    <i class="bi bi-plus-circle"></i> New Schedule
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Schedules Table -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Employee</th>
                        <th>Job Title</th>
                        <th>Address</th>
                        <th>Related Lead</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($schedules as $schedule): ?>
                    <tr>
                        <td><?php echo formatDate($schedule['job_date']); ?></td>
                        <td><?php echo date('g:i A', strtotime($schedule['start_time'])); ?> - <?php echo date('g:i A', strtotime($schedule['end_time'])); ?></td>
                        <td><?php echo htmlspecialchars($schedule['employee_name']); ?></td>
                        <td><?php echo htmlspecialchars($schedule['job_title']); ?></td>
                        <td><?php echo htmlspecialchars($schedule['job_address']); ?></td>
                        <td><?php echo htmlspecialchars($schedule['lead_name'] ?? 'N/A'); ?></td>
                        <td><?php echo getStatusBadge($schedule['status']); ?></td>
                        <td>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editScheduleModal<?php echo $schedule['id']; ?>">
                                Edit
                            </button>
                        </td>
                    </tr>

                    <!-- Edit Schedule Modal -->
                    <div class="modal fade" id="editScheduleModal<?php echo $schedule['id']; ?>" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Schedule</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form method="POST" action="">
                                    <div class="modal-body">
                                        <input type="hidden" name="schedule_id" value="<?php echo $schedule['id']; ?>">
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Employee</label>
                                                <select name="employee_id" class="form-select" required>
                                                    <?php foreach ($employees as $emp): ?>
                                                    <option value="<?php echo $emp['id']; ?>" <?php echo $schedule['employee_id'] == $emp['id'] ? 'selected' : ''; ?>>
                                                        <?php echo htmlspecialchars($emp['name']); ?>
                                                    </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Related Lead (Optional)</label>
                                                <select name="lead_id" class="form-select">
                                                    <option value="">None</option>
                                                    <?php foreach ($leads as $lead): ?>
                                                    <option value="<?php echo $lead['id']; ?>" <?php echo $schedule['lead_id'] == $lead['id'] ? 'selected' : ''; ?>>
                                                        #<?php echo $lead['id']; ?> - <?php echo htmlspecialchars($lead['name']); ?>
                                                    </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Job Title</label>
                                            <input type="text" name="job_title" class="form-control" value="<?php echo htmlspecialchars($schedule['job_title']); ?>" required>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Job Description</label>
                                            <textarea name="job_description" class="form-control" rows="2"><?php echo htmlspecialchars($schedule['job_description'] ?? ''); ?></textarea>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Job Address</label>
                                            <textarea name="job_address" class="form-control" rows="2" required><?php echo htmlspecialchars($schedule['job_address']); ?></textarea>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Date</label>
                                                <input type="date" name="job_date" class="form-control" value="<?php echo $schedule['job_date']; ?>" required>
                                            </div>
                                            
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Start Time</label>
                                                <input type="time" name="start_time" class="form-control" value="<?php echo $schedule['start_time']; ?>" required>
                                            </div>
                                            
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">End Time</label>
                                                <input type="time" name="end_time" class="form-control" value="<?php echo $schedule['end_time']; ?>" required>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select name="status" class="form-select" required>
                                                <option value="Scheduled" <?php echo $schedule['status'] == 'Scheduled' ? 'selected' : ''; ?>>Scheduled</option>
                                                <option value="In Progress" <?php echo $schedule['status'] == 'In Progress' ? 'selected' : ''; ?>>In Progress</option>
                                                <option value="Completed" <?php echo $schedule['status'] == 'Completed' ? 'selected' : ''; ?>>Completed</option>
                                                <option value="Cancelled" <?php echo $schedule['status'] == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" name="update_schedule" class="btn btn-primary">Update</button>
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

<!-- Create Schedule Modal -->
<div class="modal fade" id="createScheduleModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Schedule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Employee</label>
                            <select name="employee_id" class="form-select" required>
                                <option value="">Select Employee</option>
                                <?php foreach ($employees as $emp): ?>
                                <option value="<?php echo $emp['id']; ?>"><?php echo htmlspecialchars($emp['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Related Lead (Optional)</label>
                            <select name="lead_id" class="form-select">
                                <option value="">None</option>
                                <?php foreach ($leads as $lead): ?>
                                <option value="<?php echo $lead['id']; ?>">
                                    #<?php echo $lead['id']; ?> - <?php echo htmlspecialchars($lead['name']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Job Title</label>
                        <input type="text" name="job_title" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Job Description</label>
                        <textarea name="job_description" class="form-control" rows="2"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Job Address</label>
                        <textarea name="job_address" class="form-control" rows="2" required></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" name="job_date" class="form-control" required min="<?php echo date('Y-m-d'); ?>">
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Start Time</label>
                            <input type="time" name="start_time" class="form-control" required>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label">End Time</label>
                            <input type="time" name="end_time" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="create_schedule" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>

