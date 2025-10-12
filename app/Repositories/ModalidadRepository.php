<?php

namespace App\Repositories;

use App\Modalidad;

class ModalidadRepository
{
    public function listar()
    {
        $lista = Modalidad::where('flg_estado', '=', true)
            ->orderBy('id_modalidad', 'asc')
            ->get();
        return $lista;
    }
}
