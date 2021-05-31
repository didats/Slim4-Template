<?php
declare(strict_types=1);

/**
 * Setting File
 * This file is extracting all the data from the configuration key
 * 
 * @author Didats Triadi <didats@gmail.com>
 */

return function(): array {
    $file = __DIR__."/../.settings";
    $fopen = fopen($file, "r");
    $arr = [];
    while(($buffer = fgets($fopen, 4096)) !== false) {
        preg_match_all("/([^ =]+)/", $buffer, $match);
        if(count($match) > 1) {
            $key = trim($match[0][0]);
            $value = trim($match[0][1]);
            $arr[$key] = $value;
        }
    }
    
    return $arr;
};