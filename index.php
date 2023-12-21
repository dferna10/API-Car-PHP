<?php
require __DIR__ . "/config/routes-config.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

$paths = ["users", "heart_rate"];
$index = 2;

if ((isset($uri[$index]) && !in_array($uri[$index], $paths)) || !isset($uri[$index + 1])) {
    header("HTTP/1.1 404 Not Found");
    exit();
}

$requestMethod = $_SERVER["REQUEST_METHOD"];


switch ($uri[$index]) {
    case "users":
        $objFeedController = new UserController();
        break;
    case "heart_rate":
        $objFeedController = new HeartRateController();
        break;
}

$strMethodName = strtolower($requestMethod) . "_" . $uri[$index + 1] . '_action';
if ($requestMethod == 'GET') {
    $objFeedController->{$strMethodName}();
} else if ($requestMethod == 'POST') {

    $json = file_get_contents("php://input");
    // echo $json;
    $objFeedController->{$strMethodName}(json_decode($json));
}
?>