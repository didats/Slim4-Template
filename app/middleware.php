<?php
declare(strict_types=1);

use Slim\App;
use App\Applications\Middleware\Token;

return function (App $app) {
    $app->add(Token::class);
};