<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidacionRegimenLaboral;
use App\Repositories\RegimenLaboralRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegimenLaboralController extends Controller
{
    protected $regimenLaboral;

    public function __construct(RegimenLaboralRepository $regimenLaboral)
    {
        $this->regimenLaboral = $regimenLaboral;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rpta = $this->regimenLaboral->paginar($request->get('limit'), $request->only([
                'descripcion',
                'flg_estado'
            ]));
            return response()->json($rpta);
        }
        return view('regimen-laboral.index');
    }

    public function crear()
    {
        return view('regimen-laboral.crear');
    }

    public function guardar(ValidacionRegimenLaboral $request)
    {
        $rpta = $this->regimenLaboral->insertar($request->only([
            'descripcion'
        ]));
        return response()->json($rpta);
    }

    public function detalles($id)
    {
        $regimen_laboral = $this->regimenLaboral->obtener($id);
        if (empty($regimen_laboral)) {
            abort(404);
        }
        return view('regimen-laboral.detalles')->with('regimen_laboral', $regimen_laboral);
    }

    public function editar($id)
    {
        $regimen_laboral = $this->regimenLaboral->obtener($id);
        if (empty($regimen_laboral)) {
            abort(404);
        }
        return view('regimen-laboral.editar')->with('regimen_laboral', $regimen_laboral);
    }

    public function grabar(ValidacionRegimenLaboral $request, $id)
    {
        $rpta = $this->regimenLaboral->editar($id, $request->only([
            'descripcion',
            'flg_estado'
        ]));
        return response()->json($rpta);
    }
}
