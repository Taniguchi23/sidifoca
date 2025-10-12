<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidacionDirector;
use App\Http\Requests\ValidacionDNI;
use App\Http\Requests\ValidacionEnvioPostulacionColectiva;
use App\Http\Requests\ValidacionEquipoGobiernoLocal;
use App\Http\Requests\ValidacionEquipoPostulacion;
use App\Http\Requests\ValidacionPostulacionColectiva;
use App\Http\Requests\ValidacionReniec;
use App\Repositories\CargoRepository;
use App\Repositories\CategoriaRepository;
use App\Repositories\DimensionRepository;
use App\Repositories\DistritoRepository;
use App\Repositories\DreGreRepository;
use App\Repositories\GobiernoLocalRepository;
use App\Repositories\PostulacionColectivaRepository;
use App\Repositories\ProvinciaRepository;
use App\Repositories\ReniecRepository;
use App\Repositories\TemaRepository;
use App\Repositories\TipoPostulacionRepository;
use App\Repositories\UgelRepository;
use App\Repositories\UsuarioRepository;
use App\Services\PostulacionService;
use App\Traits\TokenTrait;
use Barryvdh\DomPDF\Facade as PDF;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ColectivaController extends Controller
{
    use TokenTrait;

    protected $postulacionColectiva;
    protected $tipoPostulacion;
    protected $gobiernoLocal;
    protected $dreGre;
    protected $ugel;
    protected $provincia;
    protected $distrito;
    protected $categoria;
    protected $tema;
    protected $dimension;
    protected $cargo;
    protected $usuario;
    protected $reniec;
    protected $postulacion;

    public function __construct(
        PostulacionColectivaRepository $postulacionColectiva,
        TipoPostulacionRepository $tipoPostulacion,
        GobiernoLocalRepository $gobiernoLocal,
        DreGreRepository $dreGre,
        UgelRepository $ugel,
        ProvinciaRepository $provincia,
        DistritoRepository $distrito,
        CategoriaRepository $categoria,
        TemaRepository $tema,
        DimensionRepository $dimension,
        CargoRepository $cargo,
        UsuarioRepository $usuario,
        ReniecRepository $reniec,
        PostulacionService $postulacion
    ) {
        $this->postulacionColectiva = $postulacionColectiva;
        $this->tipoPostulacion = $tipoPostulacion;
        $this->gobiernoLocal = $gobiernoLocal;
        $this->dreGre = $dreGre;
        $this->ugel = $ugel;
        $this->provincia = $provincia;
        $this->distrito = $distrito;
        $this->categoria = $categoria;
        $this->tema = $tema;
        $this->dimension = $dimension;
        $this->cargo = $cargo;
        $this->usuario = $usuario;
        $this->reniec = $reniec;
        $this->postulacion = $postulacion;
    }

    public function index()
    {
        return view('colectiva.index');
    }

    public function registrar()
    {
        $rpta = $this->postulacionColectiva->insertar();
        return response()->json($rpta);
    }

    public function editar($id)
    {
        $postulacion = $this->postulacionColectiva->obtener($id);
        if (empty($postulacion)) {
            abort(404);
        } else if ($postulacion->flg_editado) {
            $token = $this->generarToken();
            return view('colectiva.paso-2')->with([
                'postulacion' => $postulacion,
                'token' => $token
            ]);
        }
        $arr_tipo_postulacion = $this->tipoPostulacion->filtrarPorModalidad($postulacion->id_modalidad);
        $arr_gobierno_local = $this->gobiernoLocal->filtrarPorDreGre($postulacion->id_dre_gre);
        $arr_dre_gre = $this->dreGre->listar();
        $arr_ugel = $this->ugel->filtrarPorDreGre($postulacion->id_dre_gre);
        $arr_postulacion_ugel = $this->postulacionColectiva->ugeles($postulacion->id_postulacion);
        $arr_provincia = $this->provincia->filtrarPorDreGre($postulacion->id_dre_gre);
        $arr_postulacion_provincia = $this->postulacionColectiva->provincias($postulacion->id_postulacion);
        $arr_distrito = $this->distrito->filtrarPorPostulacion($postulacion->id_postulacion);
        $arr_postulacion_distrito = $this->postulacionColectiva->distritos($postulacion->id_postulacion);
        $arr_categoria = $this->categoria->listar();
        $arr_tema = $this->tema->filtrarPorCategoria($postulacion->id_categoria);
        $arr_mes = $this->listarMes();
        $arr_dia = $this->listarDia();
        $arr_director = $this->postulacionColectiva->listarDirector($postulacion->id_postulacion);
        return view('colectiva.registrar')->with([
            'postulacion' => $postulacion,
            'arr_tipo_postulacion' => $arr_tipo_postulacion,
            'arr_gobierno_local' => $arr_gobierno_local,
            'arr_dre_gre' => $arr_dre_gre,
            'arr_ugel' => $arr_ugel,
            'arr_postulacion_ugel' => $arr_postulacion_ugel,
            'arr_provincia' => $arr_provincia,
            'arr_postulacion_provincia' => $arr_postulacion_provincia,
            'arr_distrito' => $arr_distrito,
            'arr_postulacion_distrito' => $arr_postulacion_distrito,
            'arr_categoria' => $arr_categoria,
            'arr_tema' => $arr_tema,
            'arr_mes' => $arr_mes,
            'arr_dia' => $arr_dia,
            'arr_director' => $arr_director
        ]);
    }

    public function grabar(ValidacionPostulacionColectiva $request, $id)
    {
        $dataReniec = $this->reniec->consultar($request->get('c_nro_dni'));
        if ($dataReniec['success'] == false) {
            $dataReniec = null;
        }
        $data = $request->only([
            'id_tipo_postulacion',
            'id_dre_gre',
            'id_ugel',
            'buena_practica',
            'id_categoria',
            'id_tema',
            'nro_meses',
            'nro_dias',
            'id_gobierno_local_postulacion',
            'm_id_gobierno_local',
            'm_nombre_alcalde',
            'm_telefono',
            'm_email',
            'm_nro_resolucion_pdlc',
            'm_nro_resolucion_pei',
            'm_nro_resolucion_pel',
            'm_gerencia_oficina_area',
            'm_funcion_mof',
            'm_espacios_coordinacion_ig_is',
            'id_contacto_gobierno_local',
            'g_nombres',
            'g_telefono_celular',
            'g_email',
            'id_contacto_postulacion',
            'c_nro_dni',
            'c_nombres',
            'c_apellido_paterno',
            'c_apellido_materno',
            'c_telefono_fijo',
            'c_telefono_celular',
            'c_email'
        ]);
        if (empty($dataReniec)) {
            $data += ['flg_reniec' => false ];
        } else {
            $data += ['flg_reniec' => true ];

            $data['c_nombres'] = $dataReniec['data']->nombres;
            $data['c_apellido_paterno'] = $dataReniec['data']->apellido_paterno;
            $data['c_apellido_materno'] = $dataReniec['data']->apellido_materno;
        }
        $rpta = $this->postulacionColectiva->editar($id, $data);
        if ($rpta['success']) {
            $this->postulacion->notificar($rpta['data']);
        }
        return response()->json($rpta);
    }

    public function autosave(Request $request, $id)
    {
        $rpta = $this->postulacionColectiva->autosave($id, $request->only([
            'id_tipo_postulacion',
            'id_dre_gre',
            'id_ugel',
            'buena_practica',
            'id_categoria',
            'id_tema',
            'nro_meses',
            'nro_dias',
            'id_gobierno_local_postulacion',
            'm_id_gobierno_local',
            'm_nombre_alcalde',
            'm_telefono',
            'm_email',
            'm_nro_resolucion_pdlc',
            'm_nro_resolucion_pei',
            'm_nro_resolucion_pel',
            'm_gerencia_oficina_area',
            'm_funcion_mof',
            'm_espacios_coordinacion_ig_is',
            'id_contacto_gobierno_local',
            'g_nombres',
            'g_telefono_celular',
            'g_email',
            'id_contacto_postulacion',
            'c_nro_dni',
            'c_nombres',
            'c_apellido_paterno',
            'c_apellido_materno',
            'c_telefono_fijo',
            'c_telefono_celular',
            'c_email'
        ]));
        return response()->json($rpta);
    }

    public function ctrlDreGre(Request $request, $id)
    {
        $rpta = $this->postulacionColectiva->reiniciarZonaAlcanceUgel($id, $request->only([
            'id_dre_gre'
        ]));
        $arr_ugel = $this->ugel->filtrarPorDreGre($request->get('id_dre_gre'));
        $arr_provincia = $this->provincia->filtrarPorDreGre($request->get('id_dre_gre'));
        $arr_gobierno_local = $this->gobiernoLocal->filtrarPorDreGre($request->get('id_dre_gre'));
        return response()->json([
            'success' => $rpta['success'],
            'arr_ugel' => $arr_ugel,
            'arr_provincia' => $arr_provincia,
            'arr_gobierno_local' => $arr_gobierno_local
        ]);
    }

    public function agregarUgel(Request $request, $id)
    {
        $rpta = $this->postulacionColectiva->agregarUgel($id, $request->only([
            'id_ugel'
        ]));
        $arr_postulacion_ugel = $this->postulacionColectiva->ugeles($id);
        return response()->json([
            'success' => $rpta['success'],
            'arr_postulacion_ugel' => $arr_postulacion_ugel
        ]);
    }

    public function agregarProvincia(Request $request, $id)
    {
        $rpta = $this->postulacionColectiva->agregarProvincia($id, $request->only([
            'id_provincia'
        ]));
        $arr_postulacion_provincia = $this->postulacionColectiva->provincias($id);
        $arr_distrito = $this->distrito->filtrarPorPostulacion($id);
        return response()->json([
            'success' => $rpta['success'],
            'arr_postulacion_provincia' => $arr_postulacion_provincia,
            'arr_distrito' => $arr_distrito
        ]);
    }

    public function agregarDistrito(Request $request, $id)
    {
        $rpta = $this->postulacionColectiva->agregarDistrito($id, $request->only([
            'id_distrito'
        ]));
        $arr_postulacion_distrito = $this->postulacionColectiva->distritos($id);
        return response()->json([
            'success' => $rpta['success'],
            'arr_postulacion_distrito' => $arr_postulacion_distrito
        ]);
    }

    public function eliminarUgel(Request $request, $id)
    {
        $rpta = $this->postulacionColectiva->eliminarUgel($id, $request->only([
            'id_postulacion_ugel'
        ]));
        $arr_postulacion_ugel = $this->postulacionColectiva->ugeles($id);
        return response()->json([
            'success' => $rpta['success'],
            'arr_postulacion_ugel' => $arr_postulacion_ugel
        ]);
    }

    public function eliminarProvincia(Request $request, $id)
    {
        $rpta = $this->postulacionColectiva->eliminarProvincia($id, $request->only([
            'id_postulacion_provincia'
        ]));
        $arr_distrito = $this->distrito->filtrarPorPostulacion($id);
        return response()->json([
            'success' => $rpta['success'],
            'arr_distrito' => $arr_distrito
        ]);
    }

    public function eliminarDistrito(Request $request, $id)
    {
        $rpta = $this->postulacionColectiva->eliminarDistrito($id, $request->only([
            'id_postulacion_distrito'
        ]));
        return response()->json($rpta);
    }

    public function listarTema(Request $request)
    {
        $arr_tema = $this->tema->filtrarPorCategoria($request->get('id_categoria'));
        return response()->json($arr_tema);
    }

    public function listarMes()
    {
        $arr_mes = [];
        for ($i = 6; $i < 37; $i++) {
            array_push($arr_mes, ['id_mes' => $i, 'descripcion' => $i . ' meses']);
        }
        return $arr_mes;
    }

    public function listarDia()
    {
        $arr_dia = [];
        for ($i = 6; $i < 30; $i++) {
            array_push($arr_dia, ['id_dia' => $i, 'descripcion' => $i . ' dias']);
        }
        return $arr_dia;
    }
    
    public function editarRespuesta(Request $request, $id)
    {
        $rpta = $this->postulacionColectiva->editarRespuesta($id, $request->only([
            'id_respuesta',
            'descripcion'
        ]));
        return response()->json($rpta);
    }

    public function listarDirector($id)
    {
        $arr_director = $this->postulacionColectiva->listarDirector($id);
        $arr_equipo_postulacion = $this->postulacionColectiva->listarEquipoPostulacion($id);
        // HACK MEJORAR EN ER DB
        foreach ($arr_director as $director) {
            $director->arr_equipo_postulacion = [];
            foreach ($arr_equipo_postulacion as $equipo_postulacion) {
                if ($equipo_postulacion->id_dre_gre == $director->id_dre_gre && $equipo_postulacion->id_ugel == $director->id_ugel) {
                    array_push($director->arr_equipo_postulacion, $equipo_postulacion);
                }
            }
        }
        return view('colectiva.listar-director')->with([
            'arr_director' => $arr_director
        ]);
    }

    public function agregarDirector($id)
    {
        $postulacion = $this->postulacionColectiva->obtener($id);
        $arr_dre_gre = $this->postulacionColectiva->listarDreGre($postulacion->id_postulacion);
        $arr_postulacion_ugel = $this->postulacionColectiva->ugeles($postulacion->id_postulacion);
        return view('colectiva.agregar-director')->with([
            'postulacion' => $postulacion,
            'arr_dre_gre' => $arr_dre_gre,
            'arr_postulacion_ugel' => $arr_postulacion_ugel
        ]);
    }

    public function guardarDirector(ValidacionDirector $request, $id)
    {
        $dataReniec = $this->reniec->consultar($request->get('d_nro_dni'));
        if ($dataReniec['success'] == false) {
            $dataReniec = null;
        }
        $data = $request->only([
            'd_id_dre_gre',
            'd_id_ugel',
            'd_nro_dni',
            'd_nombres',
            'd_apellido_paterno',
            'd_apellido_materno',
            'd_telefono_fijo',
            'd_telefono_celular',
            'd_email'
        ]);
        if (empty($dataReniec)) {
            $data += ['flg_reniec' => false ];
        } else {
            $data += ['flg_reniec' => true ];
            $data['d_nombres'] = $dataReniec['data']->nombres;
            $data['d_apellido_paterno'] = $dataReniec['data']->apellido_paterno;
            $data['d_apellido_materno'] = $dataReniec['data']->apellido_materno;
        }
        $rpta = $this->postulacionColectiva->agregarDirector($id, $data);
        return response()->json($rpta);
    }

    public function eliminarDirector(Request $request, $id)
    {
        $rpta = $this->postulacionColectiva->eliminarDirector($id, $request->only([
            'id_director'
        ]));
        return response()->json($rpta);
    }

    public function listarEquipoGobiernoLocal($id)
    {
        $arr_equipo_gobierno_local = $this->postulacionColectiva->listarEquipoGobiernoLocal($id);
        return response()->json($arr_equipo_gobierno_local);
    }

    public function agregarEquipoGobiernoLocal($id)
    {
        $arr_cargo = $this->cargo->externo();
        return view('colectiva.agregar-equipo-gobierno-local')->with([
            'id_postulacion' => $id,
            'arr_cargo' => $arr_cargo
        ]);
    }

    public function guardarEquipoGobiernoLocal(ValidacionEquipoGobiernoLocal $request, $id)
    {
        $dataReniec = $this->reniec->consultar($request->get('p_nro_dni'));
        if ($dataReniec['success'] == false) {
            $dataReniec = null;
        }
        $data = $request->only([
            'p_id_cargo',
            'p_nro_dni',
            'p_nombres',
            'p_apellido_paterno',
            'p_apellido_materno',
            'p_telefono',
            'p_email'
        ]);
        if (empty($dataReniec)) {
            $data += ['flg_reniec' => false ];
        } else {
            $data += ['flg_reniec' => true ];
        
            $data['p_nombres'] = $dataReniec['data']->nombres;
            $data['p_apellido_paterno'] = $dataReniec['data']->apellido_paterno;
            $data['p_apellido_materno'] = $dataReniec['data']->apellido_materno;
        }
        $rpta = $this->postulacionColectiva->agregarEquipoGobiernoLocal($id, $data);
        return response()->json($rpta);
    }

    public function eliminarEquipoGobiernoLocal(Request $request, $id)
    {
        $rpta = $this->postulacionColectiva->eliminarEquipoGobiernoLocal($id, $request->only([
            'id_equipo_gobierno_local'
        ]));
        return response()->json($rpta);
    }

    public function listarEquipoPostulacion($id)
    {
        $arr_equipo_postulacion = $this->postulacionColectiva->listarEquipoPostulacion($id);
        return response()->json($arr_equipo_postulacion);
    }

    public function agregarEquipoPostulacion(Request $request, $id)
    {
        $arr_cargo = $this->cargo->soloUgel();
        return view('colectiva.agregar-equipo-postulacion')->with([
            'id_postulacion' => $id,
            'id_director' => $request->get('id_director'),
            'arr_cargo' => $arr_cargo
        ]);
    }

    public function guardarEquipoPostulacion(ValidacionEquipoPostulacion $request, $id)
    {
        $dataReniec = $this->reniec->consultar($request->get('p_nro_dni'));
        if ($dataReniec['success'] == false) {
            $dataReniec = null;
        }
        $data = $request->only([
            'p_id_director',
            'p_id_cargo',
            'p_nro_dni',
            'p_nombres',
            'p_apellido_paterno',
            'p_apellido_materno',
            'p_telefono',
            'p_email'
        ]);
        if (empty($dataReniec)) {
            $data += ['flg_reniec' => false ];
        } else {
            $data += ['flg_reniec' => true ];
        
            $data['p_nombres'] = $dataReniec['data']->nombres;
            $data['p_apellido_paterno'] = $dataReniec['data']->apellido_paterno;
            $data['p_apellido_materno'] = $dataReniec['data']->apellido_materno;
        }
        $rpta = $this->postulacionColectiva->agregarEquipoPostulacion($id, $data);
        return response()->json($rpta);
    }

    public function eliminarEquipoPostulacion(Request $request, $id)
    {
        $rpta = $this->postulacionColectiva->eliminarEquipoPostulacion($id, $request->only([
            'id_equipo_postulacion'
        ]));
        return response()->json($rpta);
    }

    public function captcha()
    {
        return response()->json(['success' => true, 'data' => captcha_src('flat')]);
    }

    public function adjuntar($id)
    {
        $postulacion = $this->postulacionColectiva->obtener($id);
        if (empty($postulacion)) {
            abort(404);
        } elseif (!$postulacion->flg_editado) {
            return view('colectiva.index')->withErrors(['*' => 'Paso 3: Código de postulación no encontrado.']);
        } elseif ($postulacion->flg_enviado) {
            return view('colectiva.paso-3')->with('postulacion', $postulacion);
        }
        return view('colectiva.adjuntar')->with('postulacion', $postulacion);
    }

    public function enviar(ValidacionEnvioPostulacionColectiva $request, $id)
    {
        $rpta = $this->postulacionColectiva->enviar($id, $request->only([
            'url_declaracion_representante',
            'url_declaracion_equipo',
            'url_acta_modalidad_colectiva',
            'url_documento_imagen',
            'url_video'
        ]));
        return response()->json($rpta);
    }

    public function codigo(Request $request)
    {
        $postulacion = $this->postulacionColectiva->codigo($request->get('codigo'));
        return response()->json([
            'success' => isset($postulacion),
            'data' => $postulacion
        ]);
    }

    public function representantePostulacion($id, $token)
    {
        if (!$this->validarToken($token)) {
            abort(521);
        }
        $arr_director = $this->postulacionColectiva->listarDirector($id);
        if (empty($arr_director)) {
            abort(404);
        }
        $pdf = PDF::loadView('colectiva.representante-postulacion', [
            'arr_director' => $arr_director
        ]);
        return $pdf->download('representante-postulacion.pdf');
    }

    public function equipoTecnicoPostulacion($id, $token)
    {
        if (!$this->validarToken($token)) {
            abort(521);
        }
        $arr_director = $this->postulacionColectiva->listarDirector($id);
        $arr_equipo_postulacion = $this->postulacionColectiva->listarEquipoPostulacion($id);
        // SE PUEDE OPTIMIZAR EN ER DB
        foreach ($arr_director as $director) {
            $director->arr_equipo_postulacion = collect();
            foreach ($arr_equipo_postulacion as $equipo_postulacion) {
                if ($equipo_postulacion->id_dre_gre == $director->id_dre_gre && $equipo_postulacion->id_ugel == $director->id_ugel) {
                    $director->arr_equipo_postulacion->push($equipo_postulacion);
                }
            }
            $director->arr_equipo_postulacion = $director->arr_equipo_postulacion->chunk(2);
        }
        $pdf = PDF::loadView('colectiva.equipo-tecnico-postulacion', [
            'arr_director' => $arr_director,
            //'arr_equipo_postulacion' => $arr_equipo_postulacion
        ]);
        return $pdf->download('equipo-tecnico-postulacion.pdf');
    }

    public function equipoGobiernoPostulacion($id, $token)
    {
        if (!$this->validarToken($token)) {
            abort(521);
        }
        $postulacion = $this->postulacionColectiva->obtener($id);
        if (empty($postulacion)) {
            abort(404);
        }
        $arr_equipo_gobierno_postulacion = $this->postulacionColectiva->listarEquipoGobiernoLocal($id);
        $pdf = PDF::loadView('colectiva.equipo-gobierno-postulacion', [
            'postulacion' => $postulacion,
            'arr_equipo_postulacion' => $arr_equipo_gobierno_postulacion->chunk(2)
        ]);
        return $pdf->download('equipo-gobierno-postulacion.pdf');
    }

    public function reniec(ValidacionDNI $request)
    {
        $usuario = $this->usuario->consultar($request->input('nro_dni'));
        if (empty($usuario)) {
            $rpta = $this->reniec->consultar2($request->input('nro_dni'));
        } else {
            $rpta =[
                'success' => true,
                'data' => $usuario,
                'msg' => 'Datos consultados desde DIFOCA.'
            ];
        }
        if ($rpta['success']) {
            $pem = config('site_vars.pem');
            if (!$publicKey = openssl_pkey_get_public($pem)) {
                Log::error('Loading Public Key failed');
                die('Loading Public Key failed');
            }
            
            $encrypted_id_tipo_documento = "";
            $encrypted_nro_documento = "";
            $encrypted_apellido_paterno = "";
            $encrypted_apellido_materno = "";
            $encrypted_nombres = "";
            $encrypted_fecha_nacimiento = "";
            $encrypted_direccion = "";
            $encrypted_id_genero = "";
            
            try {
                openssl_public_encrypt($rpta['data']->id_tipo_documento, $encrypted_id_tipo_documento, $publicKey);
                openssl_public_encrypt($rpta['data']->nro_documento, $encrypted_nro_documento, $publicKey);
                openssl_public_encrypt($rpta['data']->apellido_paterno, $encrypted_apellido_paterno, $publicKey);
                openssl_public_encrypt($rpta['data']->apellido_materno, $encrypted_apellido_materno, $publicKey);
                openssl_public_encrypt($rpta['data']->nombres, $encrypted_nombres, $publicKey);
                openssl_public_encrypt($rpta['data']->fecha_nacimiento, $encrypted_fecha_nacimiento, $publicKey);
                openssl_public_encrypt($rpta['data']->direccion, $encrypted_direccion, $publicKey);
                openssl_public_encrypt($rpta['data']->id_genero, $encrypted_id_genero, $publicKey);
            } catch (Exception $e) {
                Log::error('Failed to encryp data' . $e);
                die('Failed to encryp data');
            }
            
            $encrypted_data = [];
            $encrypted_data['id_tipo_documento'] = base64_encode($encrypted_id_tipo_documento);
            $encrypted_data['nro_documento']     = base64_encode($encrypted_nro_documento);
            $encrypted_data['apellido_paterno']  = base64_encode($encrypted_apellido_paterno);
            $encrypted_data['apellido_materno']  = base64_encode($encrypted_apellido_materno);
            $encrypted_data['nombres']          = base64_encode($encrypted_nombres);
            $encrypted_data['fecha_nacimiento']  = base64_encode($encrypted_fecha_nacimiento);
            $encrypted_data['direccion']         = base64_encode($encrypted_direccion);
            $encrypted_data['id_genero']         = base64_encode($encrypted_id_genero);
            
            $rpta['data'] = $encrypted_data;
        }
        return response()->json($rpta);
    }
}
