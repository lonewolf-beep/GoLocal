<?php
require_once APP_PATH . '/controllers/BaseController.php';

class HomeController extends BaseController {
    
    public function index() {
        // Check if user is logged in for personalized content
        $isLoggedIn = Session::isLoggedIn();
        $username = Session::get('full_name', 'Guest');
        
        $data = [
            'isLoggedIn' => $isLoggedIn,
            'username' => $username,
            'pageTitle' => 'Discover Bangladesh Like a Local'
        ];
        
        $this->loadView('home/index', $data);
    }
    
    public function about() {
        $this->loadView('home/about', ['pageTitle' => 'About GoLocal']);
    }
}
?>