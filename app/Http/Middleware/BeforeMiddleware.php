<?php

namespace App\Http\Middleware;

use Closure;
use App\Helper\MCrypt;

class BeforeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            // Decrypt data in this middleware
            $MCrypt = new MCrypt;
            $array = "";

            if ($request->getContent() != "" && $request->getMethod() != "GET") {
                $array = json_decode($MCrypt->decrypt_str($request->getContent()),true);
            } elseif($request->input('data') != "" && $request->getMethod() != "GET") {
                $array = json_decode($MCrypt->decrypt_str($request->input('data')),true);
            }

            if ($array != "" && $request->getMethod() != "GET") {
                $request->json()->replace($array);
            }
        } catch(Exceptions $e) {
            return $e->getMessage();
        } finally {
            return $next($request);
        }
    }
}
