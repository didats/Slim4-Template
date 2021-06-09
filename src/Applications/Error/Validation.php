<?php
declare(strict_types=1);

namespace App\Applications\Error;

class Validation {
    private array $required;

    public function __construct(array $required) {
        $this->required = $required;
    }

    public function json(): ValidationStatus {
        $data = json_decode(file_get_contents('php://input'), true);
        return $this->post($data);
    }

    public function post(array $post): ValidationStatus {
        $validation = new ValidationStatus();
        foreach($this->required as $key) {
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

class ValidationStatus {
    public int $code = 1;
    public string $message = "";
}