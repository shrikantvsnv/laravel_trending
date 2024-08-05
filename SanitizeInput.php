<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SanitizeInput
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
        /*
           $sanitizers =  [
                   'username' => 'trim|strip_tags',
                   'email' => 'trim|strtolower',
                   'password' => 'trim|strtolower',
                 ];
         */
        $sanitizers = $this->getSanitizeFields($request->all());

        foreach ($sanitizers as $key => $sanitizer) {

                $functions = explode('|', $sanitizer);
                $value = $request->$key;
                foreach ($functions as $function) {
                    if (function_exists($function)) {
                        $value = $function($value);
                    }
                }
                $request->merge([$key => $value]);
           }
        }

        return $next($request);
    }

    function getSanitizeFields($request){

        $sanitizers = config('sanitize.input_field')
        return  array_intersect_key($sanitizers,$request);

    }


}


