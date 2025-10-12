<?php

namespace App\Providers;

use Collective\Html\FormFacade;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('alpha_spaces', function ($attribute, $value) {
            $value = str_replace(['ñ', 'Ñ', '°'], '', $value);
            return preg_match('/^[a-zA-Zá-źÁ-Ź0-9.:,;\'"º‘\s\-\/]*$/u', $value); 
        });
        Validator::extend('description', function ($attribute, $value) {
            $value = str_replace(['ñ', 'Ñ', '°'], '', $value);
            return preg_match('/^[a-zA-Zá-źÁ-Ź0-9¿?¡!.:,;#%&()\'"º‘\s\-\/]*$/u', $value); 
        });
        FormFacade::component('divError', 'components.form.error', []);
        FormFacade::component('fileinput', 'components.form.fileinput', ['name', 'attributes' => []]);
        Blade::if('show', function ($permiso) {
            $user = auth()->user();
            if (isset($user)) {                                              // USUARIO AUTENTICADO 
                if ($user->flg_usu_admin) {                                  // SUPER USUARIO
                    return true;
                }
                $arr_permiso = Session::get('arr_permiso', collect());
                if ($arr_permiso->contains('descripcion', $permiso)) {          // USUARIO AUTORIZADO
                    return true;
                }
            }
            return false;
        });
    }
}
