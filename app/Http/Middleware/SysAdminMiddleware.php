<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;

class SysAdminMiddleware
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
    public function handle($request, Closure $next)
    {
        $user = auth()->user();
        if (isset($user) && $user->flg_usu_admin) {     // USUARIO AUTENTICADO + SUPER USUARIO 
            return $next($request);
        }
        throw new AuthorizationException('Usted no tiene permiso a la opcion.');
    }
}
