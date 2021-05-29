<?php

namespace App\Applications\Core;

use Psr\Http\Message\ResponseInterface;

class Format {
    public $hasError;
    public $statusCode = 200;
    public $message = "";
    public $data = [];
    private $response;

    public function __construct() {
        
    }

    private function rawJSON(): string {
        return json_encode([
            'error' => $this->hasError,
            'status' => $this->statusCode,
            'message' => $this->message,
            'detail' => $this->data
        ]);
    }

    public function json(): ResponseInterface {
        $response = $this->response;
        $response->getBody()->write($this->rawJSON());
        return $response->withHeader('Content-Type', 'application/json');
    }

    public static function generateJSON(array $data, bool $hasError = false, string $message = ""): string {
        $format = new Format();
        $format->hasError = ($hasError) ? 1 : 0;
        $format->data = $data;
        $format->message = $message;
        
        return $format->rawJSON();
    }

    public static function generate(ResponseInterface $response, bool $hasError, array $data = [], string $message = "", int $status = 200): ResponseInterface {
        $format = new Format();
        $format->response = $response;
        $format->hasError = $hasError;
        $format->data = $data;
        $format->message = $message;
        $format->statusCode = $status;
        return $format->json();
    }

    public function okay(ResponseInterface $response, array $data): ResponseInterface {
        $this->hasError = 0;
        $this->data = $data;
        $this->message = "";
        $raw = $this->rawJSON();

        $response->getBody()->write($raw);
        return $response->withHeader("Content-Type", "application/json");
    }

    public function failed(ResponseInterface $response, string $message): ResponseInterface {
        $this->hasError = 1;
        $this->message = $message;
        $raw = $this->rawJSON();
        
        $response->getBody()->write($raw);
        return $response->withHeader("Content-Type", "application/json");
    }
}