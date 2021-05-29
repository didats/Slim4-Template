<?php
declare(strict_types=1);

namespace App\Applications\Services;

use Medoo\Medoo;
use DI\Container;

/**
 * Database Class
 * The database class that connects to Medoo
 * 
 * @author Didats Triadi <didats@gmail.com>
 */

class Database {
    
    private $debug = false;
    public $db;

    public function __construct(Container $container){
        $setting = $container->get("settings");
        
        $this->db = new Medoo([
            'type' => 'mysql',
            'host' => $setting->get('db.host'),
            'database' => $setting->get('db.name'),
            'username' => $setting->get('db.user'),
            'password' => $setting->get('db.password'),
            'charset' => 'utf8mb4',
	        'collation' => 'utf8mb4_general_ci',
        ]);

        if($this->debug) {
            $this->db = $this->db->debug();
        }
    }

    public function getError(): string {
        return "Error: ".$this->db->error."\n".print_r($this->db->errorInfo, true);
    }
}