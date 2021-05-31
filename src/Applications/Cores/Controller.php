<?php
declare(strict_types=1);

namespace App\Applications\Cores;

use App\Applications\Error\PostValidation;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Applications\Services\Database;
use App\Applications\Cores\Format;
use App\Applications\Cores\Setting;
use App\Applications\Error\Validation;
use Medoo\Medoo;

class Controller {
    public Database $database;
    public Medoo $db;
    public Setting $setting;
    private $container;
    public Format $formatter;
    private Validation $validation;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->database = $this->container->get("db");
        $this->settings = $container->get("settings");
        $this->validation = new Validation();
        $this->formatter = new Format();
        $this->db = $this->database->db;
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