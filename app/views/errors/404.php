<?php
ob_start();
?>

<section class="error-page">
    <div class="container">
        <div class="error-content">
            <div class="error-icon">
                <i class="fas fa-calendar-times"></i>
            </div>
            
            <h1>Event Not Found</h1>
            <p>Sorry, the event you're looking for doesn't exist or may have been removed.</p>
            
            <div class="error-actions">
                <a href="<?= BASE_URL ?>/events" class="btn btn-primary">
                    <i class="fas fa-calendar-alt"></i>
                    Browse All Events
                </a>
                <a href="<?= BASE_URL ?>/" class="btn btn-outline">
                    <i class="fas fa-home"></i>
                    Back to Home
                </a>
            </div>
            
            <div class="error-suggestions">
                <h3>You might also like:</h3>
                <ul>
                    <li><a href="<?= BASE_URL ?>/events">Upcoming Events</a></li>
                    <li><a href="<?= BASE_URL ?>/spots">Tourist Spots</a></li>
                    <li><a href="<?= BASE_URL ?>/itinerary">Plan Your Trip</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<style>
.error-page {
    padding: 5rem 0;
    text-align: center;
    min-height: 60vh;
    display: flex;
    align-items: center;
}

.error-content {
    max-width: 500px;
    margin: 0 auto;
}

.error-icon {
    font-size: 5rem;
    color: var(--text-light);
    margin-bottom: 2rem;
}

.error-page h1 {
    font-size: 2.5rem;
    color: var(--text-color);
    margin-bottom: 1rem;
}

.error-page p {
    color: var(--text-light);
    font-size: 1.2rem;
    margin-bottom: 2rem;
}

.error-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    margin-bottom: 3rem;
    flex-wrap: wrap;
}

.error-suggestions {
    padding-top: 2rem;
    border-top: 1px solid var(--border);
}

.error-suggestions h3 {
    color: var(--text-color);
    margin-bottom: 1rem;
}

.error-suggestions ul {
    list-style: none;
    display: flex;
    justify-content: center;
    gap: 2rem;
    flex-wrap: wrap;
}

.error-suggestions a {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
}

.error-suggestions a:hover {
    text-decoration: underline;
}

@media (max-width: 768px) {
    .error-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .error-suggestions ul {
        flex-direction: column;
        gap: 1rem;
    }
}
</style>

<?php
$content = ob_get_clean();
require VIEW_PATH . '/layouts/main.php';
?>