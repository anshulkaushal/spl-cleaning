<?php
/**
 * Services Page
 */

$pageTitle = 'Our Services';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/models/Service.php';

$serviceModel = new Service();
$services = $serviceModel->getAll();
?>

<div class="container py-5">
    <div class="text-center mb-5">
        <h1>Our Cleaning Services</h1>
        <p class="lead">Professional cleaning solutions for every need</p>
    </div>

    <div class="row g-4">
        <?php foreach ($services as $service): ?>
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-<?php echo htmlspecialchars($service['icon'] ?? 'sparkles'); ?> text-primary" style="font-size: 3rem;"></i>
                    <h5 class="card-title mt-3"><?php echo htmlspecialchars($service['name']); ?></h5>
                    <p class="card-text"><?php echo htmlspecialchars($service['description']); ?></p>
                    <?php if ($service['base_price']): ?>
                    <p class="text-primary fw-bold mb-3">Starting from $<?php echo number_format($service['base_price'], 2); ?></p>
                    <?php endif; ?>
                    <a href="/request-quote.php?service=<?php echo $service['id']; ?>" class="btn btn-primary">
                        <i class="bi bi-calendar-check"></i> Get a Quote
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="text-center mt-5">
        <h3>Don't see what you're looking for?</h3>
        <p>Contact us and we'll create a custom cleaning plan for you!</p>
        <a href="/request-quote.php" class="btn btn-primary btn-lg">Request a Custom Quote</a>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

