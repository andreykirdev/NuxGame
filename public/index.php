<?php

require_once __DIR__ . '/../autoload.php';


use Controllers\PageAController;
use Controllers\RegistrationController;
use Routes\Router;

$router = new Router();

$router->addRoute('#^/$#', function() {
    (new RegistrationController())->showRegistrationForm();
});

$router->addRoute('#^/register$#', function() {
    (new RegistrationController())->registerUser();
});

$router->addRoute('#^/link/(\w+)$#', function($link) {
    (new PageAController())->handlePageA($link);
});

$router->addRoute('#^/generate$#', function() {
    (new PageAController())->generateNewLink();
});

$router->addRoute('#^/deactivate#', function() {
    (new PageAController())->deactivateLink();
});

$router->addRoute('#^/imfeelinglucky#', function() {
    (new PageAController())->imFeelingLucky();
});

$router->addRoute('#^/history#', function() {
    (new PageAController())->getHistory();
});

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router->dispatch($path);
