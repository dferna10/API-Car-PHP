<?php
require __DIR__ . "/config/routes-config.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

$paths = ["users"];
$index = 2;

if ((isset($uri[$index]) && !in_array($uri[$index], $paths)) || !isset($uri[$index + 1])) {
    header("HTTP/1.1 404 Not Found");
    exit();
}

require PROJECT_ROOT_PATH . "/Controller/Api/UserController.php";
if ($uri[$index] == "users") {
    $objFeedController = new UserController();
    $strMethodName = $uri[$index + 1] . 'Action';
    $objFeedController->{$strMethodName}();
}
?>