<?php
/**
 * Admin Reports
 */

$pageTitle = 'Reports';
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../models/Employee.php';
require_once __DIR__ . '/../../models/Schedule.php';
require_once __DIR__ . '/../../models/Lead.php';

require_once __DIR__ . '/../../includes/config.php';

$employeeModel = new Employee();
$scheduleModel = new Schedule();
$leadModel = new Lead();

$employees = $employeeModel->getAll(true);

// Get date range
$dateFrom = $_GET['date_from'] ?? date('Y-m-d', strtotime('-30 days'));
$dateTo = $_GET['date_to'] ?? date('Y-m-d');
$selectedEmployeeId = !empty($_GET['employee_id']) ? intval($_GET['employee_id']) : null;

$reportType = $_GET['report'] ?? 'workload';
?>

<h1 class="h2 mb-4">Reports</h1>

<!-- Report Type Selector -->
<div class="card mb-4">
    <div class="card-body">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php echo $reportType === 'workload' ? 'active' : ''; ?>" href="?report=workload">Employee Workload</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $reportType === 'tasks' ? 'active' : ''; ?>" href="?report=tasks">Employee Tasks</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $reportType === 'leads' ? 'active' : ''; ?>" href="?report=leads">Leads Report</a>
            </li>
        </ul>
    </div>
</div>

<?php if ($reportType === 'workload'): ?>
<!-- Employee Workload Report -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Employee Workload Report</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="" class="mb-4">
            <input type="hidden" name="report" value="workload">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Date From</label>
                    <input type="date" name="date_from" class="form-control" value="<?php echo htmlspecialchars($dateFrom); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Date To</label>
                    <input type="date" name="date_to" class="form-control" value="<?php echo htmlspecialchars($dateTo); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">Generate Report</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Total Tasks</th>
                        <th>Scheduled</th>
                        <th>In Progress</th>
                        <th>Completed</th>
                        <th>Cancelled</th>
                        <th>Total Hours</th>
                        <th>Busy %</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $baselineHours = BASELINE_HOURS_PER_WEEK;
                    $daysInRange = (strtotime($dateTo) - strtotime($dateFrom)) / 86400 + 1;
                    $baselineHoursForRange = ($baselineHours / 7) * $daysInRange;
                    
                    foreach ($employees as $employee): 
                        $workload = $scheduleModel->getEmployeeWorkload($employee['id'], $dateFrom, $dateTo);
                        $totalHours = $workload['total_hours'] ?? 0;
                        $busyPercentage = $baselineHoursForRange > 0 ? ($totalHours / $baselineHoursForRange) * 100 : 0;
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($employee['name']); ?></td>
                        <td><?php echo $workload['total_tasks'] ?? 0; ?></td>
                        <td><?php echo $workload['scheduled_count'] ?? 0; ?></td>
                        <td><?php echo $workload['in_progress_count'] ?? 0; ?></td>
                        <td><?php echo $workload['completed_count'] ?? 0; ?></td>
                        <td><?php echo $workload['cancelled_count'] ?? 0; ?></td>
                        <td><?php echo number_format($totalHours, 1); ?> hrs</td>
                        <td>
                            <span class="badge <?php echo $busyPercentage > 100 ? 'bg-danger' : ($busyPercentage > 80 ? 'bg-warning' : 'bg-success'); ?>">
                                <?php echo number_format($busyPercentage, 1); ?>%
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <p class="text-muted mt-3">
            <small>Baseline: <?php echo $baselineHours; ?> hours/week (<?php echo number_format($baselineHoursForRange, 1); ?> hours for this period)</small>
        </p>
    </div>
</div>

<?php elseif ($reportType === 'tasks'): ?>
<!-- Employee Task List Report -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Employee Task List</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="" class="mb-4">
            <input type="hidden" name="report" value="tasks">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Employee</label>
                    <select name="employee_id" class="form-select" required>
                        <option value="">Select Employee</option>
                        <?php foreach ($employees as $emp): ?>
                        <option value="<?php echo $emp['id']; ?>" <?php echo $selectedEmployeeId == $emp['id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($emp['name']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Date From</label>
                    <input type="date" name="date_from" class="form-control" value="<?php echo htmlspecialchars($dateFrom); ?>" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Date To</label>
                    <input type="date" name="date_to" class="form-control" value="<?php echo htmlspecialchars($dateTo); ?>" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">Generate</button>
                </div>
            </div>
        </form>

        <?php if ($selectedEmployeeId): ?>
        <?php
        $filters = [
            'employee_id' => $selectedEmployeeId,
            'date_from' => $dateFrom,
            'date_to' => $dateTo
        ];
        $tasks = $scheduleModel->getAll($filters);
        $selectedEmployee = $employeeModel->findById($selectedEmployeeId);
        ?>
        <h5>Tasks for <?php echo htmlspecialchars($selectedEmployee['name']); ?></h5>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Job Title</th>
                        <th>Address</th>
                        <th>Related Lead</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($tasks)): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted">No tasks found for this period</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td><?php echo formatDate($task['job_date']); ?></td>
                        <td><?php echo date('g:i A', strtotime($task['start_time'])); ?> - <?php echo date('g:i A', strtotime($task['end_time'])); ?></td>
                        <td><?php echo htmlspecialchars($task['job_title']); ?></td>
                        <td><?php echo htmlspecialchars($task['job_address']); ?></td>
                        <td><?php echo htmlspecialchars($task['lead_name'] ?? 'N/A'); ?></td>
                        <td><?php echo getStatusBadge($task['status']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php elseif ($reportType === 'leads'): ?>
<!-- Leads Report -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Leads Report</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="" class="mb-4">
            <input type="hidden" name="report" value="leads">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Date From</label>
                    <input type="date" name="date_from" class="form-control" value="<?php echo htmlspecialchars($dateFrom); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Date To</label>
                    <input type="date" name="date_to" class="form-control" value="<?php echo htmlspecialchars($dateTo); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">Generate Report</button>
                </div>
            </div>
        </form>

        <?php
        $leadStats = $leadModel->getStatistics($dateFrom, $dateTo);
        $total = $leadStats['total'] ?? 0;
        $completed = $leadStats['completed_count'] ?? 0;
        $conversionRate = $total > 0 ? ($completed / $total) * 100 : 0;
        ?>
        
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <h3><?php echo $total; ?></h3>
                        <p class="mb-0">Total Leads</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body text-center">
                        <h3><?php echo $leadStats['new_count'] ?? 0; ?></h3>
                        <p class="mb-0">New</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body text-center">
                        <h3><?php echo $leadStats['in_progress_count'] ?? 0; ?></h3>
                        <p class="mb-0">In Progress</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <h3><?php echo $completed; ?></h3>
                        <p class="mb-0">Completed</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5>Conversion Rate</h5>
                <div class="progress mb-3" style="height: 30px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $conversionRate; ?>%">
                        <?php echo number_format($conversionRate, 1); ?>%
                    </div>
                </div>
                <p class="text-muted">
                    <?php echo $completed; ?> out of <?php echo $total; ?> leads were completed 
                    (<?php echo number_format($conversionRate, 1); ?>% conversion rate)
                </p>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/footer.php'; ?>

