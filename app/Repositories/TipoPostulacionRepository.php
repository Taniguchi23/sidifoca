<?php

namespace App\Repositories;

use App\TipoPostulacion;

class TipoPostulacionRepository
{
    public function listar()
    {
        $lista = TipoPostulacion::where('flg_estado', '=', true)
            ->orderBy('descripcion', 'asc')
            ->get();
        return $lista;
    } 
    
    public function filtrarPorModalidad($id_modalidad)
    {
        $lista = TipoPostulacion::where([
            ['id_modalidad', '=', $id_modalidad],
            ['flg_estado', '=', true]
        ])
            ->orderBy('descripcion', 'asc')
            ->get();
        return $lista;
    }
}
