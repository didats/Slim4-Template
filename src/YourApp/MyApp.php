<?php
declare(strict_types=1);

namespace App\YourApp;

use App\Applications\Cores\Controller;
use App\Applications\Error\Validation;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Your App File
 * This is where your app is belong to
 * 
 * @author Didats Triadi <didats@gmail.com>
 */

/*

    Validation
    // 1. Create an array of required post variables
    $required = ["field_required", "another_field"];

    // Validation on post data
    $posts = $request->getParsedBody();
    $validation = new Validation($required);
    $status = $validation->post($posts);

    // If you somehow wanted to validate the JSON Raw:
    $status = $validation->json();

*/

class MyApp extends Controller {
    public function index(ServerRequestInterface $request, ResponseInterface $response) {
        $required = [
            'item', 'number'
        ];

        // getting the request POST
        // if the post is not there, then 
        $parsedBody = $request->getParsedBody();
        if(!is_array($parsedBody)) {
            $parsedBody = [];
        }

        $validation = new Validation($required);
        $status = $validation->post($parsedBody);
        
        if(!$status->code) {
            return $this->formatter->failed($response, $status->message);
        }

        return $this->formatter->okay($response, []);
    }

    public function getID(ServerRequestInterface $request, ResponseInterface $response, string $id) {
        $data = [
            "id" => $id
        ];
        
        return $this->formatter->okay($response, $data);
    }

    public function list(ServerRequestInterface $request, ResponseInterface $response) {
        /*
        To use to connect to the database, the Medoo object is at:
        $this->db;
        */
    }
}