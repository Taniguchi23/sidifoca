<?php

namespace App\Http\Middleware;

use App\Repositories\ConcursoRepository;
use Closure;

class PublishedMiddleware
{
    protected $concurso;

    public function __construct(ConcursoRepository $concurso)
    {
        $this->concurso = $concurso;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $route = null)
    {
        $concurso = $this->concurso->vigente();
        if (empty($concurso)) {
            if ($route) {
                return redirect()->route($route);
            } else {
                abort(404); // CAMBIAR SE DESEA PERSONALIZAR LA PAGINA 404
            }
        }
        return $next($request);
    }
}
