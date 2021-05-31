<?php
declare(strict_types=1);

namespace App\Applications\Error;

use App\Applications\Core\Format;

class Validation {
    public function json(array $required): ValidationStatus {
        $data = json_decode(file_get_contents('php://input'), true);
        return $this->post($required, $data);
    }

    public function post(array $required, array $post): ValidationStatus {
        $validation = new ValidationStatus();
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

class ValidationStatus {
    public int $code = 1;
    public string $message = "";
}