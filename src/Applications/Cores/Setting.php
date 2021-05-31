<?php
declare(strict_types=1);

namespace App\Applications\Cores;

/**
 * Setting Class
 * The class to return value by sending a key
 * 
 * @author Didats Triadi <didats@gmail.com>
 */

class Setting {
    private $setting;

    public function __construct(array $setting){
        $this->setting = $setting;
    }

    public function get(string $key): string {
        return (isset($this->setting[$key])) ? $this->setting[$key] : "";
    }
}