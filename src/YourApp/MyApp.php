<?php
declare(strict_types=1);

namespace App\YourApp;

use App\Applications\Core\Controller;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Your App File
 * This is where your app is belong to
 * 
 * @author Didats Triadi <didats@gmail.com>
 */

class MyApp extends Controller {
    public function index(ServerRequestInterface $request, ResponseInterface $response) {
        $data = [
            "item" => 1
        ];
        $result = $this->toJSON($data);
        return $this->formatter->okay($response, $result);
    }

    public function getID(ServerRequestInterface $request, ResponseInterface $response, string $id) {
        $data = [
            "id" => $id
        ];
        $result = $this->toJSON($data);
        return $this->formatter->okay($response, $result);
    }
}