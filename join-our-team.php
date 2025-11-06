<?php
/**
 * Join Our Team / CV Upload Page
 */

$pageTitle = 'Join Our Team';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/models/CVApplication.php';

require_once __DIR__ . '/includes/config.php';

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = sanitize($_POST['full_name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $phone = sanitize($_POST['phone'] ?? '');
    $position = sanitize($_POST['position'] ?? 'Cleaner');
    $experienceYears = intval($_POST['experience_years'] ?? 0);
    $experienceText = sanitize($_POST['experience_text'] ?? '');
    $preferredWorkType = sanitize($_POST['preferred_work_type'] ?? 'Full-time');

    // Validation
    if (empty($fullName)) $errors[] = 'Full name is required';
    if (empty($email) || !isValidEmail($email)) $errors[] = 'Valid email is required';
    if (empty($phone) || !isValidPhone($phone)) $errors[] = 'Valid phone is required';

    // File upload validation
    $cvFile = null;
    if (!isset($_FILES['cv_file']) || $_FILES['cv_file']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = 'CV file is required';
    } else {
        $file = $_FILES['cv_file'];
        
        // Check file size
        if ($file['size'] > MAX_FILE_SIZE) {
            $errors[] = 'File size exceeds maximum allowed size (5MB)';
        }

        // Check file type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, ALLOWED_CV_TYPES)) {
            $errors[] = 'Invalid file type. Only PDF, DOC, and DOCX files are allowed';
        }

        if (empty($errors)) {
            // Generate unique filename
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $cvFilename = uniqid('cv_', true) . '.' . $extension;
            $uploadPath = UPLOADS_PATH . '/' . $cvFilename;

            // Create uploads directory if it doesn't exist
            if (!is_dir(UPLOADS_PATH)) {
                mkdir(UPLOADS_PATH, 0755, true);
            }

            // Move uploaded file
            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                $cvFile = $cvFilename;
            } else {
                $errors[] = 'Failed to upload file. Please try again.';
            }
        }
    }

    // Save application
    if (empty($errors) && $cvFile) {
        $cvModel = new CVApplication();
        $applicationData = [
            'full_name' => $fullName,
            'email' => $email,
            'phone' => $phone,
            'position' => $position,
            'experience_years' => $experienceYears,
            'experience_text' => $experienceText,
            'preferred_work_type' => $preferredWorkType,
            'cv_filename' => $cvFile,
            'status' => 'New'
        ];

        if ($cvModel->create($applicationData)) {
            $success = true;
        } else {
            $errors[] = 'Failed to submit application. Please try again.';
            // Delete uploaded file if database insert failed
            if (file_exists($uploadPath)) {
                unlink($uploadPath);
            }
        }
    }
}
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <h1>Join Our Team</h1>
                <p class="lead">We're always looking for dedicated professionals to join the SparklePro family</p>
            </div>

            <?php if ($success): ?>
            <div class="alert alert-success">
                <h4 class="alert-heading">Application Submitted Successfully!</h4>
                <p>Thank you for your interest in joining SparklePro. We have received your application and CV. Our team will review it and get back to you soon.</p>
            </div>
            <?php else: ?>

            <div class="card shadow">
                <div class="card-body p-4">
                    <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="full_name" class="form-label">Full Name *</label>
                                <input type="text" class="form-control" id="full_name" name="full_name" required 
                                       value="<?php echo htmlspecialchars($_POST['full_name'] ?? ''); ?>">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control" id="email" name="email" required 
                                       value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone *</label>
                                <input type="tel" class="form-control" id="phone" name="phone" required 
                                       value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="position" class="form-label">Position Interested In *</label>
                                <select class="form-select" id="position" name="position" required>
                                    <option value="Cleaner" <?php echo ($_POST['position'] ?? 'Cleaner') == 'Cleaner' ? 'selected' : ''; ?>>Cleaner</option>
                                    <option value="Supervisor" <?php echo ($_POST['position'] ?? '') == 'Supervisor' ? 'selected' : ''; ?>>Supervisor</option>
                                    <option value="Admin" <?php echo ($_POST['position'] ?? '') == 'Admin' ? 'selected' : ''; ?>>Admin</option>
                                    <option value="Other" <?php echo ($_POST['position'] ?? '') == 'Other' ? 'selected' : ''; ?>>Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="experience_years" class="form-label">Years of Experience</label>
                                <input type="number" class="form-control" id="experience_years" name="experience_years" 
                                       min="0" value="<?php echo htmlspecialchars($_POST['experience_years'] ?? '0'); ?>">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="preferred_work_type" class="form-label">Preferred Work Type *</label>
                                <select class="form-select" id="preferred_work_type" name="preferred_work_type" required>
                                    <option value="Full-time" <?php echo ($_POST['preferred_work_type'] ?? 'Full-time') == 'Full-time' ? 'selected' : ''; ?>>Full-time</option>
                                    <option value="Part-time" <?php echo ($_POST['preferred_work_type'] ?? '') == 'Part-time' ? 'selected' : ''; ?>>Part-time</option>
                                    <option value="Casual" <?php echo ($_POST['preferred_work_type'] ?? '') == 'Casual' ? 'selected' : ''; ?>>Casual</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="experience_text" class="form-label">Experience Details</label>
                            <textarea class="form-control" id="experience_text" name="experience_text" rows="4" 
                                      placeholder="Tell us about your relevant experience..."><?php echo htmlspecialchars($_POST['experience_text'] ?? ''); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="cv_file" class="form-label">Upload CV (PDF, DOC, DOCX) *</label>
                            <input type="file" class="form-control" id="cv_file" name="cv_file" required 
                                   accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                            <small class="form-text text-muted">Maximum file size: 5MB</small>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 btn-lg">Submit Application</button>
                    </form>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

