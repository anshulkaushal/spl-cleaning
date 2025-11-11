<?php
/**
 * Home Page
 */

$pageTitle = 'Home';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/models/Service.php';

$serviceModel = new Service();
$services = $serviceModel->getAll();
// Highlight six hero services on the landing page
$featuredServices = array_slice($services, 0, 6);
?>

<!-- Hero Section -->
<section class="hero-section text-white">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="badge bg-white text-primary mb-3 text-uppercase">Certified green cleaning</span>
                <h1 class="display-5 mb-4">Healthier Living & Working Environments Across Wellington</h1>
                <p class="lead mb-4">From commercial sites and build cleans to carpets, guttering and lawn care, SparklePro delivers multi-trade expertise under one dependable brand.</p>
                <ul class="list-check mb-4">
                    <li><span class="icon-wrap"><i class="bi bi-patch-check-fill"></i></span>Highly trained, vetted & insured teams</li>
                    <li><span class="icon-wrap"><i class="bi bi-leaf-fill"></i></span>Eco-forward products safe for families & pets</li>
                    <li><span class="icon-wrap"><i class="bi bi-bounding-box-circles"></i></span>Flexible scheduling that works around you</li>
                </ul>
                <div class="d-flex flex-column flex-sm-row gap-3">
                    <a href="/request-quote" class="btn btn-primary btn-lg"><i class="bi bi-calendar2-check"></i> Book an appointment</a>
                    <a href="/services#service-commercial-cleaning" class="btn btn-outline-primary btn-lg"><i class="bi bi-grid"></i> Explore services</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-illustration">
                    <div class="d-flex flex-column gap-4">
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge bg-light text-primary fw-semibold">100+ happy clients</span>
                            <span class="badge bg-light text-primary fw-semibold">4 regions covered</span>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="highlight-card text-center">
                                    <div class="icon-circle mb-3"><i class="bi bi-buildings"></i></div>
                                    <h6 class="fw-bold mb-1">Commercial Sites</h6>
                                    <p class="small mb-0">Office, retail & industrial cleaning programmes.</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="highlight-card text-center">
                                    <div class="icon-circle mb-3"><i class="bi bi-house-check"></i></div>
                                    <h6 class="fw-bold mb-1">Move-Out Detailing</h6>
                                    <p class="small mb-0">End-of-tenancy cleans that pass inspection.</p>
                                </div>
                            </div>
                        </div>
                        <div class="highlight-card">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <strong>Today’s schedule</strong>
                                <span class="badge badge-accent"><i class="bi bi-clock-history"></i> Live roster</span>
                            </div>
                            <ul class="list-unstyled mb-0 small d-grid gap-2">
                                <li><i class="bi bi-check-circle text-accent"></i> 07:30 – Apartment sparkle, Te Aro</li>
                                <li><i class="bi bi-check-circle text-accent"></i> 11:00 – Office lobby polish, Lower Hutt</li>
                                <li><i class="bi bi-check-circle text-accent"></i> 14:30 – Rental exit clean, Porirua</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="py-5">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="section-heading">About SparklePro</span>
                <h2 class="display-6 fw-bold mb-3">One partner. Every clean covered.</h2>
                <p class="mb-4">SparklePro brings together specialist teams across commercial, residential and outdoor cleaning disciplines. We manage every detail with transparent communication, eco-conscious methodology and a zealous focus on finish quality.</p>
                <div class="row g-3">
                    <div class="col-sm-4">
                        <div class="stat-block">
                            <h3>15+</h3>
                            <p class="mb-0">Years combined experience</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="stat-block">
                            <h3>4</h3>
                            <p class="mb-0">Regional hubs serviced daily</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="stat-block">
                            <h3>98%</h3>
                            <p class="mb-0">Repeat & referral clients</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow-soft">
                    <div class="card-body p-4 p-lg-5">
                        <h5 class="fw-bold mb-3">Why organisations switch to SparklePro</h5>
                        <ul class="list-unstyled d-grid gap-3 mb-0">
                            <li class="d-flex gap-3">
                                <span class="feature-icon"><i class="bi bi-people-fill"></i></span>
                                <div>
                                    <strong>Skilled & vetted professionals</strong>
                                    <p class="mb-0">Dedicated crews for commercial, post-build, tenancy and outdoor work with continuous upskilling.</p>
                                </div>
                            </li>
                            <li class="d-flex gap-3">
                                <span class="feature-icon"><i class="bi bi-leaf"></i></span>
                                <div>
                                    <strong>Eco and safety first</strong>
                                    <p class="mb-0">Low-tox chemistry, colour-coded equipment and meticulous site safety protocols on every visit.</p>
                                </div>
                            </li>
                            <li class="d-flex gap-3">
                                <span class="feature-icon"><i class="bi bi-cash-coin"></i></span>
                                <div>
                                    <strong>Transparent, honest pricing</strong>
                                    <p class="mb-0">Clear scopes, no surprise add-ons and bundled solutions for multi-service clients.</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="py-5 bg-leaf">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-heading">Complete Service Suite</span>
            <h2 class="display-6 fw-bold">From offices to outdoor areas, one team handles it all</h2>
            <div class="divider"></div>
        </div>
        <div class="row g-4">
            <?php foreach ($featuredServices as $service): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="card-body text-center p-4">
                        <div class="icon-circle mb-3">
                            <i class="bi bi-<?php echo htmlspecialchars($service['icon'] ?? 'sparkles'); ?>"></i>
                        </div>
                        <h5 class="fw-bold mb-2"><?php echo htmlspecialchars($service['name']); ?></h5>
                        <p class="text-secondary mb-3"><?php echo htmlspecialchars($service['description']); ?></p>
                        <?php if ($service['base_price']): ?>
                        <p class="mb-3"><span class="pill">From $<?php echo number_format($service['base_price'], 2); ?></span></p>
                        <?php endif; ?>
                        <a href="/request-quote?service=<?php echo $service['id']; ?>" class="btn btn-primary btn-sm">Plan this service</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-5">
            <a href="/services#service-commercial-cleaning" class="btn btn-accent btn-lg"><i class="bi bi-columns-gap"></i> View the full service catalogue</a>
        </div>
    </div>
</section>

<!-- Process Section -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5">
                <span class="section-heading">Simple process</span>
                <h2 class="display-6 fw-bold mb-3">Booking SparklePro is effortless</h2>
                <p class="mb-4">We streamline your booking so you can focus on what matters. Expect punctual teams, detailed checklists and proactive updates.</p>
                <a href="/request-quote" class="btn btn-primary"><i class="bi bi-pencil-square"></i> Start your booking</a>
            </div>
            <div class="col-lg-7">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="process-step text-center h-100">
                            <span class="badge badge-accent mb-3">Step 01</span>
                            <h5>Tell us about your space</h5>
                            <p class="small mb-0">Share service mix, property type and access details. We confirm scope the same day.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="process-step text-center h-100">
                            <span class="badge badge-accent mb-3">Step 02</span>
                            <h5>Lock in schedule</h5>
                            <p class="small mb-0">Choose a time that suits. We coordinate staff, equipment and site safety requirements.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="process-step text-center h-100">
                            <span class="badge badge-accent mb-3">Step 03</span>
                            <h5>Enjoy spotless results</h5>
                            <p class="small mb-0">Walkthrough on completion, photographic proof for remote clients and ongoing maintenance options.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Service Areas -->
<section id="areas" class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-heading">Service Areas</span>
            <h2 class="display-6 fw-bold">Your Wellington region specialists</h2>
            <p class="lead">Rapid response teams cover Wellington City, Lower Hutt, Upper Hutt and Porirua for consistent results and swift scheduling.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="fw-bold mb-2">Wellington City</h6>
                        <p class="small mb-0">Te Aro, Thorndon, Kelburn, Island Bay and CBD commercial towers.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="fw-bold mb-2">Lower Hutt</h6>
                        <p class="small mb-0">Petone, Seaview, Wainuiomata and industrial hubs throughout the Hutt Valley.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="fw-bold mb-2">Upper Hutt</h6>
                        <p class="small mb-0">Trentham, Silverstream, Wallaceville and lifestyle properties across the Hutt Valley.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="fw-bold mb-2">Porirua & Kapiti</h6>
                        <p class="small mb-0">Porirua, Plimmerton, Whitby and coastal clients up to Paraparaumu and Waikanae.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-heading">Testimonials</span>
            <h2 class="display-6 fw-bold">What local clients are saying</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="quote-card">
                    <div class="quote-icon mb-3"><i class="bi bi-chat-quote-fill"></i></div>
                    <p class="mb-4">“Our office has never looked sharper. SparklePro works around our schedule with zero disruption and the results are consistently impressive.”</p>
                    <div class="testimonial-meta">Tricia Cochran<span>Operations Manager, Wellington CBD</span></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="quote-card">
                    <div class="quote-icon mb-3"><i class="bi bi-chat-quote-fill"></i></div>
                    <p class="mb-4">“Their builders clean was meticulous—hazards gone, dust eliminated, windows sparkling. The crew understood the site brief perfectly.”</p>
                    <div class="testimonial-meta">Kelvin Richards<span>Project Supervisor, Lower Hutt</span></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="quote-card">
                    <div class="quote-icon mb-3"><i class="bi bi-chat-quote-fill"></i></div>
                    <p class="mb-4">“We rely on SparklePro for carpets, upholstery and lawns. One call, multiple solutions—makes facilities management so much easier.”</p>
                    <div class="testimonial-meta">Andrea Fields<span>Property Manager, Porirua</span></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5">
    <div class="container">
        <div class="cta-banner shadow-soft">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <h2 class="fw-bold mb-2">Ready for a spotless, stress-free clean?</h2>
                    <p class="mb-0">Book a site walk-through or request a detailed quote today. Our coordinators will confirm availability within two business hours.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="/request-quote" class="btn btn-accent btn-lg me-lg-3 mb-3 mb-lg-0"><i class="bi bi-calendar-event"></i> Schedule now</a>
                    <a href="tel:+642102588777" class="btn btn-outline-primary btn-lg"><i class="bi bi-telephone"></i> Talk to a specialist</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
