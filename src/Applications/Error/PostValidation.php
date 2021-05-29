<?php
declare(strict_types=1);

namespace App\Applications\Error;

use App\Applications\Core\Format;

class PostValidation {
    private $format;

    public function __construct() {
        $this->format = new Format();
    }

    public function validate(array $required, array $post): Validation {
        $validation = new Validation();
        foreach($required as $key) {
            if(!isset($post[$key])) {
                $validation->code = 0;
                $validation->message = "Field $key is required";
                break;
            } else {
                if (strlen($post[$key]) == 0) {
                    $validation->code = 0;
                    $validation->message = "Field $key is empty";
                    break;
                }
            }
        }

        return $validation;
    }
}

class Validation {
    public int $code = 1;
    public string $message = "";
}