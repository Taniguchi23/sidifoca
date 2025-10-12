<?php

namespace App\Repositories;

use App\TipoDocumento;

class TipoDocumentoRepository
{
    public function listar()
    {
        $lista = TipoDocumento::where('flg_estado', '=', true)
            ->orderBy('id_tipo_documento', 'asc')
            ->get();
        return $lista;
    }
}
