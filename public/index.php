<?php
/**
 * Home Page
 */

$pageTitle = 'Home';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../models/Service.php';

$serviceModel = new Service();
$services = $serviceModel->getAll();
// Limit to 6 services for home page
$featuredServices = array_slice($services, 0, 6);
?>

<!-- Hero Section -->
<section class="hero-section bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Professional Cleaning Services You Can Trust</h1>
                <p class="lead mb-4">We make your space sparkle! From regular house cleaning to deep cleaning and specialized services, SparklePro delivers excellence every time.</p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="/request-quote.php" class="btn btn-light btn-lg">
                        <i class="bi bi-calendar-check"></i> Get a Free Quote
                    </a>
                    <a href="/request-quote.php?callback=1" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-telephone"></i> Request a Call Back
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <i class="bi bi-sparkles" style="font-size: 200px; opacity: 0.3;"></i>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="mb-4">About SparklePro</h2>
                <p class="lead">With years of experience in the cleaning industry, SparklePro Cleaning Services has built a reputation for reliability, professionalism, and exceptional results. We pride ourselves on using eco-friendly products and maintaining the highest standards of cleanliness.</p>
                <p>Our team of vetted, trained professionals is committed to making your home or office a cleaner, healthier place. Whether you need a one-time deep clean or regular maintenance, we're here to help.</p>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5">Our Services</h2>
        <div class="row g-4">
            <?php foreach ($featuredServices as $service): ?>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-<?php echo htmlspecialchars($service['icon'] ?? 'sparkles'); ?> text-primary" style="font-size: 3rem;"></i>
                        <h5 class="card-title mt-3"><?php echo htmlspecialchars($service['name']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($service['description']); ?></p>
                        <?php if ($service['base_price']): ?>
                        <p class="text-primary fw-bold">Starting from $<?php echo number_format($service['base_price'], 2); ?></p>
                        <?php endif; ?>
                        <a href="/request-quote.php?service=<?php echo $service['id']; ?>" class="btn btn-primary">Get a Quote</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-4">
            <a href="/services.php" class="btn btn-outline-primary">View All Services</a>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">Why Choose SparklePro?</h2>
        <div class="row g-4">
            <div class="col-md-3 text-center">
                <i class="bi bi-shield-check text-primary" style="font-size: 3rem;"></i>
                <h5 class="mt-3">Reliable & Trusted</h5>
                <p>Fully insured and bonded. Your peace of mind is our priority.</p>
            </div>
            <div class="col-md-3 text-center">
                <i class="bi bi-people text-primary" style="font-size: 3rem;"></i>
                <h5 class="mt-3">Vetted Staff</h5>
                <p>All our cleaners are background-checked and professionally trained.</p>
            </div>
            <div class="col-md-3 text-center">
                <i class="bi bi-leaf text-primary" style="font-size: 3rem;"></i>
                <h5 class="mt-3">Eco-Friendly</h5>
                <p>We use environmentally safe cleaning products that are safe for your family.</p>
            </div>
            <div class="col-md-3 text-center">
                <i class="bi bi-star text-primary" style="font-size: 3rem;"></i>
                <h5 class="mt-3">Satisfaction Guaranteed</h5>
                <p>100% satisfaction guarantee or we'll come back to make it right.</p>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5">What Our Customers Say</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                        <p class="card-text">"SparklePro did an amazing job on our move-out cleaning. The house was spotless! Highly recommend."</p>
                        <p class="text-muted mb-0"><strong>- Sarah M.</strong></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                        <p class="card-text">"We've been using SparklePro for our office cleaning for over a year. Professional, reliable, and thorough."</p>
                        <p class="text-muted mb-0"><strong>- John D., Office Manager</strong></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                        <p class="card-text">"The deep cleaning service exceeded our expectations. Our carpets look brand new!"</p>
                        <p class="text-muted mb-0"><strong>- Maria L.</strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

