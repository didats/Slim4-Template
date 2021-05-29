<?php
declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use Slim\Handlers\Strategies\RequestResponseArgs;



return function (App $app) {
    $routeCollector = $app->getRouteCollector();
    $routeCollector->setDefaultInvocationStrategy(new RequestResponseArgs());

    $app->get("/", function(Request $request, Response $response) {
        $response->getBody()->write("Nothing to see here");
        return $response;
    });

    $app->get("/hello/{name}", function(Request $request, Response $response, string $name) {
        $response->getBody()->write("Hello name: $name");
        return $response;
    });

    $app->post("/myapp", MyApp::class.':index');

    $app->group("/app", function(RouteCollectorProxy $group) {
        $group->get("/{id}", MyApp::class.':getID');
    });
};