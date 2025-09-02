<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'GoLocal' ?> - Discover Bangladesh</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-logo">
                <a href="<?= BASE_URL ?>/">
                    <i class="fas fa-map-marked-alt"></i>
                    GoLocal
                </a>
            </div>
            
            <div class="nav-menu" id="navMenu">
                <a href="<?= BASE_URL ?>/" class="nav-link">Home</a>
                <a href="<?= BASE_URL ?>/events" class="nav-link">Events</a>
                <a href="<?= BASE_URL ?>/spots" class="nav-link">Tourist Spots</a>
                <a href="<?= BASE_URL ?>/itinerary" class="nav-link">Plan Trip</a>
                <a href="<?= BASE_URL ?>/transport" class="nav-link">Transport</a>
                <a href="<?= BASE_URL ?>/ask-local" class="nav-link">Ask a Local</a>
                
                <?php if (Session::isLoggedIn()): ?>
                    <div class="nav-dropdown">
                        <a href="#" class="nav-link dropdown-toggle">
                            <i class="fas fa-user"></i>
                            <?= Session::get('full_name') ?>
                        </a>
                        <div class="dropdown-content">
                            <a href="<?= BASE_URL ?>/profile">Profile</a>
                            <a href="<?= BASE_URL ?>/auth/logout">Logout</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>/auth/login" class="nav-link">Login</a>
                    <a href="<?= BASE_URL ?>/auth/register" class="nav-link nav-cta">Join GoLocal</a>
                <?php endif; ?>
            </div>
            
            <div class="nav-toggle" id="navToggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <?php 
    $flash = Session::getFlash();
    if ($flash): 
    ?>
        <div class="flash-message flash-<?= $flash['type'] ?>" id="flashMessage">
            <?= $flash['message'] ?>
            <button onclick="closeFlash()" class="flash-close">&times;</button>
        </div>
    <?php endif; ?>

    <!-- Main Content -->
    <main class="main-content">
        <?= $content ?? '' ?>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-section">
                <h3><i class="fas fa-map-marked-alt"></i> GoLocal</h3>
                <p>Your gateway to authentic Bangladeshi experiences</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
            
            <div class="footer-section">
                <h4>Explore</h4>
                <ul>
                    <li><a href="<?= BASE_URL ?>/events">Events</a></li>
                    <li><a href="<?= BASE_URL ?>/spots">Tourist Spots</a></li>
                    <li><a href="<?= BASE_URL ?>/transport">Transportation</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h4>Support</h4>
                <ul>
                    <li><a href="<?= BASE_URL ?>/visa-info">Visa Information</a></li>
                    <li><a href="<?= BASE_URL ?>/safety">Safety Tips</a></li>
                    <li><a href="<?= BASE_URL ?>/contact">Contact Us</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h4>Connect</h4>
                <p><i class="fas fa-envelope"></i> info@golocal.com</p>
                <p><i class="fas fa-phone"></i> +880-1234-567890</p>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; 2025 GoLocal. All rights reserved. | Discover Bangladesh Like a Local</p>
        </div>
    </footer>

    <script src="<?= BASE_URL ?>/public/js/script.js"></script>
</body>
</html>