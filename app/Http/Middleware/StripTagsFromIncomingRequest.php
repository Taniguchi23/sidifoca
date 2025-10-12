<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TransformsRequest as Middleware;

class StripTagsFromIncomingRequest extends Middleware
{
    /**
     * The names of the attributes that should not be stripped.
     *
     * @var array
     */
    protected $except = [
        'password',
        'password_confirmation',
    ];

    protected function transform($key, $value)
    {
        if (in_array($key, $this->except, true)) {
            return $value;
        }
        
        return is_string($value) && $value !== '' ? strip_tags($value) :  $value;
    }
}
