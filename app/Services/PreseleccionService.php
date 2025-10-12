<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class PreseleccionService
{
    public function editar($id, $data)
    {
        try {
            $arr_calificacion = Session::get('arr_calificacion', []);
            $key = array_search($data['id_calificacion'], array_column($arr_calificacion, 'id_calificacion'));
            if ($key) {
                $arr_calificacion[$key] = $data;
                // [[id_calificacion=>1, puntaje=> 10, id=> 1], [id_calificacion=>1, puntaje=> 10]]
            } else {
                array_push(array_push($data, ['id' => $id]));
            }
            Session::put('arr_calificacion', $arr_calificacion);
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }
}
