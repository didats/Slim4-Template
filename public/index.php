<?php
declare(strict_types=1);

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