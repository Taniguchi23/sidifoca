<?php

namespace App\Services;

use App\Mail\NotificacionAdmisionMail;
use App\Mail\NotificacionCorregirMail;
use App\Mail\NotificacionRechazarMail;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AdmisionService
{
    protected $completo;
    protected $incompleto;
    protected $rechazado;

    public function __construct()
    {
        $this->completo = config('constants.estado.completo');
        $this->incompleto = config('constants.estado.incompleto');
        $this->rechazado = config('constants.estado.rechazado');
    }

    public function notificar($estado, $postulacion)
    {
        try {
            $contacto_postulacion = $postulacion->contacto_postulacion;
            switch ($estado) {
                case $this->completo:
                    $notificacion = new NotificacionAdmisionMail($postulacion);
                    break;
                case $this->incompleto:
                    $notificacion = new NotificacionCorregirMail($postulacion);
                    break;
                case $this->rechazado:
                    $notificacion = new NotificacionRechazarMail($postulacion);
                    break;
            }
            Mail::to($contacto_postulacion->email)->send($notificacion);
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
