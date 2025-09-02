<?php
require_once APP_PATH . '/controllers/BaseController.php';
require_once APP_PATH . '/models/User.php';

class AuthController extends BaseController {
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processLogin();
        } else {
            $this->loadView('auth/login');
        }
    }
    
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processRegistration();
        } else {
            $this->loadView('auth/register');
        }
    }
    
    public function logout() {
        Session::destroy();
        Session::setFlash('You have been logged out successfully', 'success');
        $this->redirect('/auth/login');
    }
    
    private function processLogin() {
        $email = $this->sanitize($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        
        if (empty($email) || empty($password)) {
            Session::setFlash('Please fill in all fields', 'error');
            $this->redirect('/auth/login');
            return;
        }
        
        $userModel = new User();
        $user = $userModel->findByEmail($email);
        
        if (!$user || !$userModel->verifyPassword($password, $user['password'])) {
            Session::setFlash('Invalid email or password', 'error');
            $this->redirect('/auth/login');
            return;
        }
        
        // Set session data
        Session::set('user_id', $user['id']);
        Session::set('username', $user['username']);
        Session::set('user_role', $user['role']);
        Session::set('full_name', $user['full_name']);
        
        Session::setFlash('Welcome back, ' . $user['full_name'] . '!', 'success');
        $this->redirect('/home');
    }
    
    private function processRegistration() {
        $data = [
            'username' => $this->sanitize($_POST['username'] ?? ''),
            'email' => $this->sanitize($_POST['email'] ?? ''),
            'password' => $_POST['password'] ?? '',
            'confirm_password' => $_POST['confirm_password'] ?? '',
            'full_name' => $this->sanitize($_POST['full_name'] ?? ''),
            'country' => $this->sanitize($_POST['country'] ?? ''),
            'phone' => $this->sanitize($_POST['phone'] ?? '')
        ];
        
        // Validation
        $errors = $this->validateRegistration($data);
        
        if (!empty($errors)) {
            Session::setFlash(implode('<br>', $errors), 'error');
            $this->redirect('/auth/register');
            return;
        }
        
        try {
            $userModel = new User();
            $userId = $userModel->create($data);
            
            Session::setFlash('Registration successful! Please log in.', 'success');
            $this->redirect('/auth/login');
            
        } catch (Exception $e) {
            Session::setFlash('Registration failed: ' . $e->getMessage(), 'error');
            $this->redirect('/auth/register');
        }
    }
    
    private function validateRegistration($data) {
        $errors = [];
        
        if (empty($data['username']) || strlen($data['username']) < 3) {
            $errors[] = 'Username must be at least 3 characters';
        }
        
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Valid email is required';
        }
        
        if (empty($data['password']) || strlen($data['password']) < 6) {
            $errors[] = 'Password must be at least 6 characters';
        }
        
        if ($data['password'] !== $data['confirm_password']) {
            $errors[] = 'Passwords do not match';
        }
        
        if (empty($data['full_name'])) {
            $errors[] = 'Full name is required';
        }
        
        // Check if email/username already exists
        $userModel = new User();
        if ($userModel->emailExists($data['email'])) {
            $errors[] = 'Email already exists';
        }
        
        if ($userModel->usernameExists($data['username'])) {
            $errors[] = 'Username already exists';
        }
        
        return $errors;
    }
}
?>