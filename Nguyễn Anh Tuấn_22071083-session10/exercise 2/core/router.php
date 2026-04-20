<?php
class Router {
    private array $routes = [];

    private function addRoute(string $method, string $uri, string $action): void {
        $this->routes[$method][$uri] = $action;
    }

    public function get(string $uri, string $action): void {
        $this->addRoute("GET", $uri, $action);
    }

    public function post(string $uri, string $action): void {
        $this->addRoute("POST", $uri, $action);
    }

    private function convertToRegex(string $route): string {
        // Thoát các ký tự đặc biệt của Regex nhưng giữ lại dấu ngoặc nhọn để xử lý tham số
        $quotedRoute = preg_quote($route, '#');
        $regex = preg_replace("/\\\\\{[^\\\\\}]+\\\\\}/", "([^/]+)", $quotedRoute);
        return "#^" . $regex . "$#";
    }

    private function extractParamNames(string $route): array {
        preg_match_all("/\{([^}]+)\}/", $route, $matches);
        return $matches[1];
    }

    private function callAction(string $action, array $params): void {
        [$controllerName, $method] = explode('@', $action);
        $controllerFile = "../app/controllers/{$controllerName}.php";

        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            if (class_exists($controllerName)) {
                $controller = new $controllerName();
                if (method_exists($controller, $method)) {
                    // Gọi method và truyền mảng tham số vào
                    call_user_func_array([$controller, $method], $params);
                } else {
                    die("Method {$method} không tồn tại trong class {$controllerName}");
                }
            } else {
                die("Class {$controllerName} không tìm thấy");
            }
        } else {
            die("File controller {$controllerFile} không tồn tại");
        }
    }

    private function abort(): void {
        http_response_code(404);
        echo "<div style='text-align: center; margin-top: 50px;'>
                <h1 style='color: red; font-family: Arial;'>404 Not Found</h1>
                <p>Trang bạn tìm kiếm không tồn tại.</p>
            </div>";
    }

    public function dispatch(string $requestURI, string $requestMethod): void {
        // Loại bỏ query string (ví dụ: ?id=1) để chỉ lấy đường dẫn thuần
        $requestURI = parse_url($requestURI, PHP_URL_PATH);

        if (!isset($this->routes[$requestMethod])) {
            $this->abort();
            return;
        }

        foreach ($this->routes[$requestMethod] as $route => $action) {
            $pattern = $this->convertToRegex($route);

            if (preg_match($pattern, $requestURI, $matches)) {
                // Xóa phần tử đầu tiên (full match) trong mảng matches
                array_shift($matches); 
                
                $paramNames = $this->extractParamNames($route);
                
                // Kết hợp tên tham số và giá trị từ URL thành mảng associative
                $params = [];
                if (!empty($paramNames)) {
                    $params = array_combine($paramNames, $matches);
                }

                $this->callAction($action, $params);
                return; // Quan trọng: Thoát hàm ngay khi tìm thấy route khớp
            }
        }

        // Nếu chạy hết vòng lặp mà không return, nghĩa là không tìm thấy route
        $this->abort();
    }
}
?>