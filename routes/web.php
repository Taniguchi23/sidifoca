<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'throttle:60,1'], function () {

/**
 * RUTAS HOME
 */
Route::get('/', "RegistroController@index")->name('home');
Route::get('bases-concurso/{token}', 'RegistroController@basesConcurso')->name('bases_concurso');
Route::get('bpg-acta-acuerdos-colectiva/{token}', 'RegistroController@bpgActaAcuerdosColectivaVigente')->name('bpg_acta_acuerdos_colectiva');

/**
 * RUTAS MODALIDAD INDIVIDUAL
 * MIDDLEWARE:  PUBLISHED | POST
 */
Route::get('individual', 'IndividualController@index')->name('individual')->middleware('published');
Route::get('individual/editar/{id}', 'IndividualController@editar')->name('individual.editar')->middleware(['published', 'post']);
Route::get('individual/ctrl-dre-gre/{id}', 'IndividualController@ctrlDreGre')->name('individual.ctrl_dre_gre')->middleware('published');
Route::get('individual/ctrl-tipo-postulacion/{id}', 'IndividualController@ctrlTipoPostulacion')->name('individual.ctrl_tipo_postulacion')->middleware('published');
Route::get('individual/listar-tema', 'IndividualController@listarTema')->name('individual.listar_tema')->middleware('published');
Route::get('individual/listar-equipo-postulacion/{id}', 'IndividualController@listarEquipoPostulacion')->name('individual.listar_equipo_postulacion')->middleware(['published', 'post']);
Route::get('individual/agregar-equipo-postulacion/{id}', 'IndividualController@agregarEquipoPostulacion')->name('individual.agregar_equipo_postulacion')->middleware(['published', 'post']);
Route::get('individual/captcha', 'IndividualController@captcha')->name('individual.captcha')->middleware('published');
Route::get('individual/adjuntar/{id}', 'IndividualController@adjuntar')->name('individual.adjuntar')->middleware(['published', 'post']);
Route::get('individual/representante-postulacion/{id}/{token}', 'IndividualController@representantePostulacion')->name('individual.representante_postulacion')->middleware(['published', 'post']);
Route::get('individual/equipo-tecnico-postulacion/{id}/{token}', 'IndividualController@equipoTecnicoPostulacion')->name('individual.equipo_tecnico_postulacion')->middleware(['published', 'post']);
Route::post('individual/registrar', 'IndividualController@registrar')->name('individual.registrar')->middleware('published');
Route::post('individual/codigo', 'IndividualController@codigo')->name('individual.codigo')->middleware('published');
Route::post('individual/agregar-provincia/{id}', 'IndividualController@agregarProvincia')->name('individual.agregar_provincia')->middleware(['published', 'post']);
Route::post('individual/eliminar-provincia/{id}', 'IndividualController@eliminarProvincia')->name('individual.eliminar_provincia')->middleware(['published', 'post']);
Route::post('individual/agregar-distrito/{id}', 'IndividualController@agregarDistrito')->name('individual.agregar_distrito')->middleware(['published', 'post']);
Route::post('individual/eliminar-distrito/{id}', 'IndividualController@eliminarDistrito')->name('individual.eliminar_distrito')->middleware(['published', 'post']);
Route::post('individual/editar-respuesta/{id}', 'IndividualController@editarRespuesta')->name('individual.editar_respuesta')->middleware(['published', 'post']);
Route::post('individual/grabar/{id}', 'IndividualController@grabar')->name('individual.grabar')->middleware(['published', 'post', 'jcryption']);
Route::post('individual/autosave/{id}', 'IndividualController@autosave')->name('individual.autosave')->middleware(['published', 'post', 'jcryption']);
Route::post('individual/guardar-equipo-postulacion/{id}', 'IndividualController@guardarEquipoPostulacion')->name('individual.guardar_equipo_postulacion')->middleware(['published', 'post', 'jcryption']);
Route::post('individual/eliminar-equipo-postulacion/{id}', 'IndividualController@eliminarEquipoPostulacion')->name('individual.eliminar_equipo_postulacion')->middleware(['published', 'post']);
Route::post('individual/enviar/{id}', 'IndividualController@enviar')->name('individual.enviar')->middleware(['published', 'post']);
Route::post('individual/reniec', 'IndividualController@reniec')->name('individual.reniec')->middleware('jcryption');;

/**
 * RUTAS MODALIDAD COLECTIVA
 * MIDDLEWARE:  PUBLISHED | POST
 */
Route::get('colectiva', 'ColectivaController@index')->name('colectiva')->middleware('published');
Route::get('colectiva/editar/{id}', 'ColectivaController@editar')->name('colectiva.editar')->middleware(['published', 'post']);
Route::get('colectiva/ctrl-dre-gre/{id}', 'ColectivaController@ctrlDreGre')->name('colectiva.ctrl_dre_gre')->middleware('published');
Route::get('colectiva/listar-tema', 'ColectivaController@listarTema')->name('colectiva.listar_tema')->middleware('published');
Route::get('colectiva/listar-equipo-gobierno-local/{id}', 'ColectivaController@listarEquipoGobiernoLocal')->name('colectiva.listar_equipo_gobierno_local')->middleware(['published', 'post']);
Route::get('colectiva/agregar-equipo-gobierno-local/{id}', 'ColectivaController@agregarEquipoGobiernoLocal')->name('colectiva.agregar_equipo_gobierno_local')->middleware(['published', 'post']);
Route::get('colectiva/listar-director/{id}', 'ColectivaController@listarDirector')->name('colectiva.listar_director')->middleware(['published', 'post']);
Route::get('colectiva/agregar-director/{id}', 'ColectivaController@agregarDirector')->name('colectiva.agregar_director')->middleware(['published', 'post']);
Route::get('colectiva/agregar-equipo-postulacion/{id}', 'ColectivaController@agregarEquipoPostulacion')->name('colectiva.agregar_equipo_postulacion')->middleware(['published', 'post']);
Route::get('colectiva/captcha', 'ColectivaController@captcha')->name('colectiva.captcha')->middleware('published');
Route::get('colectiva/adjuntar/{id}', 'ColectivaController@adjuntar')->name('colectiva.adjuntar')->middleware(['published', 'post']);
Route::get('colectiva/representante-postulacion/{id}/{token}', 'ColectivaController@representantePostulacion')->name('colectiva.representante_postulacion')->middleware(['published', 'post']);
Route::get('colectiva/equipo-tecnico-postulacion/{id}/{token}', 'ColectivaController@equipoTecnicoPostulacion')->name('colectiva.equipo_tecnico_postulacion')->middleware(['published', 'post']);
Route::get('colectiva/equipo-gobierno-postulacion/{id}/{token}', 'ColectivaController@equipoGobiernoPostulacion')->name('colectiva.equipo_gobierno_postulacion')->middleware(['published', 'post']);
Route::post('colectiva/registrar', 'ColectivaController@registrar')->name('colectiva.registrar')->middleware('published');
Route::post('colectiva/codigo', 'ColectivaController@codigo')->name('colectiva.codigo')->middleware('published');
Route::post('colectiva/agregar-ugel/{id}', 'ColectivaController@agregarUgel')->name('colectiva.agregar_ugel')->middleware(['published', 'post']);
Route::post('colectiva/eliminar-ugel/{id}', 'ColectivaController@eliminarUgel')->name('colectiva.eliminar_ugel')->middleware(['published', 'post']);
Route::post('colectiva/agregar-provincia/{id}', 'ColectivaController@agregarProvincia')->name('colectiva.agregar_provincia')->middleware(['published', 'post']);
Route::post('colectiva/eliminar-provincia/{id}', 'ColectivaController@eliminarProvincia')->name('colectiva.eliminar_provincia')->middleware(['published', 'post']);
Route::post('colectiva/agregar-distrito/{id}', 'ColectivaController@agregarDistrito')->name('colectiva.agregar_distrito')->middleware(['published', 'post']);
Route::post('colectiva/eliminar-distrito/{id}', 'ColectivaController@eliminarDistrito')->name('colectiva.eliminar_distrito')->middleware(['published', 'post']);
Route::post('colectiva/editar-respuesta/{id}', 'ColectivaController@editarRespuesta')->name('colectiva.editar_respuesta')->middleware(['published', 'post']);
Route::post('colectiva/grabar/{id}', 'ColectivaController@grabar')->name('colectiva.grabar')->middleware(['published', 'post', 'jcryption']);
Route::post('colectiva/autosave/{id}', 'ColectivaController@autosave')->name('colectiva.autosave')->middleware(['published', 'post', 'jcryption']);
Route::post('colectiva/guardar-equipo-gobierno-local/{id}', 'ColectivaController@guardarEquipoGobiernoLocal')->name('colectiva.guardar_equipo_gobierno_local')->middleware(['published', 'post', 'jcryption']);
Route::post('colectiva/eliminar-equipo-gobierno-local/{id}', 'ColectivaController@eliminarEquipoGobiernoLocal')->name('colectiva.eliminar_equipo_gobierno_local')->middleware(['published', 'post']);
Route::post('colectiva/guardar-director/{id}', 'ColectivaController@guardarDirector')->name('colectiva.guardar_director')->middleware(['published', 'post', 'jcryption']);
Route::post('colectiva/eliminar-director/{id}', 'ColectivaController@eliminarDirector')->name('colectiva.eliminar_director')->middleware(['published', 'post']);
Route::post('colectiva/guardar-equipo-postulacion/{id}', 'ColectivaController@guardarEquipoPostulacion')->name('colectiva.guardar_equipo_postulacion')->middleware(['published', 'post', 'jcryption']);
Route::post('colectiva/eliminar-equipo-postulacion/{id}', 'ColectivaController@eliminarEquipoPostulacion')->name('colectiva.eliminar_equipo_postulacion')->middleware(['published', 'post']);
Route::post('colectiva/enviar/{id}', 'ColectivaController@enviar')->name('colectiva.enviar')->middleware(['published', 'post']);
Route::post('colectiva/reniec', 'ColectivaController@reniec')->name('colectiva.reniec')->middleware('jcryption');;

/**
 * RUTAS LOGIN & REGISTRO
 */
Route::get('ingresar', 'IntranetController@ingresar')->name('login');
Route::get('registrarse', 'IntranetController@registrarse')->name('registrarse');
Route::get('listar-ugel', 'IntranetController@listarUgel')->name('listar_ugel');
Route::get('listar-nivel-puesto', 'IntranetController@listarNivelPuesto')->name('listar_nivel_puesto');
Route::get('listar-puesto', 'IntranetController@listarPuesto')->name('listar_puesto');
Route::get('recaptcha', 'IntranetController@captcha')->name('recaptcha');
Route::post('reniec', 'IntranetController@reniec')->name('reniec')->middleware('jcryption');
Route::post('guardar', 'IntranetController@guardar')->name('guardar')->middleware('jcryption');
Route::post('authenticate', 'IntranetController@authenticate')->name('authenticate')->middleware('jcryption');

/**
 * RUTAS RECUPERAR CONTRASENA
 */
Route::get('recuperar-contrasena', 'ResetContrasenaController@crear')->name('recuperar_contrasena');
Route::get('editar-contrasena/{id}', 'ResetContrasenaController@editar')->name('editar_contrasena');
Route::post('enviar-correo', 'ResetContrasenaController@guardar')->name('enviar_correo')->middleware('jcryption');
Route::post('grabar-contrasena/{id}', 'ResetContrasenaController@grabar')->name('grabar_contrasena')->middleware('jcryption');

Route::middleware('auth')->group(function () {
    /**
     * RUTAS INTRANET
     */
    Route::get('intranet', 'IntranetController@index')->name('intranet');
    Route::get('intranet/cerrar-sesion', 'IntranetController@cerrarSesion')->name('intranet.cerrar_sesion');
    Route::get('intranet/fotografia', 'IntranetController@fotografia')->name('intranet.fotografia');
    Route::get('intranet/carnet-conadis', 'IntranetController@carnetConadis')->name('intranet.carnet_conadis');
    Route::get('intranet/contrato', 'IntranetController@documento')->name('intranet.contrato');

    /**
     * RURAS MI PERFIL
     */
    Route::get('mi-perfil', 'MiPerfilController@index')->name('mi_perfil');
    Route::get('mi-perfil/editar-contrasena', 'MiPerfilController@editarContrasena')->name('mi_perfil.editar_contrasena');
    Route::get('mi-perfil/editar-contrato', 'MiPerfilController@editarContrato')->name('mi_perfil.editar_contrato');
    Route::get('mi-perfil/listar-ugel', 'MiPerfilController@listarUgel')->name('mi_perfil.listar_ugel');
    Route::get('mi-perfil/listar-puesto', 'MiPerfilController@listarPuesto')->name('mi_perfil.listar_puesto');
    Route::get('mi-perfil/fotografia', 'MiPerfilController@fotografia')->name('mi_perfil.fotografia');
    Route::get('mi-perfil/carnet-conadis', 'MiPerfilController@carnetConadis')->name('mi_perfil.carnet_conadis');
    Route::get('mi-perfil/contrato', 'MiPerfilController@documento')->name('mi_perfil.contrato');
    Route::post('mi-perfil/grabar', 'MiPerfilController@grabar')->name('mi_perfil.grabar')->middleware('jcryption');
    Route::post('mi-perfil/grabar-contrasena', 'MiPerfilController@grabarContrasena')->name('mi_perfil.grabar_contrasena')->middleware('jcryption');
    Route::post('mi-perfil/grabar-contrato', 'MiPerfilController@grabarContrato')->name('mi_perfil.grabar_contrato');

    /**
     * RUTAS ADMISION
     */
    Route::get('admision', 'PostulacionConcursoController@index')->name('admision')->middleware(['permission:consultar_admision', 'active:admision.no_vigente']);
    Route::get('admision/listar-tipo-postulacion', 'PostulacionConcursoController@listarTipoPostulacion')->name('admision.listar_tipo_postulacion')->middleware('permission:consultar_admision, validar_postulacion');
    Route::get('admision/listar-tema', 'PostulacionConcursoController@listarTema')->name('admision.listar_tema')->middleware('permission:consultar_admision, validar_postulacion');
    Route::get('admision/detalles/{id}', 'PostulacionConcursoController@detalles')->name('admision.detalles')->middleware('permission:consultar_admision');
    Route::get('admision/validar/{id}', 'PostulacionConcursoController@editar')->name('admision.editar')->middleware(['permission:validar_postulacion', 'active:admision.no_vigente']);
    Route::get('admision/declaracion-representante/{id}', 'PostulacionConcursoController@declaracionRepresentante')->name('admision.declaracion_representante')->middleware('permission:consultar_admision, validar_postulacion');
    Route::get('admision/declaracion-equipo/{id}', 'PostulacionConcursoController@declaracionEquipo')->name('admision.declaracion_equipo')->middleware('permission:consultar_admision, validar_postulacion');
    Route::get('admision/acta-modalidad-colectiva/{id}', 'PostulacionConcursoController@actaModalidadColectiva')->name('admision.acta_modalidad_colectiva')->middleware('permission:consultar_admision, validar_postulacion');
    Route::get('admision/no-vigente', 'PostulacionConcursoController@noVigente')->name('admision.no_vigente')->middleware('permission:consultar_admision');
    Route::post('admision/grabar/{id}', 'PostulacionConcursoController@grabar')->name('admision.grabar')->middleware('permission:validar_postulacion', 'active:admision.no_vigente');

    /**
     * RUTAS PRE-SELECCION
     */
    Route::get('preseleccion', 'PostulacionAdmitidaController@index')->name('postulacion_admitida')->middleware(['permission:consultar_preseleccion', 'active:postulacion_admitida.no_vigente']);
    Route::get('preseleccion/listar-tipo-postulacion', 'PostulacionAdmitidaController@listarTipoPostulacion')->name('postulacion_admitida.listar_tipo_postulacion')->middleware('permission:consultar_preseleccion, calificar_postulacion');
    Route::get('preseleccion/listar-tema', 'PostulacionAdmitidaController@listarTema')->name('postulacion_admitida.listar_tema')->middleware('permission:consultar_preseleccion, calificar_postulacion');
    Route::get('preseleccion/detalles/{id}', 'PostulacionAdmitidaController@detalles')->name('postulacion_admitida.detalles')->middleware('permission:consultar_preseleccion');
    Route::get('preseleccion/calificar/{id}', 'PostulacionAdmitidaController@editar')->name('postulacion_admitida.editar')->middleware(['permission:calificar_postulacion', 'active:postulacion_admitida.no_vigente']);
    Route::get('preseleccion/declaracion-representante/{id}', 'PostulacionAdmitidaController@declaracionRepresentante')->name('postulacion_admitida.declaracion_representante')->middleware('permission:consultar_preseleccion, calificar_postulacion');
    Route::get('preseleccion/declaracion-equipo/{id}', 'PostulacionAdmitidaController@declaracionEquipo')->name('postulacion_admitida.declaracion_equipo')->middleware('permission:consultar_preseleccion, calificar_postulacion');
    Route::get('preseleccion/acta-modalidad-colectiva/{id}', 'PostulacionAdmitidaController@actaModalidadColectiva')->name('postulacion_admitida.acta_modalidad_colectiva')->middleware('permission:consultar_preseleccion, calificar_postulacion');
    Route::get('preseleccion/no-vigente', 'PostulacionAdmitidaController@noVigente')->name('postulacion_admitida.no_vigente')->middleware('permission:consultar_preseleccion');
    Route::post('preseleccion/grabar/{id}', 'PostulacionAdmitidaController@grabar')->name('postulacion_admitida.grabar')->middleware(['permission:calificar_postulacion', 'active:postulacion_admitida.no_vigente']);

    /**
     * RUTAS FINALISTA
     */
    Route::get('finalista', 'PostulacionFinalistaController@index')->name('postulacion_finalista')->middleware(['permission:consultar_finalista', 'active:postulacion_finalista.no_vigente']);
    Route::get('finalista/listar-tipo-postulacion', 'PostulacionFinalistaController@listarTipoPostulacion')->name('postulacion_finalista.listar_tipo_postulacion')->middleware('permission:consultar_finalista');
    Route::get('finalista/listar-tema', 'PostulacionFinalistaController@listarTema')->name('postulacion_finalista.listar_tema')->middleware('permission:consultar_finalista');
    Route::get('finalista/detalles/{id}', 'PostulacionFinalistaController@detalles')->name('postulacion_finalista.detalles')->middleware('permission:consultar_finalista');
    Route::get('finalista/calificar/{id}', 'PostulacionFinalistaController@editar')->name('postulacion_finalista.editar')->middleware(['permission:calificar_finalista', 'active:postulacion_finalista.no_vigente']);
    Route::get('finalista/declaracion-representante/{id}', 'PostulacionFinalistaController@declaracionRepresentante')->name('postulacion_finalista.declaracion_representante')->middleware('permission:consultar_finalista, calificar_finalista');
    Route::get('finalista/declaracion-equipo/{id}', 'PostulacionFinalistaController@declaracionEquipo')->name('postulacion_finalista.declaracion_equipo')->middleware('permission:consultar_finalista, calificar_finalista');
    Route::get('finalista/acta-modalidad-colectiva/{id}', 'PostulacionFinalistaController@actaModalidadColectiva')->name('postulacion_finalista.acta_modalidad_colectiva')->middleware('permission:consultar_finalista, calificar_finalista');
    Route::get('finalista/no-vigente', 'PostulacionFinalistaController@noVigente')->name('postulacion_finalista.no_vigente')->middleware('permission:consultar_finalista');
    Route::post('finalista/grabar/{id}', 'PostulacionFinalistaController@grabar')->name('postulacion_finalista.grabar')->middleware(['permission:calificar_finalista', 'active:postulacion_finalista.no_vigente']);

    /**
     * RUTAS CONCURSO
     */
    Route::get('concurso', 'ConcursoController@index')->name('concurso')->middleware('permission:consultar_concurso');
    Route::get('concurso/crear', 'ConcursoController@crear')->name('concurso.crear')->middleware('permission:crear_concurso');
    Route::get('concurso/detalles/{id}', 'ConcursoController@detalles')->name('concurso.detalles')->middleware('permission:consultar_concurso');
    Route::get('concurso/editar/{id}', 'ConcursoController@editar')->name('concurso.editar')->middleware('permission:editar_concurso');
    Route::get('concurso/bases-concurso/{id}/{token}', 'ConcursoController@basesConcurso')->name('concurso.bases_concurso')->middleware('permission:consultar_concurso');
    Route::get('concurso/bpg-acta-acuerdos-colectiva/{id}/{token}', 'ConcursoController@bpgActaAcuerdosColectiva')->name('concurso.bpg_acta_acuerdos_colectiva')->middleware('permission:consultar_concurso');
    Route::post('concurso/guardar', 'ConcursoController@guardar')->name('concurso.guardar')->middleware('permission:crear_concurso');
    Route::post('concurso/grabar/{id}', 'ConcursoController@grabar')->name('concurso.grabar')->middleware('permission:editar_concurso');

    /**
     * RUTAS POSTULACION
     */
    Route::get('postulacion', 'PostulacionController@index')->name('postulacion')->middleware('permission:consultar_postulacion');
    Route::get('postulacion/listar-tipo-postulacion', 'PostulacionController@listarTipoPostulacion')->name('postulacion.listar_tipo_postulacion')->middleware('permission:consultar_postulacion');
    Route::get('postulacion/listar-tema', 'PostulacionController@listarTema')->name('postulacion.listar_tema')->middleware('permission:consultar_postulacion');
    Route::get('postulacion/detalles/{id}', 'PostulacionController@detalles')->name('postulacion.detalles')->middleware('permission:consultar_postulacion');
    Route::get('postulacion/declaracion-representante/{id}', 'PostulacionController@declaracionRepresentante')->name('postulacion.declaracion_representante')->middleware('permission:consultar_postulacion');
    Route::get('postulacion/declaracion-equipo/{id}', 'PostulacionController@declaracionEquipo')->name('postulacion.declaracion_equipo')->middleware('permission:consultar_postulacion');
    Route::get('postulacion/acta-modalidad-colectiva/{id}', 'PostulacionController@actaModalidadColectiva')->name('postulacion.acta_modalidad_colectiva')->middleware('permission:consultar_postulacion');

    /**
     * RUTAS CATEGORIA
     */
    Route::get('categoria', 'CategoriaController@index')->name('categoria')->middleware('permission:consultar_categoria');
    Route::get('categoria/crear', 'CategoriaController@crear')->name('categoria.crear')->middleware('permission:crear_categoria');
    Route::get('categoria/detalles/{id}', 'CategoriaController@detalles')->name('categoria.detalles')->middleware('permission:consultar_categoria');
    Route::get('categoria/editar/{id}', 'CategoriaController@editar')->name('categoria.editar')->middleware('permission:editar_categoria');
    Route::post('categoria/guardar', 'CategoriaController@guardar')->name('categoria.guardar')->middleware('permission:crear_categoria');
    Route::post('categoria/grabar/{id}', 'CategoriaController@grabar')->name('categoria.grabar')->middleware('permission:editar_categoria');

    /**
     * RUTAS TEMA
     */
    Route::get('tema', 'TemaController@index')->name('tema')->middleware('permission:consultar_tema');
    Route::get('tema/crear', 'TemaController@crear')->name('tema.crear')->middleware('permission:crear_tema');
    Route::get('tema/detalles/{id}', 'TemaController@detalles')->name('tema.detalles')->middleware('permission:consultar_tema');
    Route::get('tema/editar/{id}', 'TemaController@editar')->name('tema.editar')->middleware('permission:editar_tema');
    Route::post('tema/guardar', 'TemaController@guardar')->name('tema.guardar')->middleware('permission:crear_tema');
    Route::post('tema/grabar/{id}', 'TemaController@grabar')->name('tema.grabar')->middleware('permission:editar_tema');

    /**
     * RUTAS DRE_GRE
     */
    Route::get('dre-gre', 'DreGreController@index')->name('dre_gre')->middleware('permission:consultar_dre_gre');
    Route::get('dre-gre/crear', 'DreGreController@crear')->name('dre_gre.crear')->middleware('permission:crear_dre_gre');
    Route::get('dre-gre/detalles/{id}', 'DreGreController@detalles')->name('dre_gre.detalles')->middleware('permission:consultar_dre_gre');
    Route::get('dre-gre/editar/{id}', 'DreGreController@editar')->name('dre_gre.editar')->middleware('permission:editar_dre_gre');
    Route::post('dre-gre/guardar', 'DreGreController@guardar')->name('dre_gre.guardar')->middleware('permission:crear_dre_gre');
    Route::post('dre-gre/grabar/{id}', 'DreGreController@grabar')->name('dre_gre.grabar')->middleware('permission:editar_dre_gre');

    /**
     * RUTAS UGEL
     */
    Route::get('ugel', 'UgelController@index')->name('ugel')->middleware('permission:consultar_ugel');
    Route::get('ugel/crear', 'UgelController@crear')->name('ugel.crear')->middleware('permission:crear_ugel');
    Route::get('ugel/detalles/{id}', 'UgelController@detalles')->name('ugel.detalles')->middleware('permission:consultar_ugel');
    Route::get('ugel/editar/{id}', 'UgelController@editar')->name('ugel.editar')->middleware('permission:editar_ugel');
    Route::post('ugel/guardar', 'UgelController@guardar')->name('ugel.guardar')->middleware('permission:crear_ugel');
    Route::post('ugel/grabar/{id}', 'UgelController@grabar')->name('ugel.grabar')->middleware('permission:editar_ugel');

    /**
     * RUTAS PROVINCIA
     */
    Route::get('provincia', 'ProvinciaController@index')->name('provincia')->middleware('permission:consultar_provincia');
    Route::get('provincia/crear', 'ProvinciaController@crear')->name('provincia.crear')->middleware('permission:crear_provincia');
    Route::get('provincia/detalles/{id}', 'ProvinciaController@detalles')->name('provincia.detalles')->middleware('permission:consultar_provincia');
    Route::get('provincia/editar/{id}', 'ProvinciaController@editar')->name('provincia.editar')->middleware('permission:editar_provincia');
    Route::post('provincia/guardar', 'ProvinciaController@guardar')->name('provincia.guardar')->middleware('permission:crear_provincia');
    Route::post('provincia/grabar/{id}', 'ProvinciaController@grabar')->name('provincia.grabar')->middleware('permission:editar_provincia');

    /**
     * RUTAS DISTRITO
     */
    Route::get('distrito', 'DistritoController@index')->name('distrito')->middleware('permission:consultar_distrito');
    Route::get('distrito/crear', 'DistritoController@crear')->name('distrito.crear')->middleware('permission:crear_distrito');
    Route::get('distrito/detalles/{id}', 'DistritoController@detalles')->name('distrito.detalles')->middleware('permission:consultar_distrito');
    Route::get('distrito/editar/{id}', 'DistritoController@editar')->name('distrito.editar')->middleware('permission:editar_distrito');
    Route::post('distrito/guardar', 'DistritoController@guardar')->name('distrito.guardar')->middleware('permission:crear_distrito');
    Route::post('distrito/grabar/{id}', 'DistritoController@grabar')->name('distrito.grabar')->middleware('permission:editar_distrito');

    /**
     * RUTAS CARGO
     */
    Route::get('cargo', 'CargoController@index')->name('cargo')->middleware('permission:consultar_cargo');
    Route::get('cargo/crear', 'CargoController@crear')->name('cargo.crear')->middleware('permission:crear_cargo');
    Route::get('cargo/detalles/{id}', 'CargoController@detalles')->name('cargo.detalles')->middleware('permission:consultar_cargo');
    Route::get('cargo/editar/{id}', 'CargoController@editar')->name('cargo.editar')->middleware('permission:editar_cargo');
    Route::post('cargo/guardar', 'CargoController@guardar')->name('cargo.guardar')->middleware('permission:crear_cargo');
    Route::post('cargo/grabar/{id}', 'CargoController@grabar')->name('cargo.grabar')->middleware('permission:editar_cargo');

    /**
     * RUTAS DIMENSION
     */
    Route::get('dimension', 'DimensionController@index')->name('dimension')->middleware('permission:consultar_dimension');
    Route::get('dimension/crear', 'DimensionController@crear')->name('dimension.crear')->middleware('permission:crear_dimension');
    Route::get('dimension/detalles/{id}', 'DimensionController@detalles')->name('dimension.detalles')->middleware('permission:consultar_dimension');
    Route::get('dimension/editar/{id}', 'DimensionController@editar')->name('dimension.editar')->middleware('permission:editar_dimension');
    Route::post('dimension/guardar', 'DimensionController@guardar')->name('dimension.guardar')->middleware('permission:crear_dimension');
    Route::post('dimension/grabar/{id}', 'DimensionController@grabar')->name('dimension.grabar')->middleware('permission:editar_dimension');

    /**
     * RUTAS CRITERIO
     */
    Route::get('criterio', 'CriterioController@index')->name('criterio')->middleware('permission:consultar_criterio');
    Route::get('criterio/crear', 'CriterioController@crear')->name('criterio.crear')->middleware('permission:crear_criterio');
    Route::get('criterio/detalles/{id}', 'CriterioController@detalles')->name('criterio.detalles')->middleware('permission:consultar_criterio');
    Route::get('criterio/editar/{id}', 'CriterioController@editar')->name('criterio.editar')->middleware('permission:editar_criterio');
    Route::post('criterio/guardar', 'CriterioController@guardar')->name('criterio.guardar')->middleware('permission:crear_criterio');
    Route::post('criterio/grabar/{id}', 'CriterioController@grabar')->name('criterio.grabar')->middleware('permission:editar_criterio');

    /**
     * RUTAS GOBIERNO REGIONAL
     */
    Route::get('gobierno-regional', 'GobiernoRegionalController@index')->name('gobierno_regional')->middleware('permission:consultar_gobierno_regional');
    Route::get('gobierno-regional/crear', 'GobiernoRegionalController@crear')->name('gobierno_regional.crear')->middleware('permission:crear_gobierno_regional');
    Route::get('gobierno-regional/detalles/{id}', 'GobiernoRegionalController@detalles')->name('gobierno_regional.detalles')->middleware('permission:consultar_gobierno_regional');
    Route::get('gobierno-regional/editar/{id}', 'GobiernoRegionalController@editar')->name('gobierno_regional.editar')->middleware('permission:editar_gobierno_regional');
    Route::post('gobierno-regional/guardar', 'GobiernoRegionalController@guardar')->name('gobierno_regional.guardar')->middleware('permission:crear_gobierno_regional');
    Route::post('gobierno-regional/grabar/{id}', 'GobiernoRegionalController@grabar')->name('gobierno_regional.grabar')->middleware('permission:editar_gobierno_regional');

    /**
     * RUTAS GOBIERNO LOCAL
     */
    Route::get('gobierno-local', 'GobiernoLocalController@index')->name('gobierno_local')->middleware('permission:consultar_gobierno_local');
    Route::get('gobierno-local/crear', 'GobiernoLocalController@crear')->name('gobierno_local.crear')->middleware('permission:crear_gobierno_local');
    Route::get('gobierno-local/detalles/{id}', 'GobiernoLocalController@detalles')->name('gobierno_local.detalles')->middleware('permission:consultar_gobierno_local');
    Route::get('gobierno-local/editar/{id}', 'GobiernoLocalController@editar')->name('gobierno_local.editar')->middleware('permission:editar_gobierno_local');
    Route::post('gobierno-local/guardar', 'GobiernoLocalController@guardar')->name('gobierno_local.guardar')->middleware('permission:crear_gobierno_local');
    Route::post('gobierno-local/grabar/{id}', 'GobiernoLocalController@grabar')->name('gobierno_local.grabar')->middleware('permission:editar_gobierno_local');

    /**
     * RUTAS PREGUNTA
     */
    Route::get('pregunta', 'PreguntaController@index')->name('pregunta')->middleware('permission:consultar_pregunta');
    Route::get('pregunta/crear', 'PreguntaController@crear')->name('pregunta.crear')->middleware('permission:crear_pregunta');
    Route::get('pregunta/detalles/{id}', 'PreguntaController@detalles')->name('pregunta.detalles')->middleware('permission:consultar_pregunta');
    Route::get('pregunta/editar/{id}', 'PreguntaController@editar')->name('pregunta.editar')->middleware('permission:editar_pregunta');
    Route::post('pregunta/guardar', 'PreguntaController@guardar')->name('pregunta.guardar')->middleware('permission:crear_pregunta');
    Route::post('pregunta/grabar/{id}', 'PreguntaController@grabar')->name('pregunta.grabar')->middleware('permission:editar_pregunta');

    /**
     * RUTAS NIVEL EDUCATIVO
     */
    Route::get('nivel-educativo', 'NivelEducativoController@index')->name('nivel_educativo')->middleware('permission:consultar_nivel_educativo');
    Route::get('nivel-educativo/crear', 'NivelEducativoController@crear')->name('nivel_educativo.crear')->middleware('permission:crear_nivel_educativo');
    Route::get('nivel-educativo/detalles/{id}', 'NivelEducativoController@detalles')->name('nivel_educativo.detalles')->middleware('permission:consultar_nivel_educativo');
    Route::get('nivel-educativo/editar/{id}', 'NivelEducativoController@editar')->name('nivel_educativo.editar')->middleware('permission:editar_nivel_educativo');
    Route::post('nivel-educativo/guardar', 'NivelEducativoController@guardar')->name('nivel_educativo.guardar')->middleware('permission:crear_nivel_educativo');
    Route::post('nivel-educativo/grabar/{id}', 'NivelEducativoController@grabar')->name('nivel_educativo.grabar')->middleware('permission:editar_nivel_educativo');

    /**
     * RUTAS NIVEL PUESTO
     */
    Route::get('nivel-puesto', 'NivelPuestoController@index')->name('nivel_puesto')->middleware('permission:consultar_nivel_puesto');
    Route::get('nivel-puesto/crear', 'NivelPuestoController@crear')->name('nivel_puesto.crear')->middleware('permission:crear_nivel_puesto');
    Route::get('nivel-puesto/detalles/{id}', 'NivelPuestoController@detalles')->name('nivel_puesto.detalles')->middleware('permission:consultar_nivel_puesto');
    Route::get('nivel-puesto/editar/{id}', 'NivelPuestoController@editar')->name('nivel-puesto.editar')->middleware('permission:editar_nivel_puesto');
    Route::post('nivel-puesto/guardar', 'NivelPuestoController@guardar')->name('nivel_puesto.guardar')->middleware('permission:crear_nivel_puesto');
    Route::post('nivel-puesto/grabar/{id}', 'NivelPuestoController@grabar')->name('nivel_puesto.grabar')->middleware('permission:editar_nivel_puesto');

    /**
     * RUTAS PROFESION
     */
    Route::get('profesion', 'ProfesionController@index')->name('profesion')->middleware('permission:consultar_profesion');
    Route::get('profesion/crear', 'ProfesionController@crear')->name('profesion.crear')->middleware('permission:crear_profesion');
    Route::get('profesion/detalles/{id}', 'ProfesionController@detalles')->name('profesion.detalles')->middleware('permission:consultar_profesion');
    Route::get('profesion/editar/{id}', 'ProfesionController@editar')->name('profesion.editar')->middleware('permission:editar_profesion');
    Route::post('profesion/guardar', 'ProfesionController@guardar')->name('profesion.guardar')->middleware('permission:crear_profesion');
    Route::post('profesion/grabar/{id}', 'ProfesionController@grabar')->name('profesion.grabar')->middleware('permission:editar_profesion');

    /**
     * RUTAS PUESTO
     */
    Route::get('puesto', 'PuestoController@index')->name('puesto')->middleware('permission:consultar_puesto');
    Route::get('puesto/crear', 'PuestoController@crear')->name('puesto.crear')->middleware('permission:crear_puesto');
    Route::get('puesto/detalles/{id}', 'PuestoController@detalles')->name('puesto.detalles')->middleware('permission:consultar_puesto');
    Route::get('puesto/editar/{id}', 'PuestoController@editar')->name('puesto.editar')->middleware('permission:editar_puesto');
    Route::post('puesto/guardar', 'PuestoController@guardar')->name('puesto.guardar')->middleware('permission:crear_puesto');
    Route::post('puesto/grabar/{id}', 'PuestoController@grabar')->name('puesto.grabar')->middleware('permission:editar_puesto');

    /**
     * RUTAS REGIMEN LABORAL
     */
    Route::get('regimen-laboral', 'RegimenLaboralController@index')->name('regimen_laboral')->middleware('permission:consultar_regimen_laboral');
    Route::get('regimen-laboral/crear', 'RegimenLaboralController@crear')->name('regimen_laboral.crear')->middleware('permission:crear_regimen_laboral');
    Route::get('regimen-laboral/detalles/{id}', 'RegimenLaboralController@detalles')->name('regimen_laboral.detalles')->middleware('permission:consultar_regimen_laboral');
    Route::get('regimen-laboral/editar/{id}', 'RegimenLaboralController@editar')->name('regimen_laboral.editar')->middleware('permission:editar_regimen_laboral');
    Route::post('regimen-laboral/guardar', 'RegimenLaboralController@guardar')->name('regimen_laboral.guardar')->middleware('permission:crear_regimen_laboral');
    Route::post('regimen-laboral/grabar/{id}', 'RegimenLaboralController@grabar')->name('regimen_laboral.grabar')->middleware('permission:editar_regimen_laboral');

    /**
     * RUTAS ENTIDAD EXTERNA
     */
    Route::get('entidad-externa', 'EntidadExternaController@index')->name('entidad_externa')->middleware('permission:consultar_entidad_externa');
    Route::get('entidad-externa/crear', 'EntidadExternaController@crear')->name('entidad_externa.crear')->middleware('permission:crear_entidad_externa');
    Route::get('entidad-externa/detalles/{id}', 'EntidadExternaController@detalles')->name('entidad_externa.detalles')->middleware('permission:consultar_entidad_externa');
    Route::get('entidad-externa/editar/{id}', 'EntidadExternaController@editar')->name('entidad_externa.editar')->middleware('permission:editar_entidad_externa');
    Route::post('entidad-externa/guardar', 'EntidadExternaController@guardar')->name('entidad_externa.guardar')->middleware('permission:crear_entidad_externa');
    Route::post('entidad-externa/grabar/{id}', 'EntidadExternaController@grabar')->name('entidad_externa.grabar')->middleware('permission:editar_entidad_externa');

    /**
     * RUTAS ADMINISTRADO
     */
    Route::get('usuario', 'UsuarioController@index')->name('usuario')->middleware('permission:consultar_usuario');
    Route::get('usuario/crear', 'UsuarioController@crear')->name('usuario.crear')->middleware('permission:crear_usuario');
    Route::get('usuario/{id}/crear-contrato', 'UsuarioController@crearContrato')->name('usuario.crear_contrato')->middleware('permission:crear_usuario');
    Route::get('usuario/detalles/{id}', 'UsuarioController@detalles')->name('usuario.detalles')->middleware('permission:consultar_usuario');
    Route::get('usuario/editar/{id}', 'UsuarioController@editar')->name('usuario.editar')->middleware('permission:editar_usuario');
    Route::get('usuario/editar-contrato/{id}', 'UsuarioController@editarContrato')->name('usuario.editar_contrato')->middleware('permission:editar_usuario');
    Route::get('usuario/listar-ugel', 'UsuarioController@listarUgel')->name('usuario.listar_ugel')->middleware('permission:consultar_usuario, crear_usuario, editar_usuario');
    Route::get('usuario/listar-puesto', 'UsuarioController@listarPuesto')->name('usuario.listar_puesto')->middleware('permission:consultar_usuario, crear_usuario, editar_usuario');
    Route::get('usuario/fotografia/{id}', 'UsuarioController@fotografia')->name('usuario.fotografia')->middleware('permission:consultar_usuario, crear_usuario, editar_usuario');
    Route::get('usuario/carnet-conadis/{id}', 'UsuarioController@carnetConadis')->name('usuario.carnet_conadis')->middleware('permission:consultar_usuario, crear_usuario, editar_usuario');
    Route::get('usuario/contrato/{id}', 'UsuarioController@documento')->name('usuario.contrato')->middleware('permission:consultar_usuario, crear_usuario, editar_usuario');
    Route::get('usuario/privilegios/{id}', 'UsuarioController@privilegios')->name('usuario.privilegios')->middleware('permission:consultar_usuario, crear_usuario, editar_usuario');
    Route::get('usuario/exportar', 'UsuarioController@exportar')->name('usuario.exportar')->middleware('permission:exportar_usuario');
    Route::post('usuario/guardar', 'UsuarioController@guardar')->name('usuario.guardar')->middleware(['permission:crear_usuario', 'jcryption']);
    Route::post('usuario/guardar-contrato', 'UsuarioController@guardarContrato')->name('usuario.guardar_contrato')->middleware('permission:crear_usuario');
    Route::post('usuario/grabar/{id}', 'UsuarioController@grabar')->name('usuario.grabar')->middleware(['permission:editar_usuario', 'jcryption']);
    Route::post('usuario/grabar-contrato/{id}', 'UsuarioController@grabarContrato')->name('usuario.grabar_contrato')->middleware('permission:editar_usuario');
    Route::post('usuario/reniec', 'UsuarioController@reniec')->name('usuario.reniec')->middleware(['permission:consultar_usuario', 'jcryption']);
    Route::post('usuario/grabar-usuario-perfil/{usuario}/{perfil}', 'UsuarioController@grabarUsuarioPerfil')->name('usuario.grabar_usuario_perfil')->middleware('permission:consultar_usuario');

    /**
     * RUTAS MODULO
     */
    Route::get('modulo', 'ModuloController@index')->name('modulo')->middleware('sysadmin');
    Route::get('modulo/crear', 'ModuloController@crear')->name('modulo.crear')->middleware('sysadmin');
    Route::get('modulo/detalles/{id}', 'ModuloController@detalles')->name('modulo.detalles')->middleware('sysadmin');
    Route::get('modulo/editar/{id}', 'ModuloController@editar')->name('modulo.editar')->middleware('sysadmin');
    Route::post('modulo/guardar', 'ModuloController@guardar')->name('modulo.guardar')->middleware('sysadmin');
    Route::post('modulo/grabar/{id}', 'ModuloController@grabar')->name('modulo.grabar')->middleware('sysadmin');

    /**
     * RUTAS PERMISO
     */
    Route::get('permiso', 'PermisoController@index')->name('permiso')->middleware('sysadmin');
    Route::get('permiso/crear', 'PermisoController@crear')->name('permiso.crear')->middleware('sysadmin');
    Route::get('permiso/detalles/{id}', 'PermisoController@detalles')->name('permiso.detalles')->middleware('sysadmin');
    Route::get('permiso/editar/{id}', 'PermisoController@editar')->name('permiso.editar')->middleware('sysadmin');
    Route::post('permiso/guardar', 'PermisoController@guardar')->name('permiso.guardar')->middleware('sysadmin');
    Route::post('permiso/grabar/{id}', 'PermisoController@grabar')->name('permiso.grabar')->middleware('sysadmin');

    /**
     * RUTAS MENU
     */
    Route::get('menu', 'MenuController@index')->name('menu')->middleware('sysadmin');
    Route::get('menu/crear', 'MenuController@crear')->name('menu.crear')->middleware('sysadmin');
    Route::get('menu/detalles/{id}', 'MenuController@detalles')->name('menu.detalles')->middleware('sysadmin');
    Route::get('menu/editar/{id}', 'MenuController@editar')->name('menu.editar')->middleware('sysadmin');
    Route::post('menu/guardar', 'MenuController@guardar')->name('menu.guardar')->middleware('sysadmin');
    Route::post('menu/grabar/{id}', 'MenuController@grabar')->name('menu.grabar')->middleware('sysadmin');

    /**
     * RUTAS PUESTO
     */
    Route::get('perfil', 'PerfilController@index')->name('perfil')->middleware('permission:consultar_perfil');
    Route::get('perfil/crear', 'PerfilController@crear')->name('perfil.crear')->middleware('permission:crear_perfil');
    Route::get('perfil/detalles/{id}', 'PerfilController@detalles')->name('perfil.detalles')->middleware('permission:consultar_perfil');
    Route::get('perfil/editar/{id}', 'PerfilController@editar')->name('perfil.editar')->middleware('permission:editar_perfil');
    Route::post('perfil/guardar', 'PerfilController@guardar')->name('perfil.guardar')->middleware('permission:crear_perfil');
    Route::post('perfil/grabar/{id}', 'PerfilController@grabar')->name('perfil.grabar')->middleware('permission:editar_perfil');

    /**
     * RUTAS AREA
     */
    Route::get('area', 'AreaController@index')->name('area')->middleware('permission:consultar_area');
    Route::get('area/crear', 'AreaController@crear')->name('area.crear')->middleware('permission:crear_area');
    Route::get('area/detalles/{id}', 'AreaController@detalles')->name('area.detalles')->middleware('permission:consultar_area');
    Route::get('area/editar/{id}', 'AreaController@editar')->name('area.editar')->middleware('permission:editar_area');
    Route::post('area/guardar', 'AreaController@guardar')->name('area.guardar')->middleware('permission:crear_area');
    Route::post('area/grabar/{id}', 'AreaController@grabar')->name('area.grabar')->middleware('permission:editar_area');

    /**
     * REPORTE FOROS
     */
    Route::get('forum', 'ForumController@index')->name('forum')->middleware('permission:reporte_forum');
    Route::get('forum/exportar', 'ForumController@exportar')->name('forum.exportar')->middleware('permission:reporte_forum');
    Route::post('forum/reporte', 'ForumController@reporte')->name('forum.reporte')->middleware('permission:reporte_forum');

    /**
     * REPORTE CONSOLIDADO ESTRATEGIAS
     */
    Route::get('course', 'CourseController@index')->name('course')->middleware('permission:reporte_course');
    Route::get('course/exportar', 'CourseController@exportar')->name('course.exportar')->middleware('permission:reporte_course');
    Route::post('course/reporte', 'CourseController@reporte')->name('course.reporte')->middleware('permission:reporte_course');

    Route::namespace('AulaVirtual')->group(function () {
        Route::get('centro-academico', 'CentroAcademicoController@index')->name('centro-academico.index');
        Route::get('centro-academico/lista', 'CentroAcademicoController@lista')->name('centro-academico.lista');
    });

    Route::prefix('aula-virtual')
        ->namespace('AulaVirtual')
        ->group(function () {
            Route::prefix('centro-academico')->group(function () {
                Route::get('', 'CentroAcademicoController@index')->name('aula-virtual.centro-academico.index');
                Route::get('/cursos/{id}', 'CentroAcademicoController@cursos')->name('aula-virtual.centro-academico.curso');
                Route::get('/cursos/{id}/actividades', 'CentroAcademicoController@actividades')
                    ->name('cursos.actividades');
                Route::get(
                    '/cursos/{id}/actividades/export',
                    'CentroAcademicoController@export'
                )->name('aula-virtual.centro-academico.cursos.export');
            });
            Route::prefix('gestion-usuario')->group(function () {
                Route::get('', 'GestionUsuarioController@index')->name('aula-virtual.gestion-usuario.index');
            });
            Route::prefix('certificado')->group(function () {
                Route::get('', 'CertificadoController@index')->name('aula-virtual.certificado.index');
            });
            Route::prefix('auditoria')->group(function () {
                Route::get('accesos', 'AuditoriaController@accesosUsuarios')->name('aula-virtual.auditoria.accesos-usuarios');
                Route::get('log', 'AuditoriaController@logSistema')->name('aula-virtual.auditoria.log-sistema');
            });
            Route::prefix('calificacion-tarea')->group(function () {
                Route::get('', 'CalificacionTareaController@index')->name('aula-virtual.calificacion-tarea.index');
            });
    });

    Route::prefix('mensajeria')
        ->namespace('Mensajeria')
        ->group(function () {
            Route::prefix('programacion-envio')->group(function () {
                Route::get('', 'ProgramacionEnvioController@index')->name('mensajeria.programacion-envio.index');
            });
            Route::prefix('plantilla-mensaje')->group(function () {
                Route::get('', 'PlantillaMensajeController@index')->name('mensajeria.plantilla-mensaje.index');
            });
            Route::prefix('configuracion-canal')->group(function () {
                Route::get('whatsapp', 'ConfiguracionCanalController@whatsapp')->name('mensajeria.configuracion-canal.whatsapp.index');
                Route::get('email', 'ConfiguracionCanalController@email')->name('mensajeria.configuracion-canal.email.index');
                Route::get('sms', 'ConfiguracionCanalController@sms')->name('mensajeria.configuracion-canal.sms.index');
            });
            Route::prefix('reporte')->group(function () {
                Route::get('estadistica', 'ReporteController@estadistica')->name('mensajeria.reporte.estadistica');
                Route::get('envios-realizado', 'ReporteController@envioRealizado')->name('mensajeria.reporte.envios-realizado');
            });
        });

    });

});

