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
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">
                <i class="bi bi-sparkles text-primary"></i> SparklePro
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo $currentPage === 'index.php' ? 'active' : ''; ?>" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $currentPage === 'services.php' ? 'active' : ''; ?>" href="/services.php">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $currentPage === 'join-our-team.php' ? 'active' : ''; ?>" href="/join-our-team.php">Join Our Team</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <?php if ($isLoggedIn): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $currentPage === 'account.php' ? 'active' : ''; ?>" href="/account.php">
                                <i class="bi bi-person-circle"></i> My Account
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $currentPage === 'login.php' ? 'active' : ''; ?>" href="/login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $currentPage === 'register.php' ? 'active' : ''; ?>" href="/register.php">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    
    <main style="margin-top: 76px;">
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

