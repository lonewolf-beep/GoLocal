<?php
ob_start();
?>

<!-- Events Header -->
<section class="events-header">
    <div class="container">
        <div class="events-hero">
            <h1><i class="fas fa-calendar-alt"></i> Events in Bangladesh</h1>
            <p>Discover amazing cultural festivals, concerts, workshops, and local celebrations</p>
        </div>
        
        <!-- Search Bar -->
        <div class="events-search">
            <form method="GET" class="search-form">
                <div class="search-input-group">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" placeholder="Search events, cities, or organizers..." 
                           value="<?= htmlspecialchars($filters['search'] ?? '') ?>">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Filters Section -->
<section class="events-filters">
    <div class="container">
        <form method="GET" class="filter-form" id="eventFilters">
            <!-- Preserve search term -->
            <?php if (!empty($filters['search'])): ?>
                <input type="hidden" name="search" value="<?= htmlspecialchars($filters['search']) ?>">
            <?php endif; ?>
            
            <div class="filters-row">
                <!-- City Filter -->
                <div class="filter-group">
                    <label for="city">
                        <i class="fas fa-map-marker-alt"></i>
                        City
                    </label>
                    <select name="city" id="city" onchange="this.form.submit()">
                        <option value="">All Cities</option>
                        <?php foreach ($cities as $city): ?>
                            <option value="<?= $city ?>" 
                                    <?= ($filters['city'] ?? '') === $city ? 'selected' : '' ?>>
                                <?= $city ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <!-- Category Filter -->
                <div class="filter-group">
                    <label for="category">
                        <i class="fas fa-tags"></i>
                        Category
                    </label>
                    <select name="category" id="category" onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['name'] ?>" 
                                    <?= ($filters['category'] ?? '') === $category['name'] ? 'selected' : '' ?>>
                                <?= $category['name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <!-- Date From -->
                <div class="filter-group">
                    <label for="date_from">
                        <i class="fas fa-calendar"></i>
                        From Date
                    </label>
                    <input type="date" name="date_from" id="date_from" 
                           value="<?= $filters['date_from'] ?? '' ?>"
                           min="<?= date('Y-m-d') ?>"
                           onchange="this.form.submit()">
                </div>
                
                <!-- Date To -->
                <div class="filter-group">
                    <label for="date_to">
                        <i class="fas fa-calendar-check"></i>
                        To Date
                    </label>
                    <input type="date" name="date_to" id="date_to" 
                           value="<?= $filters['date_to'] ?? '' ?>"
                           min="<?= date('Y-m-d') ?>"
                           onchange="this.form.submit()">
                </div>
                
                <!-- Sort -->
                <div class="filter-group">
                    <label for="sort">
                        <i class="fas fa-sort"></i>
                        Sort By
                    </label>
                    <select name="sort" id="sort" onchange="this.form.submit()">
                        <option value="">Featured First</option>
                        <option value="date_asc" <?= ($filters['sort'] ?? '') === 'date_asc' ? 'selected' : '' ?>>Date (Earliest)</option>
                        <option value="date_desc" <?= ($filters['sort'] ?? '') === 'date_desc' ? 'selected' : '' ?>>Date (Latest)</option>
                        <option value="price_asc" <?= ($filters['sort'] ?? '') === 'price_asc' ? 'selected' : '' ?>>Price (Low to High)</option>
                        <option value="price_desc" <?= ($filters['sort'] ?? '') === 'price_desc' ? 'selected' : '' ?>>Price (High to Low)</option>
                        <option value="title" <?= ($filters['sort'] ?? '') === 'title' ? 'selected' : '' ?>>Name (A-Z)</option>
                    </select>
                </div>
                
                <!-- Free Events Only -->
                <div class="filter-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="free_only" value="1" 
                               <?= isset($filters['free_only']) ? 'checked' : '' ?>
                               onchange="this.form.submit()">
                        <span class="checkmark"></span>
                        Free Events Only
                    </label>
                </div>
                
                <!-- Clear Filters -->
                <?php if (!empty(array_filter($filters))): ?>
                    <div class="filter-group">
                        <a href="<?= BASE_URL ?>/events" class="btn btn-outline">
                            <i class="fas fa-times"></i> Clear Filters
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </form>
    </div>
</section>

<!-- Results Section -->
<section class="events-results">
    <div class="container">
        <!-- Results Header -->
        <div class="results-header">
            <div class="results-info">
                <h2>
                    <?= $pagination['total_events'] ?> Event<?= $pagination['total_events'] !== 1 ? 's' : '' ?> Found
                    <?php if (!empty($filters['city'])): ?>
                        in <?= htmlspecialchars($filters['city']) ?>
                    <?php endif; ?>
                </h2>
                <?php if (!empty($filters['search'])): ?>
                    <p>Showing results for "<strong><?= htmlspecialchars($filters['search']) ?></strong>"</p>
                <?php endif; ?>
            </div>
            
            <div class="view-toggles">
                <button class="view-btn active" data-view="grid">
                    <i class="fas fa-th"></i>
                </button>
                <button class="view-btn" data-view="list">
                    <i class="fas fa-list"></i>
                </button>
            </div>
        </div>
        
        <!-- Events Grid -->
        <?php if (!empty($events)): ?>
            <div class="events-grid" id="eventsGrid">
                <?php foreach ($events as $event): ?>
                    <div class="event-card">
                        <div class="event-image">
                            <img src="<?= $event['image_url'] ?: BASE_URL . '/images/default-event.jpg' ?>" 
                                 alt="<?= htmlspecialchars($event['title']) ?>">
                            <div class="event-category">
                                <span class="category-tag category-<?= $event['category'] ?>">
                                    <?= ucfirst($event['category']) ?>
                                </span>
                            </div>
                            <?php if ($event['featured']): ?>
                                <div class="featured-badge">
                                    <i class="fas fa-star"></i> Featured
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="event-content">
                            <div class="event-date">
                                <i class="fas fa-calendar"></i>
                                <?= date('M j, Y', strtotime($event['event_date'])) ?>
                                <?php if ($event['event_time']): ?>
                                    <span class="event-time">
                                        at <?= date('g:i A', strtotime($event['event_time'])) ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <h3 class="event-title">
                                <a href="<?= BASE_URL ?>/events/show/<?= $event['id'] ?>">
                                    <?= htmlspecialchars($event['title']) ?>
                                </a>
                            </h3>
                            
                            <div class="event-location">
                                <i class="fas fa-map-marker-alt"></i>
                                <?= htmlspecialchars($event['city']) ?>
                                <?php if ($event['venue']): ?>
                                    - <?= htmlspecialchars($event['venue']) ?>
                                <?php endif; ?>
                            </div>
                            
                            <?php if ($event['short_description']): ?>
                                <p class="event-description">
                                    <?= htmlspecialchars($event['short_description']) ?>
                                </p>
                            <?php endif; ?>
                            
                            <div class="event-footer">
                                <div class="event-price">
                                    <?php if ($event['price'] == 0): ?>
                                        <span class="price-free">Free</span>
                                    <?php else: ?>
                                        <span class="price-paid">৳<?= number_format($event['price'], 2) ?></span>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="event-organizer">
                                    <?php if ($event['organizer']): ?>
                                        <small><i class="fas fa-user"></i> <?= htmlspecialchars($event['organizer']) ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="event-actions">
                                <a href="<?= BASE_URL ?>/events/show/<?= $event['id'] ?>" class="btn btn-primary">
                                    <i class="fas fa-info-circle"></i> View Details
                                </a>
                                <button class="btn btn-outline bookmark-btn" data-event-id="<?= $event['id'] ?>">
                                    <i class="far fa-bookmark"></i>
                                </button>
                                <button class="btn btn-outline share-btn" data-event-id="<?= $event['id'] ?>">
                                    <i class="fas fa-share"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Pagination -->
            <?php if ($pagination['total_pages'] > 1): ?>
                <div class="pagination">
                    <div class="pagination-info">
                        Showing page <?= $pagination['current_page'] ?> of <?= $pagination['total_pages'] ?>
                        (<?= $pagination['total_events'] ?> total events)
                    </div>
                    
                    <div class="pagination-nav">
                        <?php if ($pagination['has_prev']): ?>
                            <a href="?<?= http_build_query(array_merge($filters, ['page' => $pagination['prev_page']])) ?>" 
                               class="btn btn-outline">
                                <i class="fas fa-chevron-left"></i> Previous
                            </a>
                        <?php endif; ?>
                        
                        <!-- Page Numbers -->
                        <?php
                        $start_page = max(1, $pagination['current_page'] - 2);
                        $end_page = min($pagination['total_pages'], $pagination['current_page'] + 2);
                        ?>
                        
                        <?php if ($start_page > 1): ?>
                            <a href="?<?= http_build_query(array_merge($filters, ['page' => 1])) ?>" class="page-btn">1</a>
                            <?php if ($start_page > 2): ?>
                                <span class="pagination-dots">...</span>
                            <?php endif; ?>
                        <?php endif; ?>
                        
                        <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                            <a href="?<?= http_build_query(array_merge($filters, ['page' => $i])) ?>" 
                               class="page-btn <?= $i === $pagination['current_page'] ? 'active' : '' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>
                        
                        <?php if ($end_page < $pagination['total_pages']): ?>
                            <?php if ($end_page < $pagination['total_pages'] - 1): ?>
                                <span class="pagination-dots">...</span>
                            <?php endif; ?>
                            <a href="?<?= http_build_query(array_merge($filters, ['page' => $pagination['total_pages']])) ?>" 
                               class="page-btn"><?= $pagination['total_pages'] ?></a>
                        <?php endif; ?>
                        
                        <?php if ($pagination['has_next']): ?>
                            <a href="?<?= http_build_query(array_merge($filters, ['page' => $pagination['next_page']])) ?>" 
                               class="btn btn-outline">
                                Next <i class="fas fa-chevron-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
            
        <?php else: ?>
            <!-- No Events Found -->
            <div class="no-results">
                <div class="no-results-icon">
                    <i class="fas fa-calendar-times"></i>
                </div>
                <h3>No Events Found</h3>
                <p>We couldn't find any events matching your criteria. Try adjusting your filters or search terms.</p>
                <a href="<?= BASE_URL ?>/events" class="btn btn-primary">
                    <i class="fas fa-refresh"></i> View All Events
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Quick Filters (Mobile) -->
<div class="mobile-filters" id="mobileFilters">
    <div class="mobile-filters-content">
        <div class="mobile-filters-header">
            <h3>Filter Events</h3>
            <button class="close-filters">&times;</button>
        </div>
        <form method="GET" class="mobile-filter-form">
            <!-- Same filters as desktop but in mobile-friendly layout -->
        </form>
    </div>
</div>

<script>
// Events page JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // View toggle functionality
    const viewButtons = document.querySelectorAll('.view-btn');
    const eventsGrid = document.getElementById('eventsGrid');
    
    viewButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const view = this.dataset.view;
            
            // Update active button
            viewButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Update grid layout
            if (view === 'list') {
                eventsGrid.classList.add('events-list');
            } else {
                eventsGrid.classList.remove('events-list');
            }
        });
    });
    
    // Bookmark functionality
    const bookmarkBtns = document.querySelectorAll('.bookmark-btn');
    bookmarkBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const eventId = this.dataset.eventId;
            const icon = this.querySelector('i');
            
            // Toggle bookmark state
            if (icon.classList.contains('far')) {
                icon.classList.remove('far');
                icon.classList.add('fas');
                this.classList.add('bookmarked');
                // TODO: Save bookmark to user profile
            } else {
                icon.classList.remove('fas');
                icon.classList.add('far');
                this.classList.remove('bookmarked');
                // TODO: Remove bookmark from user profile
            }
        });
    });
    
    // Share functionality
    const shareBtns = document.querySelectorAll('.share-btn');
    shareBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const eventId = this.dataset.eventId;
            const eventUrl = `${window.location.origin}<?= BASE_URL ?>/events/show/${eventId}`;
            
            if (navigator.share) {
                navigator.share({
                    title: 'Check out this event on GoLocal',
                    url: eventUrl
                });
            } else {
                // Fallback: Copy to clipboard
                navigator.clipboard.writeText(eventUrl).then(() => {
                    showNotification('Event link copied to clipboard!', 'success');
                });
            }
        });
    });
});
</script>

<?php
$content = ob_get_clean();
require VIEW_PATH . '/layouts/main.php';
?>