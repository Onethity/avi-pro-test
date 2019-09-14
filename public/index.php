<?php
use DI\Container;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy; 
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
$app->addRoutingMiddleware();

/**
 * Error Handler
 */
$customErrorHandler = function (
    Slim\Psr7\Request $request,
    Throwable $exception,
    bool $displayErrorDetails,
    bool $logErrors,
    bool $logErrorDetails
) use ($app) {
    $payload = ['error' => $exception->getMessage()];

    $response = $app->getResponseFactory()->createResponse();
    $response->getBody()->write(
        json_encode($payload)
    );

    return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
};

// Add Error Middleware
$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware->setDefaultErrorHandler($customErrorHandler);


/**
 * Application routes
 */
$app->group('/api',  function (RouteCollectorProxy $group) { 
    $group->get('/generate/', ApiController::class . ':generate');
    $group->get('/retrieve/', ApiController::class . ':retrieve');
});

$app->run();
