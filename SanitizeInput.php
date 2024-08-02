<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SanitizeInput
{
    /**
     * Array mapping input keys to sanitization functions.
     *
     * @var array
     */
    protected $sanitizers = [
        'username' => 'trim|strip_tags',
        'email' => 'trim|strtolower',
        // Add more mappings as needed
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $input = $request->all();

        foreach ($this->sanitizers as $key => $sanitizer) {
            if ($request->has($key)) {
                $functions = explode('|', $sanitizer);
                $value = $request->input($key);
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

    function getenv(){

        // Original associative array
        $first_array = array('c1' => 'Red', 'c2' => 'Green', 'c3' => 'White', 'c4' => 'Black');

        // Array containing keys to check for intersection
        $second_array = array('c2', 'c4');

        // Use array_flip to swap keys and values, then apply array_intersect_key to find common keys
        $result = array_intersect_key($first_array, array_flip($second_array));

        // Display the result
        print_r($result);

    }


}


