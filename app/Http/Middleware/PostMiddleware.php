<?php

namespace App\Http\Middleware;

use App\Repositories\PostulacionConcursoRepository;
use Closure;

class PostMiddleware
{
    protected $postulacionConcurso;

    public function __construct(PostulacionConcursoRepository $postulacionConcurso)
    {
        $this->postulacionConcurso = $postulacionConcurso;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $postulacionConcurso = $this->postulacionConcurso->vigente($request->route('id'));
        if (empty($postulacionConcurso)) {
            abort(404);
        }
        return $next($request);
    }
}
