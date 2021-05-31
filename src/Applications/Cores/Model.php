<?php

namespace App\Application\Cores;

use DI\Container;

class Model {
    public function toObject(string $className, array $dbData): object {
        if (method_exists($className, 'rules')) {
            $name = new $className();
            foreach($name->rules() as $key => $value) {
                if(isset($dbData[$value])) {
                    $name->$key = $dbData[$value];
                }
            }
            return $name;
        }

        return false;
    }
}