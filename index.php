<?php
session_start();

require_once 'app/models/ProductModel.php';
require_once 'app/helpers/SessionHelper.php';

// API controllers
require_once 'app/controllers/ProductApiController.php';
require_once 'app/controllers/CategoryApiController.php';

// Xử lý URL
$url = $_GET['url'] ?? '';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// Xác định tên controller và action
$controllerName = isset($url[0]) && $url[0] !== '' ? ucfirst($url[0]) . 'Controller' : 'DefaultController';
$action = isset($url[1]) && $url[1] !== '' ? $url[1] : 'index';

// ✅ API controller riêng (ví dụ /api/product/...)
if ($controllerName === 'ApiController' && isset($url[1])) {
    $apiControllerName = ucfirst($url[1]) . 'ApiController';

    if (file_exists("app/controllers/{$apiControllerName}.php")) {
        require_once "app/controllers/{$apiControllerName}.php";
        $controller = new $apiControllerName();

        $method = $_SERVER['REQUEST_METHOD'];
        $id = $url[2] ?? null;

        switch ($method) {
            case 'GET':
                $action = $id ? 'show' : 'index';
                break;
            case 'POST':
                $action = 'store';
                break;
            case 'PUT':
                $action = $id ? 'update' : null;
                break;
            case 'DELETE':
                $action = $id ? 'destroy' : null;
                break;
            default:
                http_response_code(405);
                echo json_encode(['message' => 'Method Not Allowed']);
                exit;
        }

        if (method_exists($controller, $action)) {
            $id ? $controller->$action($id) : $controller->$action();
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Action not found']);
        }

        exit;
    } else {
        http_response_code(404);
        echo json_encode(['message' => 'API Controller not found']);
        exit;
    }
}

// ✅ Controller thông thường
$controllerFile = "app/controllers/{$controllerName}.php";
if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controller = new $controllerName();

    if (method_exists($controller, $action)) {
        call_user_func_array([$controller, $action], array_slice($url, 2));
    } else {
        die("⚠️ Action '{$action}' not found in {$controllerName}");
    }
} else {
    die("⚠️ Controller '{$controllerName}' not found.");
}
