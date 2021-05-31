<?php
declare(strict_types=1);

namespace App\Applications\Middlewares;

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use App\Applications\Core\Setting;

class Token implements Middleware {

    private Container $container;

    public function __construct($app) {
        $this->container = $app->getContainer();
    }

    public function process(Request $request, RequestHandler $handler): Response {
        $pass = false;

        $setting = $this->container->get("settings");
        
        if(isset($_SERVER['App-Token'])) {
            $appToken = $_SERVER['App-Token'];
            
            if($appToken == $setting['app.token']) {
                return $handler->handle($request);
            }
        }

        if(!$pass) {
            $response = new \Slim\Psr7\Response();
            $response->getBody()->write(json_encode([
                'error' => 1,
                'status' => 500,
                'message' => "Unable to proceed without token",
                'detail' => []
            ]));
            return $response->withHeader('Content-Type', 'application/json');
        }
    }
}