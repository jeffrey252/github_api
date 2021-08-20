<?php

namespace App\Models\Abstracts;

abstract class Model
{
    public $fillable;

    public function __construct($data)
    {
        foreach ($data as $key => $value) {
            if (in_array($key, $this->fillable)) {
                $this->$key = $value;
            }
        }
    }
}
