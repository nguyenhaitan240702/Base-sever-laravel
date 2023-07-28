<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Crypt implements CastsAttributes
{

    public function get($model, string $key, $value, array $attributes)
    {
       \Illuminate\Support\Facades\Crypt::encrypt($value);
    }

    public function set($model, string $key, $value, array $attributes)
    {

        \Illuminate\Support\Facades\Crypt::decrypt($value);
    }
}
