<?php

namespace App\Http\Middleware;

use Closure;
use App\Helper\MCrypt;

class AfterMiddleware
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
            // Encrypt before sending response;
            $MCrypt = new MCrypt;
            $response = $next($request);
            $response->getContent();

            if ($request->ajax()) {
                $response = json_decode($response->getData());
            } else {
                $response = $MCrypt->encrypt_str(json_encode($response->getData()));
            }
        } catch (Exception $e) {
            return $e->getMessage();
        } finally {
            return $response;
        }
    }
}
