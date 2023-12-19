<?php
require __DIR__ . "/config/routes-config.php";
// header('Access-Control-Allow-Origin: *');
// header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
// header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
// header("Allow: GET, POST, OPTIONS, PUT, DELETE");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

$paths = ["users", "heart_rate"];
$index = 2;

if ((isset($uri[$index]) && !in_array($uri[$index], $paths)) || !isset($uri[$index + 1])) {
    header("HTTP/1.1 404 Not Found");
    exit();
}

require PROJECT_ROOT_PATH . "/Controller/Api/UserController.php";
require PROJECT_ROOT_PATH . "/Controller/Api/HeartRateController.php";
$requestMethod = $_SERVER["REQUEST_METHOD"];

// $file = fopen(PROJECT_ROOT_PATH . "/logs/logs.txt", "a");
// fwrite($file, "Nueva peticion" . PHP_EOL);
// fclose($file);

// if ($uri[$index] == "users") {
//     $objFeedController = new UserController();
//     $strMethodName = strtolower($requestMethod) . "_" . $uri[$index + 1] . '_action';
//     if ($requestMethod == 'GET') {
//         $objFeedController->{$strMethodName}();
//     } else if ($requestMethod == 'POST') {

//         $json = file_get_contents("php://input");
//         // echo $json;
//         $objFeedController->{$strMethodName}(json_decode($json));
//     }
// }

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
    echo $json;
    $objFeedController->{$strMethodName}(json_decode($json));
}
?>