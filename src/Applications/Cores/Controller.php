<?php
declare(strict_types=1);

namespace App\Applications\Core;

use App\Applications\Error\PostValidation;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Applications\Services\Database;
use App\Applications\Core\Format;
use App\Applications\Core\Setting;

class Controller {
    public Database $db;
    public Setting $setting;
    private $container;
    public Format $formatter;
    private PostValidation $validation;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->db = $this->container->get("db");
        $this->settings = $container->get("settings");
        $this->validation = new PostValidation();
        $this->formatter = new Format();
    }

    public function formatJSON(array $result, array $appended = [], bool $encoded = false) {
        $arr = [];
        $closure = function($item) use(&$arr, &$appended) {
            if (count($appended) > 0) {
                foreach($item as $key => $value) {
                    if(isset($appended[$key])) {
                        $item[$key] = $appended[$key].$value;
                    }
                }
            }
            
            array_push($arr, $item);
        };
        array_map($closure, $result);

        return ($encoded) ? json_encode($arr) : $arr;
    }

    public function toJSON(array $result, array $appended = [], bool $encoded = false) {
        $arr = [];
        $closure = function($item) use(&$arr, &$appended) {
            $itemData = $item->toJSON();
            if (count($appended) > 0) {
                foreach($itemData as $key => $value) {
                    if(isset($appended[$key])) {
                        $itemData[$key] = $appended[$key].$value;
                    }
                }
            }
            
            array_push($arr, $itemData);
        };
        array_map($closure, $result);

        return ($encoded) ? json_encode($arr) : $arr;
    }
}