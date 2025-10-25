<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;

class SecureHeaders
{
    private $unwantedHeaderList = [
        'X-Powered-By',
        'Server',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->removeUnwantedHeaders($this->unwantedHeaderList);
        $random = $this->nonceGenerator($request);
        $response = $next($request);
        $response->headers->set('Referrer-Policy', 'no-referrer-when-downgrade');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
//        $response->headers->set('Content-Security-Policy', "base-uri 'self'; connect-src 'self'; default-src 'self'; form-action 'self'; img-src 'self' data:; media-src 'self'; object-src 'none'; script-src 'self' 'nonce-" . $random . "'; style-src 'self' 'unsafe-inline'");
        $response->headers->set(
            'Content-Security-Policy',
            "base-uri 'self'; connect-src 'self' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://unpkg.com https://cdn.tailwindcss.com ; default-src 'self' https: data:; form-action 'self'; img-src 'self' https://i.pravatar.cc data:; media-src 'self'; object-src 'none'; script-src 'self' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://code.jquery.com/jquery-3.7.1.min.js https://unpkg.com https://cdn.tailwindcss.com 'unsafe-inline' 'unsafe-eval'; style-src 'self' https://cdn.jsdelivr.net/npm/flowbite@2.5.0/dist/flowbite.min.css https://unpkg.com https://cdnjs.cloudflare.com https://fonts.googleapis.com 'unsafe-inline'; font-src 'self' https://fonts.gstatic.com data:;"
        );
        return $response;
    }

    private function removeUnwantedHeaders($headerList)
    {
        foreach ($headerList as $header) {
            header_remove($header);
        }
    }

    private function nonceGenerator($request)
    {
        $random = $request->get('nonce');
        if(!$random) {
            $random = Str::random(32);
        }
        $request->merge(["nonce" => $random]);
        return $random;
    }
}
