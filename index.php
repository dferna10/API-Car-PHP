<?php
require __DIR__ . "/config/routes-config.php";
// header('Access-Control-Allow-Origin: *');
// header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
// header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
// header("Allow: GET, POST, OPTIONS, PUT, DELETE");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

$paths = ["users"];
$index = 2;

if ((isset($uri[$index]) && !in_array($uri[$index], $paths)) || !isset($uri[$index + 1])) {
    header("HTTP/1.1 404 Not Found");
    exit();
}

require PROJECT_ROOT_PATH . "/Controller/Api/UserController.php";
$requestMethod = $_SERVER["REQUEST_METHOD"];

$file = fopen(PROJECT_ROOT_PATH ."/logs/logs.txt", "a");

// fwrite($file, "Nueva peticion" . PHP_EOL);
// fwrite($file, "Valores post " . json_encode($_POST) . PHP_EOL);
// fwrite($file, "Username ".$_POST["username"] . PHP_EOL);
// fwrite($file, "Password: ".$_POST["password"] . PHP_EOL);
// // fwrite($file, "Otra más" . PHP_EOL);

fclose($file);
if ($uri[$index] == "users") {
    $objFeedController = new UserController();
    $strMethodName = strtolower($requestMethod) . "_" . $uri[$index + 1] . '_action';
    if ($requestMethod == 'GET') {
        $objFeedController->{$strMethodName}();
    } else if ($requestMethod == 'POST') {
        
        $json = file_get_contents("php://input");
        // echo $json;
        $objFeedController->{$strMethodName}(json_decode($json));
    }
}
?>