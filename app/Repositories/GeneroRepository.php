<?php

namespace App\Repositories;

use App\Genero;

class GeneroRepository
{
    public function listar()
    {
        $lista = Genero::where('flg_estado', '=', true)
            ->orderBy('id_genero', 'asc')
            ->get();
        return $lista;
    }
}
