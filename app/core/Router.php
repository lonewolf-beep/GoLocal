<?php
class Router {
    private $routes = [];
    
    public function addRoute($path, $controller, $method) {
        $this->routes[$path] = ['controller' => $controller, 'method' => $method];
    }
    
    public function dispatch($uri) {
        // Remove query string and clean URI
        $uri = strtok($uri, '?');
        $uri = trim($uri, '/');
        
        // Default route
        if (empty($uri)) {
            $uri = 'home/index';
        }
        
        // Check for exact match
        if (isset($this->routes[$uri])) {
            return $this->callController($this->routes[$uri]);
        }
        
        // Parse URI for controller/method
        $parts = explode('/', $uri);
        $controllerName = ucfirst($parts[0]) . 'Controller';
        $methodName = $parts[1] ?? 'index';
        
        $this->callController([
            'controller' => $controllerName,
            'method' => $methodName
        ]);
    }
    
    private function callController($route) {
        $controllerFile = APP_PATH . '/controllers/' . $route['controller'] . '.php';
        
        if (!file_exists($controllerFile)) {
            $this->show404();
            return;
        }
        
        require_once $controllerFile;
        
        if (!class_exists($route['controller'])) {
            $this->show404();
            return;
        }
        
        $controller = new $route['controller']();
        
        if (!method_exists($controller, $route['method'])) {
            $this->show404();
            return;
        }
        
        $controller->{$route['method']}();
    }
    
    private function show404() {
        http_response_code(404);
        echo "404 - Page Not Found";
    }
}
?>