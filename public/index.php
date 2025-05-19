<?php

define("ROOT_PATH", dirname(__DIR__) . '/app');
define("ROOT_PATH_UPLOAD", dirname(__DIR__) . '/public');
define("ROOT_URL", "http://localhost:8000/");
require_once ROOT_PATH . "/boostrap/required.php";

/**
 * Point d'entrée de l'application
 */
handle_request();
