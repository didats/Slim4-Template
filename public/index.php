<?php
declare(strict_types=1);

use App\Applications\Error\HttpErrorHandler;
use App\Applications\Services\Database;
use App\Applications\Core\Setting;
use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Slim\Factory\ServerRequestCreatorFactory;
use Slim\ResponseEmitter;

require __DIR__."/../vendor/autoload.php";

/**
 * Public Index File
 * The main file that will configure all of the things
 * 
 * @author Didats Triadi <didats@gmail.com>
 */

$containerBuilder = new ContainerBuilder();
$container = $containerBuilder->build();

$container->set('settings', function() {
    $settings = require __DIR__.'/../app/settings.php';
    return new Setting($settings());
});

$container->set('db', function() use($container) {
    return new Database($container);
});

AppFactory::setContainer($container);
$app = AppFactory::create();
$callable = $app->getCallableResolver();

$routes = require __DIR__."/../app/routes.php";
$routes($app);

$app->addRoutingMiddleware();

$responseFactory = $app->getResponseFactory();
$errorHandler = new HttpErrorHandler($callable, $responseFactory);

$error = $app->addErrorMiddleware(false, false, false);
$error->setDefaultErrorHandler($errorHandler);

$serverRequestCreator = ServerRequestCreatorFactory::create();
$request = $serverRequestCreator->createServerRequestFromGlobals();

$response = $app->handle($request);
$responseEmitter = new ResponseEmitter();
$responseEmitter->emit($response);