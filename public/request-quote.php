<?php
/**
 * Quote Request / Callback Request Page
 */

$pageTitle = 'Request a Quote';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/helpers.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Service.php';
require_once __DIR__ . '/../models/Lead.php';

$isLoggedIn = isLoggedIn();
$user = null;
$userModel = new User();
$serviceModel = new Service();
$leadModel = new Lead();

if ($isLoggedIn) {
    $user = $userModel->findById(getCurrentUserId());
}

$services = $serviceModel->getAll();
$selectedServiceId = $_GET['service'] ?? null;
$isCallbackRequest = isset($_GET['callback']) && $_GET['callback'] == '1';

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $phone = sanitize($_POST['phone'] ?? '');
    $address = sanitize($_POST['address'] ?? '');
    $serviceType = sanitize($_POST['service_type'] ?? '');
    $preferredDate = $_POST['preferred_date'] ?? null;
    $preferredTimeWindow = sanitize($_POST['preferred_time_window'] ?? '');
    $propertyType = sanitize($_POST['property_type'] ?? 'House');
    $sizeInfo = sanitize($_POST['size_info'] ?? '');
    $message = sanitize($_POST['message'] ?? '');
    $isCallback = isset($_POST['is_callback_request']) && $_POST['is_callback_request'] == '1';

    // Validation
    if (empty($name)) $errors[] = 'Name is required';
    if (empty($email) || !isValidEmail($email)) $errors[] = 'Valid email is required';
    if (empty($phone) || !isValidPhone($phone)) $errors[] = 'Valid phone is required';
    if (empty($address)) $errors[] = 'Address is required';
    if (empty($serviceType)) $errors[] = 'Service type is required';

    if (empty($errors)) {
        $leadData = [
            'user_id' => $isLoggedIn ? getCurrentUserId() : null,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'service_type' => $serviceType,
            'preferred_date' => $preferredDate ?: null,
            'preferred_time_window' => $preferredTimeWindow,
            'property_type' => $propertyType,
            'size_info' => $sizeInfo,
            'message' => $message,
            'is_callback_request' => $isCallback,
            'status' => 'New'
        ];

        if ($leadModel->create($leadData)) {
            redirectWithMessage('/', 'Thank you! Your request has been submitted. We will contact you soon.');
        } else {
            $errors[] = 'Failed to submit request. Please try again.';
        }
    }
}
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h2 class="card-title text-center mb-4">
                        <?php echo $isCallbackRequest ? 'Request a Call Back' : 'Request a Quote'; ?>
                    </h2>

                    <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Full Name *</label>
                                <input type="text" class="form-control" id="name" name="name" required 
                                       value="<?php echo htmlspecialchars($user['name'] ?? $_POST['name'] ?? ''); ?>">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control" id="email" name="email" required 
                                       value="<?php echo htmlspecialchars($user['email'] ?? $_POST['email'] ?? ''); ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone *</label>
                                <input type="tel" class="form-control" id="phone" name="phone" required 
                                       value="<?php echo htmlspecialchars($user['phone'] ?? $_POST['phone'] ?? ''); ?>">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="service_type" class="form-label">Service Type *</label>
                                <select class="form-select" id="service_type" name="service_type" required>
                                    <option value="">Select a service</option>
                                    <?php foreach ($services as $service): ?>
                                    <option value="<?php echo htmlspecialchars($service['name']); ?>" 
                                            <?php echo ($selectedServiceId == $service['id'] || ($_POST['service_type'] ?? '') == $service['name']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($service['name']); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address *</label>
                            <textarea class="form-control" id="address" name="address" rows="2" required><?php echo htmlspecialchars($user['address'] ?? $_POST['address'] ?? ''); ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="property_type" class="form-label">Property Type</label>
                                <select class="form-select" id="property_type" name="property_type">
                                    <option value="House" <?php echo ($_POST['property_type'] ?? 'House') == 'House' ? 'selected' : ''; ?>>House</option>
                                    <option value="Apartment" <?php echo ($_POST['property_type'] ?? '') == 'Apartment' ? 'selected' : ''; ?>>Apartment</option>
                                    <option value="Office" <?php echo ($_POST['property_type'] ?? '') == 'Office' ? 'selected' : ''; ?>>Office</option>
                                    <option value="Other" <?php echo ($_POST['property_type'] ?? '') == 'Other' ? 'selected' : ''; ?>>Other</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="preferred_date" class="form-label">Preferred Date</label>
                                <input type="date" class="form-control" id="preferred_date" name="preferred_date" 
                                       value="<?php echo htmlspecialchars($_POST['preferred_date'] ?? ''); ?>"
                                       min="<?php echo date('Y-m-d'); ?>">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="preferred_time_window" class="form-label">Time Window</label>
                                <select class="form-select" id="preferred_time_window" name="preferred_time_window">
                                    <option value="">Any time</option>
                                    <option value="Morning (8am-12pm)">Morning (8am-12pm)</option>
                                    <option value="Afternoon (12pm-5pm)">Afternoon (12pm-5pm)</option>
                                    <option value="Evening (5pm-8pm)">Evening (5pm-8pm)</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="size_info" class="form-label">Approximate Size</label>
                            <input type="text" class="form-control" id="size_info" name="size_info" 
                                   placeholder="e.g., 1500 sq ft, 3 bedrooms" 
                                   value="<?php echo htmlspecialchars($_POST['size_info'] ?? ''); ?>">
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Message / Special Instructions</label>
                            <textarea class="form-control" id="message" name="message" rows="3"><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_callback_request" name="is_callback_request" value="1"
                                   <?php echo $isCallbackRequest ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="is_callback_request">
                                Request a call back instead of email
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 btn-lg">
                            <?php echo $isCallbackRequest ? 'Request Call Back' : 'Submit Quote Request'; ?>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

