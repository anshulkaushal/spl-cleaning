<?php
/**
 * Site header
 */
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/helpers.php';

$currentPage = basename($_SERVER['PHP_SELF']);
$isLoggedIn = isLoggedIn();
$userName = $_SESSION['user_name'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - ' : ''; ?>SparklePro Cleaning Services</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <header class="site-header">
        <div class="top-contact-strip">
            <div class="container d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-4 flex-wrap">
                    <span><i class="bi bi-telephone-fill me-2"></i>+64 210 258 8777</span>
                    <span><i class="bi bi-envelope-fill me-2"></i>contact@sparklepro.co.nz</span>
                    <span class="d-none d-md-inline"><i class="bi bi-geo-alt-fill me-2"></i>Wellington Region, New Zealand</span>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <a href="/request-quote?callback=1" class="contact-link">Request a call back</a>
                </div>
            </div>
        </div>

        <div class="nav-bar-wrap sticky-top">
            <div class="container">
                <div class="nav-inner">
                    <a class="brand-logo" href="/">
                        <div class="brand-mark">
                            <span class="brand-icon"><i class="bi bi-buildings"></i></span>
                            <div class="brand-text">
                                <span class="brand-name">SparklePro</span>
                                <span class="brand-tagline">Cleaning Services</span>
                            </div>
                        </div>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <nav class="collapse navbar-collapse show" id="mainNav">
                        <ul class="navbar-nav ms-auto align-items-lg-center">
                            <li class="nav-item">
                                <a class="nav-link <?php echo $currentPage === 'index.php' ? 'active' : ''; ?>" href="/">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/#about">About Us</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle <?php echo $currentPage === 'services.php' ? 'active' : ''; ?>" href="/services" id="servicesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Services
                                </a>
                                <div class="dropdown-menu services-dropdown" aria-labelledby="servicesDropdown">
                                    <div class="services-dropdown-grid">
                                        <a class="dropdown-item" href="/services#service-commercial-cleaning">Commercial Cleaning</a>
                                        <a class="dropdown-item" href="/services#service-carpet-cleaning">Carpet Cleaning</a>
                                        <a class="dropdown-item" href="/services#service-upholstery-cleaning">Upholstery Cleaning</a>
                                        <a class="dropdown-item" href="/services#service-end-of-tenancy-cleaning">End of Tenancy Cleaning</a>
                                        <a class="dropdown-item" href="/services#service-builders-cleaning">Builders Cleaning</a>
                                        <a class="dropdown-item" href="/services#service-pressure-washing">Pressure Washing</a>
                                        <a class="dropdown-item" href="/services#service-gutter-cleaning">Gutter Cleaning</a>
                                        <a class="dropdown-item" href="/services#service-lawn-mowing">Lawn Mowing</a>
                                        <a class="dropdown-item" href="/services#service-window-cleaning">Window Cleaning</a>
                                        <a class="dropdown-item" href="/services#service-disinfection-sanitisation">Disinfection &amp; Sanitisation</a>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/blogs">Blogs</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/#testimonials">Testimonials</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/contact">Contact Us</a>
                            </li>
                            <?php if ($isLoggedIn): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="/account"><i class="bi bi-person-circle me-1"></i>My Account</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/logout">Logout</a>
                                </li>
                            <?php else: ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="/login">Login</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/register">Register</a>
                                </li>
                            <?php endif; ?>
                            <li class="nav-item ms-lg-3">
                                <a class="btn btn-quote" href="/request-quote">Get a Quote</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    
    <main class="page-content">
        <?php
        // Display flash messages
        $flash = getFlashMessage();
        if ($flash):
        ?>
        <div class="container mt-3">
            <div class="alert alert-<?php echo $flash['type'] === 'error' ? 'danger' : $flash['type']; ?> alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($flash['message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
        <?php endif; ?>

