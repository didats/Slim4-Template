<?php
declare(strict_types=1);

namespace App\Application\Error;

use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpException;
use Slim\Exception\HttpMethodNotAllowedException;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpNotImplementedException;
use Slim\Exception\HttpUnauthorizedException;
use Slim\Interfaces\ErrorRendererInterface;
use Slim\Handlers\ErrorHandler as SlimErrorHandler;
use App\Applications\Core\Format;
use Throwable;

final class HttpErrorHandler extends SlimErrorHandler {
    protected function respond(): Response {
        $exception = $this->exception;
        $statusCode = 500;
        $error = new AppError($statusCode, "NOT_FOUND");

        if($exception instanceof HttpException) {
            $error->statusCode = $exception->getCode();
            $error->message = $exception->getMessage();

            if ($exception instanceof HttpNotFoundException) {
                $error->errorType = AppError::RESOURCE_NOT_FOUND;
            } else if($exception instanceof HttpMethodNotAllowedException) {
                $error->errorType = AppError::NOT_ALLOWED;
            } elseif ($exception instanceof HttpUnauthorizedException) {
                $error->errorType = AppError::UNAUTHENTICATED;
            } elseif ($exception instanceof HttpForbiddenException) {
                $error->errorType = AppError::INSUFFICIENT_PRIVILEGES;
            } elseif ($exception instanceof HttpBadRequestException) {
                $error->errorType = AppError::BAD_REQUEST;
            } elseif ($exception instanceof HttpNotImplementedException) {
                $error->errorType = AppError::NOT_IMPLEMENTED;
            }
            
            $response = $this->responseFactory->createResponse($error->statusCode);
            return Format::generate($response, true, [], $error->errorType, $error->statusCode);
        }
    }
}

class AppError {
    public const BAD_REQUEST = 'BAD_REQUEST';
    public const INSUFFICIENT_PRIVILEGES = 'INSUFFICIENT_PRIVILEGES';
    public const NOT_ALLOWED = 'NOT_ALLOWED';
    public const NOT_IMPLEMENTED = 'NOT_IMPLEMENTED';
    public const RESOURCE_NOT_FOUND = 'RESOURCE_NOT_FOUND';
    public const SERVER_ERROR = 'SERVER_ERROR';
    public const UNAUTHENTICATED = 'UNAUTHENTICATED';
    public const VALIDATION_ERROR = 'VALIDATION_ERROR';
    public const VERIFICATION_ERROR = 'VERIFICATION_ERROR';

    public $statusCode;
    public $errorType;
    public $message;

    public function __construct(int $status, string $type) {
        $this->statusCode = $status;
        $this->errorType = $type;
        $this->message = "";
    }
}