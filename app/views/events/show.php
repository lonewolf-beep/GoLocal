<?php
ob_start();
?>

<!-- Event Detail Header -->
<section class="event-detail-header">
    <div class="container">
        <div class="breadcrumb">
            <a href="<?= BASE_URL ?>/">Home</a>
            <i class="fas fa-chevron-right"></i>
            <a href="<?= BASE_URL ?>/events">Events</a>
            <i class="fas fa-chevron-right"></i>
            <span><?= htmlspecialchars($event['title']) ?></span>
        </div>
    </div>
</section>

<!-- Event Details -->
<section class="event-detail">
    <div class="container">
        <div class="event-detail-content">
            <!-- Event Image -->
            <div class="event-detail-image">
                <img src="<?= $event['image_url'] ?: BASE_URL . '/images/default-event.jpg' ?>" 
                     alt="<?= htmlspecialchars($event['title']) ?>">
                
                <div class="event-badges">
                    <?php if ($event['featured']): ?>
                        <span class="badge badge-featured">
                            <i class="fas fa-star"></i> Featured
                        </span>
                    <?php endif; ?>
                    <span class="badge badge-category badge-<?= $event['category'] ?>">
                        <?= ucfirst($event['category']) ?>
                    </span>
                </div>
            </div>
            
            <!-- Event Info -->
            <div class="event-detail-info">
                <h1 class="event-title"><?= htmlspecialchars($event['title']) ?></h1>
                
                <div class="event-meta">
                    <div class="meta-item">
                        <i class="fas fa-calendar-alt"></i>
                        <div>
                            <strong>Date & Time</strong>
                            <p>
                                <?= date('F j, Y', strtotime($event['event_date'])) ?>
                                <?php if ($event['event_time']): ?>
                                    at <?= date('g:i A', strtotime($event['event_time'])) ?>
                                <?php endif; ?>
                                <?php if ($event['end_date'] && $event['end_date'] !== $event['event_date']): ?>
                                    <br>to <?= date('F j, Y', strtotime($event['end_date'])) ?>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                    
                    <div class="meta-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <strong>Location</strong>
                            <p>
                                <?= htmlspecialchars($event['city']) ?>
                                <?php if ($event['venue']): ?>
                                    <br><?= htmlspecialchars($event['venue']) ?>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                    
                    <div class="meta-item">
                        <i class="fas fa-tag"></i>
                        <div>
                            <strong>Price</strong>
                            <p class="event-price">
                                <?php if ($event['price'] == 0): ?>
                                    <span class="price-free">Free Entry</span>
                                <?php else: ?>
                                    <span class="price-paid">৳<?= number_format($event['price'], 2) ?></span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                    
                    <?php if ($event['organizer']): ?>
                        <div class="meta-item">
                            <i class="fas fa-user-tie"></i>
                            <div>
                                <strong>Organized by</strong>
                                <p><?= htmlspecialchars($event['organizer']) ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Action Buttons -->
                <div class="event-actions">
                    <button class="btn btn-primary btn-large" onclick="showInterestModal()">
                        <i class="fas fa-heart"></i> I'm Interested
                    </button>
                    <button class="btn btn-outline bookmark-btn" data-event-id="<?= $event['id'] ?>">
                        <i class="far fa-bookmark"></i> Bookmark
                    </button>
                    <button class="btn btn-outline share-btn" onclick="shareEvent()">
                        <i class="fas fa-share-alt"></i> Share
                    </button>
                    <button class="btn btn-accent" onclick="addToItinerary(<?= $event['id'] ?>)">
                        <i class="fas fa-plus"></i> Add to Trip
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Event Description -->
        <div class="event-description">
            <h2>About This Event</h2>
            <div class="description-content">
                <?= nl2br(htmlspecialchars($event['description'])) ?>
            </div>
        </div>
        
        <!-- Contact Information -->
        <?php if ($event['contact_phone'] || $event['contact_email'] || $event['website_url']): ?>
            <div class="event-contact">
                <h2>Contact Information</h2>
                <div class="contact-grid">
                    <?php if ($event['contact_phone']): ?>
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <div>
                                <strong>Phone</strong>
                                <a href="tel:<?= $event['contact_phone'] ?>">
                                    <?= htmlspecialchars($event['contact_phone']) ?>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($event['contact_email']): ?>
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <strong>Email</strong>
                                <a href="mailto:<?= $event['contact_email'] ?>">
                                    <?= htmlspecialchars($event['contact_email']) ?>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($event['website_url']): ?>
                        <div class="contact-item">
                            <i class="fas fa-globe"></i>
                            <div>
                                <strong>Website</strong>
                                <a href="<?= htmlspecialchars($event['website_url']) ?>" target="_blank">
                                    Visit Website <i class="fas fa-external-link-alt"></i>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Related Events -->
        <?php if (!empty($relatedEvents)): ?>
            <div class="related-events">
                <h2>Other Events in <?= htmlspecialchars($event['city']) ?></h2>
                <div class="related-events-grid">
                    <?php foreach ($relatedEvents as $relatedEvent): ?>
                        <div class="related-event-card">
                            <div class="related-event-image">
                                <img src="<?= $relatedEvent['image_url'] ?: BASE_URL . '/images/default-event.jpg' ?>" 
                                     alt="<?= htmlspecialchars($relatedEvent['title']) ?>">
                            </div>
                            <div class="related-event-content">
                                <h3>
                                    <a href="<?= BASE_URL ?>/events/show/<?= $relatedEvent['id'] ?>">
                                        <?= htmlspecialchars($relatedEvent['title']) ?>
                                    </a>
                                </h3>
                                <div class="related-event-date">
                                    <i class="fas fa-calendar"></i>
                                    <?= date('M j, Y', strtotime($relatedEvent['event_date'])) ?>
                                </div>
                                <div class="related-event-price">
                                    <?php if ($relatedEvent['price'] == 0): ?>
                                        <span class="price-free">Free</span>
                                    <?php else: ?>
                                        <span class="price-paid">৳<?= number_format($relatedEvent['price'], 2) ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Interest Modal -->
<div class="modal" id="interestModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Show Your Interest</h3>
            <button class="close-modal">&times;</button>
        </div>
        <div class="modal-body">
            <?php if (Session::isLoggedIn()): ?>
                <p>Great! We'll keep you updated about this event.</p>
                <form class="interest-form">
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="email_updates" checked>
                            Send me email updates about this event
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="similar_events">
                            Notify me about similar events in <?= htmlspecialchars($event['city']) ?>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-heart"></i> I'm Interested!
                    </button>
                </form>
            <?php else: ?>
                <p>Please log in to show interest in this event.</p>
                <div class="modal-actions">
                    <a href="<?= BASE_URL ?>/auth/login" class="btn btn-primary">Login</a>
                    <a href="<?= BASE_URL ?>/auth/register" class="btn btn-outline">Sign Up</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Share Modal -->
<div class="modal" id="shareModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Share This Event</h3>
            <button class="close-modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="share-options">
                <button class="share-btn facebook" onclick="shareToFacebook()">
                    <i class="fab fa-facebook-f"></i> Facebook
                </button>
                <button class="share-btn twitter" onclick="shareToTwitter()">
                    <i class="fab fa-twitter"></i> Twitter
                </button>
                <button class="share-btn whatsapp" onclick="shareToWhatsApp()">
                    <i class="fab fa-whatsapp"></i> WhatsApp
                </button>
                <button class="share-btn copy" onclick="copyEventUrl()">
                    <i class="fas fa-copy"></i> Copy Link
                </button>
            </div>
            
            <div class="share-url">
                <input type="text" readonly 
                       value="<?= BASE_URL ?>/events/show/<?= $event['id'] ?>"
                       id="eventUrl">
            </div>
        </div>
    </div>
</div>

<script>
// Event detail page JavaScript
const eventData = {
    id: <?= $event['id'] ?>,
    title: <?= json_encode($event['title']) ?>,
    url: '<?= BASE_URL ?>/events/show/<?= $event['id'] ?>',
    date: '<?= date('F j, Y', strtotime($event['event_date'])) ?>',
    city: <?= json_encode($event['city']) ?>
};

function showInterestModal() {
    document.getElementById('interestModal').style.display = 'flex';
}

function shareEvent() {
    document.getElementById('shareModal').style.display = 'flex';
}

function addToItinerary(eventId) {
    <?php if (Session::isLoggedIn()): ?>
        // TODO: Implement add to itinerary functionality
        showNotification('Feature coming soon! Event saved to your interests.', 'info');
    <?php else: ?>
        window.location.href = '<?= BASE_URL ?>/auth/login';
    <?php endif; ?>
}

function shareToFacebook() {
    const url = encodeURIComponent(eventData.url);
    const title = encodeURIComponent(eventData.title);
    window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank', 'width=600,height=400');
}

function shareToTwitter() {
    const url = encodeURIComponent(eventData.url);
    const text = encodeURIComponent(`Check out "${eventData.title}" in ${eventData.city} on ${eventData.date}!`);
    window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, '_blank', 'width=600,height=400');
}

function shareToWhatsApp() {
    const text = encodeURIComponent(`Check out "${eventData.title}" in ${eventData.city} on ${eventData.date}! ${eventData.url}`);
    window.open(`https://wa.me/?text=${text}`, '_blank');
}

function copyEventUrl() {
    const urlInput = document.getElementById('eventUrl');
    urlInput.select();
    document.execCommand('copy');
    showNotification('Event URL copied to clipboard!', 'success');
}

// Close modals
document.addEventListener('DOMContentLoaded', function() {
    const modals = document.querySelectorAll('.modal');
    const closeButtons = document.querySelectorAll('.close-modal');
    
    closeButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            this.closest('.modal').style.display = 'none';
        });
    });
    
    modals.forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.style.display = 'none';
            }
        });
    });
});
</script>

<?php
$content = ob_get_clean();
require VIEW_PATH . '/layouts/main.php';
?>