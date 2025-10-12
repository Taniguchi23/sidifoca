<?php

namespace App\Traits;

use App\Libraries\AES256;
use Carbon\Carbon;

trait TokenTrait {
    public function generarToken()
    {
        $aes = new AES256();
        $hextime = dechex(time());
        $llave_simetrica = config('reniec.llave_simetrica');
        $token = $aes->encrypt($hextime, $llave_simetrica);
        $token = str_replace('/', '_', $token);
        return $token;
    }

    public function validarToken($token)
    {
        if (empty($token)) return false;
        $aes = new AES256();
        $llave_simetrica = config('reniec.llave_simetrica');
        $token = str_replace('_', '/', $token);
        $hexaDateTime  = $aes->decrypt($token, $llave_simetrica);
        $tiempoSession = Carbon::createFromTimestamp(hexdec($hexaDateTime));
        $now = Carbon::now();
        if ($now->greaterThan($tiempoSession) /*&& $now->diffInMinutes($tiempoSession) <= config('site_vars.time_reniec')*/) {
            return true;
        } 
        return false;
    }
}