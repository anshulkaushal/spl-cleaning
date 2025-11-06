<?php
/**
 * Admin Dashboard
 */

$pageTitle = 'Dashboard';
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/../models/Lead.php';
require_once __DIR__ . '/../models/Employee.php';
require_once __DIR__ . '/../models/Schedule.php';
require_once __DIR__ . '/../models/CVApplication.php';

$leadModel = new Lead();
$employeeModel = new Employee();
$scheduleModel = new Schedule();
$cvModel = new CVApplication();

// Get statistics
$leadStats = $leadModel->getStatistics();
$totalEmployees = count($employeeModel->getAll(true));
$todaySchedules = $scheduleModel->getTodaySchedules();
$totalCVs = $cvModel->getTotalCount();

// Get recent leads
$recentLeads = $leadModel->getAll(['status' => 'New']);
$recentLeads = array_slice($recentLeads, 0, 5);

// Get recent CV applications
$recentCVs = $cvModel->getAll();
$recentCVs = array_slice($recentCVs, 0, 5);
?>

<h1 class="h2 mb-4">Dashboard</h1>

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title">Total Leads</h5>
                <h2><?php echo $leadStats['total']; ?></h2>
                <small>New: <?php echo $leadStats['new_count']; ?></small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h5 class="card-title">Open Leads</h5>
                <h2><?php echo $leadStats['new_count'] + $leadStats['in_progress_count']; ?></h2>
                <small>In Progress: <?php echo $leadStats['in_progress_count']; ?></small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5 class="card-title">CV Applications</h5>
                <h2><?php echo $totalCVs; ?></h2>
                <small>Total received</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h5 class="card-title">Jobs Today</h5>
                <h2><?php echo count($todaySchedules); ?></h2>
                <small>Scheduled for today</small>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Recent Leads</h5>
            </div>
            <div class="card-body">
                <?php if (empty($recentLeads)): ?>
                <p class="text-muted">No recent leads</p>
                <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Service</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentLeads as $lead): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($lead['name']); ?></td>
                                <td><?php echo htmlspecialchars($lead['service_type']); ?></td>
                                <td><?php echo getStatusBadge($lead['status']); ?></td>
                                <td><?php echo formatDate($lead['created_at'], 'M j, Y'); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <a href="/admin/leads.php" class="btn btn-sm btn-primary">View All Leads</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Recent CV Applications</h5>
            </div>
            <div class="card-body">
                <?php if (empty($recentCVs)): ?>
                <p class="text-muted">No recent applications</p>
                <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentCVs as $cv): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($cv['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($cv['position']); ?></td>
                                <td><?php echo getStatusBadge($cv['status']); ?></td>
                                <td><?php echo formatDate($cv['created_at'], 'M j, Y'); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <a href="/admin/cv-applications.php" class="btn btn-sm btn-primary">View All Applications</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>

