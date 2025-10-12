<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Session;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param string $permisos
     * @throws AuthorizationException
     * @return mixed
     */
    public function handle($request, Closure $next, ...$permisos)
    {
        $user = auth()->user();
        if (isset($user)) {                                              // USUARIO AUTENTICADO 
            if ($user->flg_usu_admin) {                                  // SUPER USUARIO
                return $next($request);
            }
            if (empty(Session::get('success'))) {
                return redirect()->route('login');
            }
            $arr_permiso = Session::get('arr_permiso', collect());
            foreach ($permisos as $permiso) {
                if ($arr_permiso->contains('descripcion', $permiso)) {      // USUARIO AUTORIZADO
                    return $next($request);
                }
            }
        }
        throw new AuthorizationException('Usted no tiene permiso a la opcion.');
    }
}
