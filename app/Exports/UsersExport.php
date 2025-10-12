<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class UsersExport implements FromView, WithTitle
{
    public function title() : string
    {
        return 'administrados';
    }

    public function view(): View
    {
        $users = DB::select('call sp_usuario(:nro_documento)', [
            'nro_documento' => null
        ]);
        return view('usuario.exportar', [
            'users' => $users
        ]);
    }
}
