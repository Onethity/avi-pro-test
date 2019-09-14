<?php
use DI\Container;
use Slim\Factory\AppFactory;
use Aviprotest\Controller;
use Aviprotest\Controller\ApiController;

require __DIR__ . '/../vendor/autoload.php';

/**
 * Application dependencies
 */
$container = new Container();
AppFactory::setContainer($container);

$container->set('config', function () {
    return parse_ini_file(__DIR__ . '/../config.ini');
});

$container->set('pdo', function () use ($container) {
    $pdo = new \PDO('mysql:host=' . $container->get('config')['host'] . ';dbname=' . $container->get('config')['name'],
        $container->get('config')['user'],
        $container->get('config')['password'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    return $pdo;
});

$app = AppFactory::create();

/**
 * Application routes
 */
$app->get('/api/generate/', ApiController::class . ':generate');
$app->get('/api/retrieve/', ApiController::class . 'retrieve');


$app->run();