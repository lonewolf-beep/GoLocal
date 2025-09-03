<?php
class Event {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    // Get all events with optional filters
    public function getAll($filters = []) {
        $sql = "SELECT e.*, u.full_name as creator_name 
                FROM events e 
                LEFT JOIN users u ON e.created_by = u.id 
                WHERE e.status = 'active'";
        $params = [];
        
        // Add city filter
        if (!empty($filters['city'])) {
            $sql .= " AND e.city = ?";
            $params[] = $filters['city'];
        }
        
        // Add date filter
        if (!empty($filters['date'])) {
            $sql .= " AND e.event_date = ?";
            $params[] = $filters['date'];
        }
        
        // Add date range filter
        if (!empty($filters['date_from'])) {
            $sql .= " AND e.event_date >= ?";
            $params[] = $filters['date_from'];
        }
        
        if (!empty($filters['date_to'])) {
            $sql .= " AND e.event_date <= ?";
            $params[] = $filters['date_to'];
        }
        
        // Add category filter
        if (!empty($filters['category'])) {
            $sql .= " AND e.category = ?";
            $params[] = $filters['category'];
        }
        
        // Add search query
        if (!empty($filters['search'])) {
            $sql .= " AND (e.title LIKE ? OR e.description LIKE ? OR e.city LIKE ?)";
            $searchTerm = '%' . $filters['search'] . '%';
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }
        
        // Add price filter
        if (isset($filters['free_only']) && $filters['free_only']) {
            $sql .= " AND e.price = 0";
        }
        
        // Add ordering
        $sql .= " ORDER BY ";
        if (!empty($filters['sort'])) {
            switch ($filters['sort']) {
                case 'date_asc':
                    $sql .= "e.event_date ASC, e.event_time ASC";
                    break;
                case 'date_desc':
                    $sql .= "e.event_date DESC, e.event_time DESC";
                    break;
                case 'price_asc':
                    $sql .= "e.price ASC";
                    break;
                case 'price_desc':
                    $sql .= "e.price DESC";
                    break;
                case 'title':
                    $sql .= "e.title ASC";
                    break;
                default:
                    $sql .= "e.featured DESC, e.event_date ASC, e.event_time ASC";
            }
        } else {
            $sql .= "e.featured DESC, e.event_date ASC, e.event_time ASC";
        }
        
        // Add pagination
        if (!empty($filters['limit'])) {
            $sql .= " LIMIT ?";
            $params[] = (int)$filters['limit'];
            
            if (!empty($filters['offset'])) {
                $sql .= " OFFSET ?";
                $params[] = (int)$filters['offset'];
            }
        }
        
        $stmt = $this->db->query($sql, $params);
        return $stmt->fetchAll();
    }
    
    // Get event by ID
    public function getById($id) {
        $sql = "SELECT e.*, u.full_name as creator_name 
                FROM events e 
                LEFT JOIN users u ON e.created_by = u.id 
                WHERE e.id = ?";
        $stmt = $this->db->query($sql, [$id]);
        return $stmt->fetch();
    }
    
    // Get featured events
    public function getFeatured($limit = 6) {
        $sql = "SELECT e.*, u.full_name as creator_name 
                FROM events e 
                LEFT JOIN users u ON e.created_by = u.id 
                WHERE e.featured = TRUE AND e.status = 'active' 
                AND e.event_date >= CURDATE()
                ORDER BY e.event_date ASC 
                LIMIT ?";
        $stmt = $this->db->query($sql, [$limit]);
        return $stmt->fetchAll();
    }
    
    // Get upcoming events
    public function getUpcoming($limit = 10) {
        $sql = "SELECT e.*, u.full_name as creator_name 
                FROM events e 
                LEFT JOIN users u ON e.created_by = u.id 
                WHERE e.status = 'active' AND e.event_date >= CURDATE()
                ORDER BY e.event_date ASC, e.event_time ASC 
                LIMIT ?";
        $stmt = $this->db->query($sql, [$limit]);
        return $stmt->fetchAll();
    }
    
    // Get events by city
    public function getByCity($city, $limit = null) {
        $sql = "SELECT e.*, u.full_name as creator_name 
                FROM events e 
                LEFT JOIN users u ON e.created_by = u.id 
                WHERE e.city = ? AND e.status = 'active' 
                AND e.event_date >= CURDATE()
                ORDER BY e.event_date ASC, e.event_time ASC";
        
        $params = [$city];
        if ($limit) {
            $sql .= " LIMIT ?";
            $params[] = $limit;
        }
        
        $stmt = $this->db->query($sql, $params);
        return $stmt->fetchAll();
    }
    
    // Get all cities with events
    public function getCities() {
        $sql = "SELECT DISTINCT city 
                FROM events 
                WHERE status = 'active' AND event_date >= CURDATE()
                ORDER BY city ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    
    // Get all categories
    public function getCategories() {
        $sql = "SELECT * FROM event_categories ORDER BY name ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    // Count events with filters
    public function countEvents($filters = []) {
        $sql = "SELECT COUNT(*) as total 
                FROM events e 
                WHERE e.status = 'active'";
        $params = [];
        
        // Apply same filters as getAll method
        if (!empty($filters['city'])) {
            $sql .= " AND e.city = ?";
            $params[] = $filters['city'];
        }
        
        if (!empty($filters['date'])) {
            $sql .= " AND e.event_date = ?";
            $params[] = $filters['date'];
        }
        
        if (!empty($filters['date_from'])) {
            $sql .= " AND e.event_date >= ?";
            $params[] = $filters['date_from'];
        }
        
        if (!empty($filters['date_to'])) {
            $sql .= " AND e.event_date <= ?";
            $params[] = $filters['date_to'];
        }
        
        if (!empty($filters['category'])) {
            $sql .= " AND e.category = ?";
            $params[] = $filters['category'];
        }
        
        if (!empty($filters['search'])) {
            $sql .= " AND (e.title LIKE ? OR e.description LIKE ? OR e.city LIKE ?)";
            $searchTerm = '%' . $filters['search'] . '%';
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }
        
        if (isset($filters['free_only']) && $filters['free_only']) {
            $sql .= " AND e.price = 0";
        }
        
        $stmt = $this->db->query($sql, $params);
        $result = $stmt->fetch();
        return $result['total'];
    }
    
    // Create new event (for future admin functionality)
    public function create($data) {
        $sql = "INSERT INTO events (title, description, short_description, city, venue, 
                event_date, event_time, end_date, category, price, image_url, 
                organizer, contact_phone, contact_email, website_url, created_by) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        try {
            $stmt = $this->db->query($sql, [
                $data['title'],
                $data['description'],
                $data['short_description'] ?? null,
                $data['city'],
                $data['venue'] ?? null,
                $data['event_date'],
                $data['event_time'] ?? null,
                $data['end_date'] ?? null,
                $data['category'],
                $data['price'] ?? 0.00,
                $data['image_url'] ?? null,
                $data['organizer'] ?? null,
                $data['contact_phone'] ?? null,
                $data['contact_email'] ?? null,
                $data['website_url'] ?? null,
                $data['created_by'] ?? null
            ]);
            return $this->db->getConnection()->lastInsertId();
        } catch (PDOException $e) {
            throw new Exception("Failed to create event: " . $e->getMessage());
        }
    }
    
    // Update event
    public function update($id, $data) {
        $sql = "UPDATE events SET title = ?, description = ?, short_description = ?, 
                city = ?, venue = ?, event_date = ?, event_time = ?, end_date = ?, 
                category = ?, price = ?, image_url = ?, organizer = ?, 
                contact_phone = ?, contact_email = ?, website_url = ?, 
                updated_at = CURRENT_TIMESTAMP 
                WHERE id = ?";
        
        try {
            $stmt = $this->db->query($sql, [
                $data['title'],
                $data['description'],
                $data['short_description'] ?? null,
                $data['city'],
                $data['venue'] ?? null,
                $data['event_date'],
                $data['event_time'] ?? null,
                $data['end_date'] ?? null,
                $data['category'],
                $data['price'] ?? 0.00,
                $data['image_url'] ?? null,
                $data['organizer'] ?? null,
                $data['contact_phone'] ?? null,
                $data['contact_email'] ?? null,
                $data['website_url'] ?? null,
                $id
            ]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            throw new Exception("Failed to update event: " . $e->getMessage());
        }
    }
    
    // Delete event
    public function delete($id) {
        $sql = "UPDATE events SET status = 'cancelled' WHERE id = ?";
        $stmt = $this->db->query($sql, [$id]);
        return $stmt->rowCount() > 0;
    }
    
    // Format date for display
    public function formatDate($date, $time = null) {
        $dateObj = new DateTime($date);
        $formatted = $dateObj->format('F j, Y');
        
        if ($time) {
            $timeObj = new DateTime($time);
            $formatted .= ' at ' . $timeObj->format('g:i A');
        }
        
        return $formatted;
    }
    
    // Format price for display
    public function formatPrice($price) {
        if ($price == 0) {
            return 'Free';
        }
        return '৳' . number_format($price, 2);
    }
}