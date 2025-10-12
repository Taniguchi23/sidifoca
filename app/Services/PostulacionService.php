<?php

namespace App\Services;

use App\Mail\RegistroPostulacionMail;
use App\Postulacion;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PostulacionService
{
    public function notificar($postulacion)
    {
        try {
            $postulacion = Postulacion::with([
                'contacto_postulacion',
                'categoria',
                'tema'
            ])
                ->find($postulacion->id_postulacion);
            $contacto_postulacion = $postulacion->contacto_postulacion;
            $notificacion = new RegistroPostulacionMail($postulacion);
            Mail::to($contacto_postulacion->email)->send($notificacion);
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
