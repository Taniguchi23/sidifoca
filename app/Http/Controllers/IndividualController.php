<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidacionDNI;
use App\Http\Requests\ValidacionEnvioPostulacionIndividual;
use App\Http\Requests\ValidacionEquipoPostulacion;
use App\Http\Requests\ValidacionPostulacionIndividual;
use App\Http\Requests\ValidacionReniec;
use App\Repositories\CargoRepository;
use App\Repositories\CategoriaRepository;
use App\Repositories\DimensionRepository;
use App\Repositories\DistritoRepository;
use App\Repositories\DreGreRepository;
use App\Repositories\PostulacionIndividualRepository;
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

class IndividualController extends Controller
{
    use TokenTrait;
    
    protected $postulacionIndividual;
    protected $tipoPostulacion;
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
        PostulacionIndividualRepository $postulacionIndividual,
        TipoPostulacionRepository $tipoPostulacion,
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
        $this->postulacionIndividual = $postulacionIndividual;
        $this->tipoPostulacion = $tipoPostulacion;
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
        return view('individual.index');
    }

    public function registrar()
    {
        $rpta = $this->postulacionIndividual->insertar();
        return response()->json($rpta);
    }

    public function editar($id)
    {
        $postulacion = $this->postulacionIndividual->obtener($id);
        if (empty($postulacion)) {
            abort(404);
        } else if ($postulacion->flg_editado) {
            $token = $this->generarToken();
            return view('individual.paso-2')->with([
                'postulacion' => $postulacion,
                'token' => $token
            ]);
        }
        $arr_tipo_postulacion = $this->tipoPostulacion->filtrarPorModalidad($postulacion->id_modalidad);
        $arr_dre_gre = $this->dreGre->listar();
        $arr_ugel = $this->ugel->filtrarPorDreGre($postulacion->id_dre_gre);
        $arr_provincia = $this->provincia->filtrarPorDreGre($postulacion->id_dre_gre);
        $arr_postulacion_provincia = $this->postulacionIndividual->provincias($postulacion->id_postulacion);
        $arr_distrito = $this->distrito->filtrarPorPostulacion($postulacion->id_postulacion);
        $arr_postulacion_distrito = $this->postulacionIndividual->distritos($postulacion->id_postulacion);
        $arr_categoria = $this->categoria->listar();
        $arr_tema = $this->tema->filtrarPorCategoria($postulacion->id_categoria);
        $arr_mes = $this->listarMes();
        $arr_dia = $this->listarDia();
        return view('individual.registrar')->with([
            'postulacion' => $postulacion,
            'arr_tipo_postulacion' => $arr_tipo_postulacion,
            'arr_dre_gre' => $arr_dre_gre,
            'arr_ugel' => $arr_ugel,
            'arr_provincia' => $arr_provincia,
            'arr_postulacion_provincia' => $arr_postulacion_provincia,
            'arr_distrito' => $arr_distrito,
            'arr_postulacion_distrito' => $arr_postulacion_distrito,
            'arr_categoria' => $arr_categoria,
            'arr_tema' => $arr_tema,
            'arr_mes' => $arr_mes,
            'arr_dia' => $arr_dia
        ]);
    }

    public function grabar(ValidacionPostulacionIndividual $request, $id)
    {
        $dataReniec_d_nro_dni = $this->reniec->consultar($request->get('d_nro_dni'));
        if ($dataReniec_d_nro_dni['success'] == false) {
            $dataReniec_d_nro_dni = null;
        }
        $dataReniec_c_nro_dni = $this->reniec->consultar($request->get('c_nro_dni'));
        if ($dataReniec_c_nro_dni['success'] == false) {
            $dataReniec_c_nro_dni = null;
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
            'id_director',
            'd_nro_dni',
            'd_nombres',
            'd_apellido_paterno',
            'd_apellido_materno',
            'd_telefono_fijo',
            'd_telefono_celular',
            'd_email',
            'id_contacto_postulacion',
            'c_nro_dni',
            'c_nombres',
            'c_apellido_paterno',
            'c_apellido_materno',
            'c_telefono_fijo',
            'c_telefono_celular',
            'c_email'
        ]);
        if (empty($dataReniec_d_nro_dni) || empty($dataReniec_c_nro_dni)) {
            $data += ['flg_reniec' => false ];
        } else {
            $data += ['flg_reniec' => true ];

            $data['d_nombres'] = $dataReniec_d_nro_dni['data']->nombres;
            $data['d_apellido_paterno'] = $dataReniec_d_nro_dni['data']->apellido_paterno;
            $data['d_apellido_materno'] = $dataReniec_d_nro_dni['data']->apellido_materno;

            $data['c_nombres'] = $dataReniec_c_nro_dni['data']->nombres;
            $data['c_apellido_paterno'] = $dataReniec_c_nro_dni['data']->apellido_paterno;
            $data['c_apellido_materno'] = $dataReniec_c_nro_dni['data']->apellido_materno;
        }
        $rpta = $this->postulacionIndividual->editar($id, $data);
        if ($rpta['success']) {
            $this->postulacion->notificar($rpta['data']);
        }
        return response()->json($rpta);
    }

    public function autosave(Request $request, $id)
    {
        $rpta = $this->postulacionIndividual->autosave($id, $request->only([
            'id_tipo_postulacion',
            'id_dre_gre',
            'id_ugel',
            'buena_practica',
            'id_categoria',
            'id_tema',
            'nro_meses',
            'nro_dias',
            'id_director',
            'd_nro_dni',
            'd_nombres',
            'd_apellido_paterno',
            'd_apellido_materno',
            'd_telefono_fijo',
            'd_telefono_celular',
            'd_email',
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

    public function ctrlTipoPostulacion(Request $request, $id)
    {
        $rpta = $this->postulacionIndividual->reiniciarTipoPostulacion($id, $request->only([
            'id_tipo_postulacion'
        ]));
        return response()->json($rpta);
    }

    public function ctrlDreGre(Request $request, $id)
    {
        $rpta = $this->postulacionIndividual->reiniciarZonaAlcance($id);
        $arr_ugel = $this->ugel->filtrarPorDreGre($request->get('id_dre_gre'));
        $arr_provincia = $this->provincia->filtrarPorDreGre($request->get('id_dre_gre'));
        return response()->json([
            'success' => $rpta['success'],
            'arr_ugel' => $arr_ugel,
            'arr_provincia' => $arr_provincia
        ]);
    }

    public function agregarProvincia(Request $request, $id)
    {
        $rpta = $this->postulacionIndividual->agregarProvincia($id, $request->only([
            'id_provincia'
        ]));
        $arr_postulacion_provincia = $this->postulacionIndividual->provincias($id);
        $arr_distrito = $this->distrito->filtrarPorPostulacion($id);
        return response()->json([
            'success' => $rpta['success'],
            'arr_postulacion_provincia' => $arr_postulacion_provincia,
            'arr_distrito' => $arr_distrito
        ]);
    }

    public function agregarDistrito(Request $request, $id)
    {
        $rpta = $this->postulacionIndividual->agregarDistrito($id, $request->only([
            'id_distrito'
        ]));
        $arr_postulacion_distrito = $this->postulacionIndividual->distritos($id);
        return response()->json([
            'success' => $rpta['success'],
            'arr_postulacion_distrito' => $arr_postulacion_distrito
        ]);
    }

    public function eliminarProvincia(Request $request, $id)
    {
        $rpta = $this->postulacionIndividual->eliminarProvincia($id, $request->only([
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
        $rpta = $this->postulacionIndividual->eliminarDistrito($id, $request->only([
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
        $rpta = $this->postulacionIndividual->editarRespuesta($id, $request->only([
            'id_respuesta',
            'descripcion'
        ]));
        return response()->json($rpta);
    }

    public function listarEquipoPostulacion($id)
    {
        $arr_equipo_postulacion = $this->postulacionIndividual->listarEquipoPostulacion($id);
        return response()->json($arr_equipo_postulacion);
    }

    public function agregarEquipoPostulacion($id)
    {
        $arr_cargo = $this->cargo->interno($id);
        return view('individual.agregar-equipo-postulacion')->with([
            'id_postulacion' => $id,
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
            'p_nro_dni',
            'p_nombres',
            'p_apellido_paterno',
            'p_apellido_materno',
            'p_telefono',
            'p_email',
            'p_id_cargo'
        ]);
        if (empty($dataReniec)) {
            $data += ['flg_reniec' => false ];
        } else {
            $data += ['flg_reniec' => true ];
        
            $data['p_nombres'] = $dataReniec['data']->nombres;
            $data['p_apellido_paterno'] = $dataReniec['data']->apellido_paterno;
            $data['p_apellido_materno'] = $dataReniec['data']->apellido_materno;
        }
        $rpta = $this->postulacionIndividual->agregarEquipoPostulacion($id, $data);
        return response()->json($rpta);
    }

    public function eliminarEquipoPostulacion(Request $request, $id)
    {
        $rpta = $this->postulacionIndividual->eliminarEquipoPostulacion($id, $request->only([
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
        $postulacion = $this->postulacionIndividual->obtener($id);
        if (empty($postulacion)) {
            abort(404);
        } elseif (!$postulacion->flg_editado) {
            return view('individual.index')->withErrors(['*' => 'Paso 3: Código de postulación no encontrado.']);
        } elseif ($postulacion->flg_enviado) {
            return view('individual.paso-3')->with('postulacion', $postulacion);
        }
        return view('individual.adjuntar')->with('postulacion', $postulacion);
    }

    public function enviar(ValidacionEnvioPostulacionIndividual $request, $id)
    {
        $rpta = $this->postulacionIndividual->enviar($id, $request->only([
            'url_declaracion_representante',
            'url_declaracion_equipo',
            'url_documento_imagen',
            'url_video'
        ]));
        return response()->json($rpta);
    }

    public function codigo(Request $request)
    {
        $postulacion = $this->postulacionIndividual->codigo($request->get('codigo'));
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
        $postulacion = $this->postulacionIndividual->obtener($id);
        if (empty($postulacion)) {
            abort(404);
        }
        $pdf = PDF::loadView('individual.representante-postulacion', [
            'postulacion' => $postulacion
        ]);
        return $pdf->download('representante-postulacion.pdf');
    }

    public function equipoTecnicoPostulacion($id, $token)
    {
        if (!$this->validarToken($token)) {
            abort(521);
        }
        $postulacion = $this->postulacionIndividual->obtener($id);
        if (empty($postulacion)) {
            abort(404);
        }
        $arr_equipo_postulacion = $this->postulacionIndividual->listarEquipoPostulacion($id);
        $pdf = PDF::loadView('individual.equipo-tecnico-postulacion', [
            'postulacion' => $postulacion,
            'arr_equipo_postulacion' => $arr_equipo_postulacion->chunk(2)
        ]);
        return $pdf->download('equipo-tecnico-postulacion.pdf');
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
