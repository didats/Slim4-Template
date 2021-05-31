<?php
require("./vendor/autoload.php");

use Medoo\Medoo;

class Generators {
    public $db;

    public function __construct() {
        $setting = $this->settings();
        $this->db = new Medoo([
            'type' => 'mysql',
            'host' => $setting['db.host'],
            'database' => $setting['db.name'],
            'username' => $setting['db.user'],
            'password' => $setting['db.password'],
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_general_ci',
        ]);
    }

    private function settings(): array {
        $file = __DIR__."/.setting";
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
    }

    private function filterNames(string $name): string {
        $className = $name;

        // replace _ to spacing
        $className = str_replace("_", " ", $className);
        
        // remove s
        if(substr($name, -1) == "s") {
            $className = substr($name, 0, strlen($name) - 1);
        }

        // make it camel case
        $className = ucwords($className);
        $className = str_replace(" ", "", $className);

        return $className;
    }

    public function createModel(string $tableName) {
        $setting = $this->settings();
        $name = $this->filterNames($tableName);
        $dbname = $setting['db.name'];
        $query = "SELECT column_name, data_type FROM information_schema.columns WHERE table_schema = '$dbname' AND table_name = '$tableName'";
        $result = $this->db->query($query)->fetchAll();

        $declaration = "";
        $rules = "";
        $index = 0;
        foreach ($result as $item) {
            $fieldName = lcfirst($this->filterNames($item['COLUMN_NAME']));
            $type = ($item['DATA_TYPE'] != "int") ? "string" : "int";
            $declaration .= 'public '.$type.' $'.$fieldName.';'."\n\t";
            $rules .= '\''.$fieldName.'\' => "'.$item['COLUMN_NAME'].'",'."\n\t\t";

            if($index > 0) {
                $rules .= "\t";
            }

            $index++;
        }

        $str = '<?php

namespace App\Applications\Models;

use App\Application\Cores\Model;

class '.$name.' extends Model {
    '.$declaration.'

    public function toJSON(): array {
        return get_object_vars($this);
    }

    public function tableName(): string {
        return "'.$tableName.'";
    }

    public function rules(): array {
        return [
            '.$rules.'
        ];
    }    
}';
        $file = fopen(__DIR__."/src/Applications/Models/".$name.".php", "w+");
        if($file) {
            $put = fputs($file, $str);
            fclose($file);

            if($put) {
                echo "Successfully added";
            } else {
                echo "Nothing happen";
            }
        } else {
            echo "Failed creating file";
        }
        
    }
}

if (isset($argc)) {
    $type = $argv[1];
    $name = $argv[2];

    if(count($argv) == 3) {
        if($type == "model") {
            $generator = new Generators();
            $generator->createModel($name);
        }
    } else {
        echo "Failed";
    }

}