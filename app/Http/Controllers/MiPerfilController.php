<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidacionContrasena;
use App\Http\Requests\ValidacionDatosInstitucionales;
use App\Http\Requests\ValidacionDatosPersonales;
use App\Repositories\AreaRepository;
use App\Repositories\ContratoRepository;
use App\Repositories\DreGreRepository;
use App\Repositories\EntidadExternaRepository;
use App\Repositories\GeneroRepository;
use App\Repositories\NivelEducativoRepository;
use App\Repositories\NivelPuestoRepository;
use App\Repositories\ProfesionRepository;
use App\Repositories\PuestoRepository;
use App\Repositories\RegimenLaboralRepository;
use App\Repositories\TipoDocumentoRepository;
use App\Repositories\TipoEntidadRepository;
use App\Repositories\UgelRepository;
use App\Repositories\UsuarioRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class MiPerfilController extends Controller
{
    protected $usuario;
    protected $contrato;
    protected $tipoDocumento;
    protected $genero;
    protected $tipoEntidad;
    protected $dreGre;
    protected $ugel;
    protected $entidadExterna;
    protected $nivelPuesto;
    protected $puesto;
    protected $area;
    protected $regimenLaboral;
    protected $nivelEducativo;
    protected $profesion;

    public function __construct(
        UsuarioRepository $usuario,
        ContratoRepository $contrato,
        TipoDocumentoRepository $tipoDocumento,
        GeneroRepository $genero,
        TipoEntidadRepository $tipoEntidad,
        DreGreRepository $dreGre,
        UgelRepository $ugel,
        EntidadExternaRepository $entidadExterna,
        NivelPuestoRepository $nivelPuesto,
        PuestoRepository $puesto,
        AreaRepository $area,
        RegimenLaboralRepository $regimenLaboral,
        NivelEducativoRepository $nivelEducativo,
        ProfesionRepository $profesion
    ) {
        $this->usuario = $usuario;
        $this->contrato = $contrato;
        $this->tipoDocumento =  $tipoDocumento;
        $this->genero = $genero;
        $this->tipoEntidad = $tipoEntidad;
        $this->dreGre = $dreGre;
        $this->ugel = $ugel;
        $this->entidadExterna = $entidadExterna;
        $this->nivelPuesto = $nivelPuesto;
        $this->puesto = $puesto;
        $this->area = $area;
        $this->regimenLaboral = $regimenLaboral;
        $this->nivelEducativo = $nivelEducativo;
        $this->profesion = $profesion;
    }

    public function index()
    {
        $usuario = $this->usuario->auth();
        if (empty($usuario)) {
            abort(404);
        }
        $usuario->flg_dni = $usuario->id_tipo_documento == config('constants.tipo_documento.dni');
        $usuario->flg_carnet_conadis = isset($usuario->url_carnet_conadis);
        $arr_tipo_documento = $this->tipoDocumento->listar();
        $arr_genero = $this->genero->listar();
        return view('mi-perfil.index')->with([
            'usuario' => $usuario,
            'arr_tipo_documento' => $arr_tipo_documento,
            'arr_genero' => $arr_genero
        ]);
    }

    public function grabar(ValidacionDatosPersonales $request)
    {
        $rpta = $this->usuario->update($request->only([
            'id_tipo_documento',
            'id_genero',
            'apellido_paterno',
            'apellido_materno',
            'nombres',
            'url_fotografia',
            'nro_documento',
            'fecha_nacimiento',
            'telefono_fijo',
            'telefono_celular',
            'email',
            'direccion',
            'flg_discapacidad',
            'url_carnet_conadis',
        ]));
        return response()->json($rpta);
    }

    public function editarContrato()
    {
        // MODIFICAR EN CASO LOS USUARIOS PUEDEN MODIFICAR CONTRATOS PASADOS
        $contrato = $this->contrato->vigente(auth()->id());
        if (empty($contrato)) {
            abort(404);
        }
        $arr_tipo_entidad = $this->tipoEntidad->listar();
        $arr_dre_gre = $this->dreGre->listar();
        $arr_ugel = $this->ugel->filtrarPorDreGre($contrato->id_dre_gre);
        $arr_entidad_externa = $this->entidadExterna->listar();
        $arr_nivel_puesto = $this->nivelPuesto->listar();
        $arr_area = $this->area->listar();
        $arr_puesto = $this->puesto->filtrarPorFiltro($contrato->id_tipo_entidad, $contrato->id_nivel_puesto);
        $arr_regimen_laboral = $this->regimenLaboral->listar();
        $arr_nivel_educativo = $this->nivelEducativo->listar();
        $arr_profesion = $this->profesion->listar();
        return view('mi-perfil.editar-contrato')->with([
            'contrato' => $contrato,
            'arr_tipo_entidad' => $arr_tipo_entidad,
            'arr_dre_gre' => $arr_dre_gre,
            'arr_ugel' => $arr_ugel,
            'arr_entidad_externa' => $arr_entidad_externa,
            'arr_nivel_puesto' => $arr_nivel_puesto,
            'arr_puesto' => $arr_puesto,
            'arr_area' => $arr_area,
            'arr_regimen_laboral' => $arr_regimen_laboral,
            'arr_nivel_educativo' => $arr_nivel_educativo,
            'arr_profesion' => $arr_profesion
        ]);
    }

    public function grabarContrato(ValidacionDatosInstitucionales $request)
    {
        // MODIFICAR EN CASO LOS USUARIOS PUEDEN MODIFICAR CONTRATOS PASADOS
        $rpta = $this->contrato->update($request->only([
            'id_tipo_entidad',
            'id_dre_gre',
            'id_ugel',
            'id_entidad_externa',
            'id_nivel_puesto',
            'id_puesto',
            'id_area',
            'id_regimen_laboral',
            'id_nivel_educativo',
            'id_profesion',
            'fecha_inicio',
            'fecha_fin',
            'url_documento',
            'flg_ejerce_cargo'
        ]));
        return response()->json($rpta);
    }

    public function editarContrasena()
    {
        $usuario = $this->usuario->auth();
        if (empty($usuario)) {
            abort(404);
        }
        return view('mi-perfil.editar-contrasena')->with('usuario', $usuario);
    }

    public function grabarContrasena(ValidacionContrasena $request)
    {
        $rpta = $this->usuario->passwd($request->only([
            'password'
        ]));
        if ($rpta['success']) {
            Auth::logoutOtherDevices($request->input('password'));
        }
        return response()->json($rpta);
    }

    public function listarUgel(Request $request)
    {
        $arr_ugel = $this->ugel->filtrarPorDreGre($request->get('id_dre_gre'));
        return response()->json($arr_ugel);
    }

    public function listarPuesto(Request $request)
    {
        $arr_puesto = $this->puesto->filtrarPorFiltro($request->get('id_tipo_entidad'), $request->get('id_nivel_puesto'));
        return response()->json($arr_puesto);
    }

    public function fotografia()
    {
        $fotografia = $this->usuario->fotografia(auth()->id());
        if (empty($fotografia)) {
            abort(404);
        }
        $ext = pathinfo($fotografia, PATHINFO_EXTENSION);
        return Storage::download($fotografia, 'fotografia.' . $ext);
    }

    public function carnetConadis()
    {
        $carnet_conadis = $this->usuario->carnetConadis(auth()->id());
        if (empty($carnet_conadis)) {
            abort(404);
        }
        $ext = pathinfo($carnet_conadis, PATHINFO_EXTENSION);
        return Storage::download($carnet_conadis, 'carnet-conadis.' . $ext);
    }

    public function documento()
    {
        // MODIFICAR EN CASO LOS USUARIOS PUEDEN MODIFICAR CONTRATOS PASADOS
        $contrato = $this->contrato->vigente(auth()->id());
        $documento = $this->contrato->documento($contrato->id_contrato);
        if (empty($documento)) {
            abort(404);
        }
        $ext = pathinfo($documento, PATHINFO_EXTENSION);
        return Storage::download($documento, 'contrato.' . $ext);
    }
}
