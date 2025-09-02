<?php
ob_start();
?>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-content">
        <div class="hero-text">
            <h1>Discover Bangladesh Like a Local</h1>
            <p>Authentic experiences, hidden gems, and cultural treasures await you</p>
            
            <?php if (!$isLoggedIn): ?>
                <div class="hero-actions">
                    <a href="<?= BASE_URL ?>/auth/register" class="btn btn-primary">
                        <i class="fas fa-rocket"></i>
                        Start Your Journey
                    </a>
                    <a href="#features" class="btn btn-secondary">
                        <i class="fas fa-play"></i>
                        Learn More
                    </a>
                </div>
            <?php else: ?>
                <div class="hero-welcome">
                    <h2>Welcome back, <?= $username ?>!</h2>
                    <p>Ready to explore more of Bangladesh?</p>
                    <div class="hero-actions">
                        <a href="<?= BASE_URL ?>/events" class="btn btn-secondary">
                            <i class="fas fa-calendar"></i>
                            Browse Events
                        </a>
                        <a href="<?= BASE_URL ?>/itinerary" class="btn btn-accent">
                            <i class="fas fa-route"></i>
                            Plan Trip
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="hero-visual">
            <div class="hero-image"></div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features" id="features">
    <div class="container">
        <h2>Everything You Need for Bangladesh</h2>
        <p class="section-subtitle">From ancient heritage to modern adventures</p>
        
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <h3>Local Events</h3>
                <p>Discover festivals, cultural events, and celebrations happening around you</p>
                <a href="<?= BASE_URL ?>/events" class="feature-link">
                    Explore Events <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <h3>Tourist Spots</h3>
                <p>From Sundarbans to Cox's Bazar - find the best destinations</p>
                <a href="<?= BASE_URL ?>/spots" class="feature-link">
                    Find Destinations <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-route"></i>
                </div>
                <h3>Trip Planning</h3>
                <p>Create personalized itineraries with local insights</p>
                <a href="<?= BASE_URL ?>/itinerary" class="feature-link">
                    Plan Your Trip <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-bus"></i>
                </div>
                <h3>Transportation</h3>
                <p>Navigate Bangladesh with confidence - buses, trains, and more</p>
                <a href="<?= BASE_URL ?>/transport" class="feature-link">
                    Get Around <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-comments"></i>
                </div>
                <h3>Ask a Local</h3>
                <p>Get answers from friendly locals who know Bangladesh best</p>
                <a href="<?= BASE_URL ?>/ask-local" class="feature-link">
                    Ask Questions <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-star"></i>
                </div>
                <h3>Reviews & Ratings</h3>
                <p>Read honest reviews and share your experiences</p>
                <a href="<?= BASE_URL ?>/reviews" class="feature-link">
                    See Reviews <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Quick Tools Section -->
<section class="quick-tools">
    <div class="container">
        <h2>Essential Travel Tools</h2>
        
        <div class="tools-grid">
            <div class="tool-card">
                <div class="tool-icon">
                    <i class="fas fa-passport"></i>
                </div>
                <h4>Visa Information</h4>
                <p>Updated visa requirements and application guidance</p>
                <a href="<?= BASE_URL ?>/visa-info" class="btn btn-outline">Check Visa Info</a>
            </div>
            
            <div class="tool-card">
                <div class="tool-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h4>Safety Tips</h4>
                <p>Stay safe and informed during your travels</p>
                <a href="<?= BASE_URL ?>/safety" class="btn btn-outline">Safety Guide</a>
            </div>
            
            <div class="tool-card">
                <div class="tool-icon">
                    <i class="fas fa-exchange-alt"></i>
                </div>
                <h4>Currency Converter</h4>
                <p>Convert your currency to Bangladeshi Taka</p>
                <a href="<?= BASE_URL ?>/currency" class="btn btn-outline">Convert Currency</a>
            </div>
            
            <div class="tool-card">
                <div class="tool-icon">
                    <i class="fas fa-cloud-sun"></i>
                </div>
                <h4>Weather</h4>
                <p>Check current weather conditions across Bangladesh</p>
                <a href="<?= BASE_URL ?>/weather" class="btn btn-outline">Check Weather</a>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<?php if (!$isLoggedIn): ?>
<section class="cta-section">
    <div class="container">
        <div class="cta-content">
            <h2>Ready to Explore Bangladesh?</h2>
            <p>Join our community of travelers and locals. Start your adventure today!</p>
            <a href="<?= BASE_URL ?>/auth/register" class="btn btn-primary btn-large">
                <i class="fas fa-user-plus"></i>
                Join GoLocal Now
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<?php
$content = ob_get_clean();
require VIEW_PATH . '/layouts/main.php';
?>