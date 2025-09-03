<?php
require_once APP_PATH . '/controllers/BaseController.php';
require_once APP_PATH . '/models/Event.php';

class EventController extends BaseController {
    private $eventModel;
    
    public function __construct() {
        $this->eventModel = new Event();
    }
    
    // List all events with filtering
    public function index() {
        // Get filter parameters
        $filters = [
            'city' => $this->sanitize($_GET['city'] ?? ''),
            'category' => $this->sanitize($_GET['category'] ?? ''),
            'search' => $this->sanitize($_GET['search'] ?? ''),
            'date_from' => $this->sanitize($_GET['date_from'] ?? ''),
            'date_to' => $this->sanitize($_GET['date_to'] ?? ''),
            'sort' => $this->sanitize($_GET['sort'] ?? ''),
            'free_only' => isset($_GET['free_only']) ? true : false
        ];
        
        // Remove empty filters
        $filters = array_filter($filters, function($value) {
            return $value !== '' && $value !== false;
        });
        
        // Pagination
        $page = (int)($_GET['page'] ?? 1);
        $limit = 12; // Events per page
        $offset = ($page - 1) * $limit;
        
        $filters['limit'] = $limit;
        $filters['offset'] = $offset;
        
        // Get events and total count
        $events = $this->eventModel->getAll($filters);
        $totalEvents = $this->eventModel->countEvents($filters);
        $totalPages = ceil($totalEvents / $limit);
        
        // Get filter options
        $cities = $this->eventModel->getCities();
        $categories = $this->eventModel->getCategories();
        
        $data = [
            'events' => $events,
            'cities' => $cities,
            'categories' => $categories,
            'filters' => $_GET,
            'pagination' => [
                'current_page' => $page,
                'total_pages' => $totalPages,
                'total_events' => $totalEvents,
                'has_prev' => $page > 1,
                'has_next' => $page < $totalPages,
                'prev_page' => $page - 1,
                'next_page' => $page + 1
            ],
            'pageTitle' => 'Events in Bangladesh'
        ];
        
        $this->loadView('events/index', $data);
    }
    
    // Show single event details
    public function show() {
        // Get event ID from URL
        $uri = $_SERVER['REQUEST_URI'];
        $parts = explode('/', trim($uri, '/'));
        $eventId = end($parts);
        
        if (!is_numeric($eventId)) {
            $this->show404();
            return;
        }
        
        $event = $this->eventModel->getById($eventId);
        
        if (!$event) {
            $this->show404();
            return;
        }
        
        // Get related events (same city, different event)
        $relatedEvents = $this->eventModel->getByCity($event['city'], 4);
        $relatedEvents = array_filter($relatedEvents, function($e) use ($eventId) {
            return $e['id'] != $eventId;
        });
        $relatedEvents = array_slice($relatedEvents, 0, 3);
        
        $data = [
            'event' => $event,
            'relatedEvents' => $relatedEvents,
            'pageTitle' => $event['title'] . ' - Events'
        ];
        
        $this->loadView('events/show', $data);
    }
    
    // Search events (AJAX endpoint)
    public function search() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['error' => 'Invalid request method']);
            return;
        }
        
        $searchTerm = $this->sanitize($_POST['search'] ?? '');
        
        if (strlen($searchTerm) < 2) {
            $this->json(['events' => []]);
            return;
        }
        
        $filters = ['search' => $searchTerm, 'limit' => 10];
        $events = $this->eventModel->getAll($filters);
        
        // Format events for JSON response
        $formattedEvents = array_map(function($event) {
            return [
                'id' => $event['id'],
                'title' => $event['title'],
                'city' => $event['city'],
                'date' => $this->eventModel->formatDate($event['event_date'], $event['event_time']),
                'price' => $this->eventModel->formatPrice($event['price']),
                'category' => ucfirst($event['category']),
                'url' => BASE_URL . '/events/show/' . $event['id']
            ];
        }, $events);
        
        $this->json(['events' => $formattedEvents]);
    }
    
    // Get events by city (AJAX endpoint)
    public function getByCity() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['error' => 'Invalid request method']);
            return;
        }
        
        $city = $this->sanitize($_POST['city'] ?? '');
        
        if (empty($city)) {
            $this->json(['events' => []]);
            return;
        }
        
        $events = $this->eventModel->getByCity($city, 10);
        
        // Format events for JSON response
        $formattedEvents = array_map(function($event) {
            return [
                'id' => $event['id'],
                'title' => $event['title'],
                'venue' => $event['venue'],
                'date' => $this->eventModel->formatDate($event['event_date'], $event['event_time']),
                'price' => $this->eventModel->formatPrice($event['price']),
                'category' => ucfirst($event['category'])
            ];
        }, $events);
        
        $this->json(['events' => $formattedEvents]);
    }
    
    // Get featured events for homepage
    public function getFeatured() {
        $events = $this->eventModel->getFeatured(6);
        
        $formattedEvents = array_map(function($event) {
            return [
                'id' => $event['id'],
                'title' => $event['title'],
                'city' => $event['city'],
                'date' => $this->eventModel->formatDate($event['event_date']),
                'price' => $this->eventModel->formatPrice($event['price']),
                'image' => $event['image_url'] ?: '/public/images/default-event.jpg',
                'url' => BASE_URL . '/events/show/' . $event['id']
            ];
        }, $events);
        
        $this->json(['events' => $formattedEvents]);
    }
    
    private function show404() {
        http_response_code(404);
        $this->loadView('errors/404', ['pageTitle' => '404 - Event Not Found']);
    }
}