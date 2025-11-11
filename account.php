<?php
/**
 * User Account Page
 */

$pageTitle = 'My Account';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/models/User.php';
require_once __DIR__ . '/models/Lead.php';
require_once __DIR__ . '/models/Schedule.php';

requireLogin();

$userModel = new User();
$leadModel = new Lead();
$scheduleModel = new Schedule();

$user = $userModel->findById(getCurrentUserId());
$leads = $leadModel->getByUserId(getCurrentUserId());
?>

<div class="container py-5">
    <h1 class="mb-4">My Account</h1>

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-person-circle"></i> Profile Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                    <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
                    <p><strong>Address:</strong> <?php echo htmlspecialchars($user['address']); ?></p>
                    <p><strong>Member Since:</strong> <?php echo formatDate($user['created_at']); ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-calendar-check"></i> My Quote Requests</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($leads)): ?>
                    <p class="text-muted">You haven't submitted any quote requests yet.</p>
                    <a href="/request-quote" class="btn btn-primary">Request a Quote</a>
                    <?php else: ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Service</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($leads as $lead): ?>
                                <tr>
                                    <td><?php echo formatDate($lead['created_at']); ?></td>
                                    <td><?php echo htmlspecialchars($lead['service_type']); ?></td>
                                    <td><?php echo getStatusBadge($lead['status']); ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" 
                                                data-bs-target="#leadModal<?php echo $lead['id']; ?>">
                                            View Details
                                        </button>
                                    </td>
                                </tr>

                                <!-- Lead Details Modal -->
                                <div class="modal fade" id="leadModal<?php echo $lead['id']; ?>" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Quote Request Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Service:</strong> <?php echo htmlspecialchars($lead['service_type']); ?></p>
                                                <p><strong>Property Type:</strong> <?php echo htmlspecialchars($lead['property_type']); ?></p>
                                                <?php if ($lead['preferred_date']): ?>
                                                <p><strong>Preferred Date:</strong> <?php echo formatDate($lead['preferred_date']); ?></p>
                                                <?php endif; ?>
                                                <?php if ($lead['preferred_time_window']): ?>
                                                <p><strong>Time Window:</strong> <?php echo htmlspecialchars($lead['preferred_time_window']); ?></p>
                                                <?php endif; ?>
                                                <?php if ($lead['size_info']): ?>
                                                <p><strong>Size:</strong> <?php echo htmlspecialchars($lead['size_info']); ?></p>
                                                <?php endif; ?>
                                                <?php if ($lead['message']): ?>
                                                <p><strong>Message:</strong> <?php echo htmlspecialchars($lead['message']); ?></p>
                                                <?php endif; ?>
                                                <p><strong>Status:</strong> <?php echo getStatusBadge($lead['status']); ?></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

