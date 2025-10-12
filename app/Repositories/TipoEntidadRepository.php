<?php

namespace App\Repositories;

use App\TipoEntidad;

class TipoEntidadRepository
{
    public function listar()
    {
        $lista = TipoEntidad::where('flg_estado', '=', true)
            ->orderBy('id_tipo_entidad', 'asc')
            ->get();
        return $lista;
    }
}
