<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Exception;
use Illuminate\Foundation\Http\Middleware\TransformsRequest;
use Illuminate\Support\Facades\Log;

class JCryption extends TransformsRequest
{
    /**
     * The attributes that should not be trimmed.
     *
     * @var array
     */
    protected $except = [
        '_token',
        'nonce',
    ];

    /**
     * Transform the given value.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    protected function transform($key, $value)
    {
        if (in_array($key, $this->except, true)) {
            return $value;
        }
        if (is_string($value)) {
            $decrypted_text = $this->decrypt($key, $value);
            $value = preg_replace("/\r|\n/", "", $decrypted_text);
        }
        return $value;
    }

    protected function decrypt($key, $value)
    {
        $except = [
            'observacion',
            'espacios_coordinacion_ig_is',
            'm_espacios_coordinacion_ig_is',
            'detalles',
            'comentario'
        ];
        if (!(strrpos($key, 'id_respuesta') === false) || in_array($key, $except)) {
            return $value;
        }
        $private = config('site_vars.private');
        if (!$privateKey = openssl_pkey_get_private($private)) {
            Log::error('Loading Private Key failed');
            die('Loading Private Key failed');
        }
        $decrypted_text = "";
        if (!openssl_private_decrypt(base64_decode($value), $decrypted_text, $privateKey)) {
            Log::error('Failed to decrypt data: ' . $key);
            die('Failed to decrypt data');
        }
        $time = str_replace('a', '', substr($decrypted_text, 0, 16));
        $tiempoSession = Carbon::createFromTimestamp($time);
        $now = Carbon::now();
        if ($now->greaterThan($tiempoSession) && $now->diffInMinutes($tiempoSession) <= config('site_vars.time_token')) {
            Log::error('El token no es válido o esta vencido');
            die('El token no es válido o esta vencido para esta página');
        } 
        $decrypted = substr($decrypted_text, 16);
        return $decrypted;
    }
}
