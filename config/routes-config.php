<?php
define("PROJECT_ROOT_PATH", __DIR__ . "/../");
// include main configuration file 
require_once PROJECT_ROOT_PATH . "/config/config.php";


/** *****************************************************
 *               Añadir los controladores               *
 ****************************************************** */
require_once PROJECT_ROOT_PATH . "/controller/Api/BaseController.php";
require PROJECT_ROOT_PATH . "/Controller/Api/UserController.php";
require PROJECT_ROOT_PATH . "/Controller/Api/HeartRateController.php";


/** *****************************************************
 *                  Añadir los modelos                  *
 ****************************************************** */
require_once PROJECT_ROOT_PATH . "/database/UserModel.php";
require_once PROJECT_ROOT_PATH . "/database/HeartRateModel.php";
require_once PROJECT_ROOT_PATH . "/database/HeartRateMeasuresModel.php";
require_once PROJECT_ROOT_PATH . "/database/QuestionaryModel.php";
?>