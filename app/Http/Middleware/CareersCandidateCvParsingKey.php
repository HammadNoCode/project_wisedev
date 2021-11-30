<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CareersCandidateCvParsingKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

      /*  if ($request->key === env('CAREERS_PG_API_KEY')) {
            return $next($request);
        }
      */
        $headers = apache_request_headers();
       // dd($headers['API_TOKEN']);
        if ($headers['key'] === config('external_careers_pg_api.CAREERS_PG_API_KEY')) {
            return $next($request);
        }
        return response()->json('Invalid Key',401);

    }



}
