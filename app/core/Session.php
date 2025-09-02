<?php
class Session {
    
    public static function start() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }
    
    public static function get($key, $default = null) {
        return $_SESSION[$key] ?? $default;
    }
    
    public static function has($key) {
        return isset($_SESSION[$key]);
    }
    
    public static function remove($key) {
        unset($_SESSION[$key]);
    }
    
    public static function destroy() {
        session_destroy();
    }
    
    public static function isLoggedIn() {
        return self::has('user_id');
    }
    
    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit;
        }
    }
    
    public static function getUserId() {
        return self::get('user_id');
    }
    
    public static function getUserRole() {
        return self::get('user_role', 'user');
    }
    
    public static function setFlash($message, $type = 'info') {
        self::set('flash_message', $message);
        self::set('flash_type', $type);
    }
    
    public static function getFlash() {
        $message = self::get('flash_message');
        $type = self::get('flash_type', 'info');
        self::remove('flash_message');
        self::remove('flash_type');
        return $message ? ['message' => $message, 'type' => $type] : null;
    }
}
?>