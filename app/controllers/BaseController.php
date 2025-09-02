<?php
class BaseController {
    
    protected function loadView($view, $data = []) {
        extract($data);
        
        $viewFile = VIEW_PATH . '/' . $view . '.php';
        
        if (!file_exists($viewFile)) {
            die("View not found: $view");
        }
        
        require $viewFile;
    }
    
    protected function redirect($url) {
        header('Location: ' . BASE_URL . $url);
        exit;
    }
    
    protected function json($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    protected function sanitize($data) {
        if (is_array($data)) {
            return array_map([$this, 'sanitize'], $data);
        }
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }
}
?>