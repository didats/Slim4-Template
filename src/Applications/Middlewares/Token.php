<?php
declare(strict_types=1);

namespace App\Applications\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class Token implements Middleware {
    public function process(Request $request, RequestHandler $handler): Response {
        $pass = false;
        print($_SERVER['App-Token']);
        if(isset($_SERVER['App-Token'])) {
            $appToken = $_SERVER['App-Token'];
            if($appToken == "lskjadfljasdf34lkasdflj034ljafds") {
                return $handler->handle($request);
            }
        }

        if(!$pass) {
            $response = new \Slim\Psr7\Response();
            $response->getBody()->write(json_encode([
                'error' => 1,
                'status' => 200,
                'message' => "Unable to proceed without token",
                'detail' => []
            ]));
            return $response->withHeader('Content-Type', 'application/json');
        }
    }
}