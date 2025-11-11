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
    <div class="top-bar d-none d-lg-block">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <span><i class="bi bi-telephone-outbound"></i> +64 210 258 8777</span>
                <span class="d-none d-lg-inline"><i class="bi bi-envelope-open"></i> hello@sparklepro.co.nz</span>
                <span class="d-none d-xl-inline"><i class="bi bi-geo-alt"></i> Serving Wellington, Lower Hutt, Upper Hutt & Porirua</span>
            </div>
            <div class="d-flex align-items-center gap-3">
                <a href="/request-quote?callback=1" class="text-white"><i class="bi bi-clock-history"></i> Request a call back</a>
                <a href="/request-quote" class="pill text-decoration-none">Book an appointment</a>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="/">
                <span class="badge bg-white text-primary fw-bold"><i class="bi bi-droplet-half"></i></span>
                <span>SparklePro</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                    <li class="nav-item">
                        <a class="nav-link <?php echo $currentPage === 'index.php' ? 'active' : ''; ?>" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $currentPage === 'services.php' ? 'active' : ''; ?>" href="/services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/#areas">Service Areas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $currentPage === 'join-our-team.php' ? 'active' : ''; ?>" href="/join-our-team">Join Our Team</a>
                    </li>
                    <?php if ($isLoggedIn): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $currentPage === 'account.php' ? 'active' : ''; ?>" href="/account">
                                <i class="bi bi-person-circle"></i> My Account
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/logout">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $currentPage === 'login.php' ? 'active' : ''; ?>" href="/login">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $currentPage === 'register.php' ? 'active' : ''; ?>" href="/register">Register</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-primary" href="/request-quote">
                            <i class="bi bi-calendar-check"></i> Get a quote
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <main style="margin-top: 112px;">
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

