<?php

namespace App\Http\Controllers;

use App\Repositories\ConcursoRepository;
use App\Traits\TokenTrait;
use Illuminate\Support\Facades\Storage;

class RegistroController extends Controller
{
    use TokenTrait; 
    
    protected $concurso;

    public function __construct(ConcursoRepository $concurso)
    {
        $this->concurso = $concurso;
    }

    public function index()
    {
        $concurso = $this->concurso->vigente();
        $token = $this->generarToken();
        if (empty($concurso)) {
            return view('registro.no-vigente');
        }
        return view('registro.index')->with([
            'concurso' => $concurso,
            'token' => $token
        ]);
    }

    public function basesConcurso($token)
    {
        /*if (!$this->validarToken($token)) {
            abort(521);
        }*/
        $bases_concurso = $this->concurso->basesConcursoVigente();
        if (empty($bases_concurso)) {
            abort(404);
        }
        $ext = pathinfo($bases_concurso, PATHINFO_EXTENSION);
        return Storage::download($bases_concurso, 'bases-concurso.' . $ext);
    }

    public function bpgActaAcuerdosColectivaVigente($token)
    {
        if (!$this->validarToken($token)) {
            abort(521);
        }
        $bpg_acta_acuerdos_colectiva = $this->concurso->bpgActaAcuerdosColectivaVigente();
        if (empty($bpg_acta_acuerdos_colectiva)) {
            abort(404);
        }
        $ext = pathinfo($bpg_acta_acuerdos_colectiva, PATHINFO_EXTENSION);
        return Storage::download($bpg_acta_acuerdos_colectiva, 'modelo-acuerdos-colectiva.' . $ext);
    }
}
