<?php

namespace App\Applications\Models;

use App\Application\Cores\Model;

class Sample extends Model {
    public int $id;
	public string $name;
	public string $key;
	public string $languageName;
	public string $base;
	public int $ordered;
	

    public function toJSON(): array {
        return get_object_vars($this);
    }

    public function tableName(): string {
        return "audios";
    }

    public function rules(): array {
        return [
            'id' => "id",
		    'name' => "name",
			'key' => "key",
			'languageName' => "language_name",
			'base' => "base",
			'ordered' => "ordered",
			
        ];
    }    
}