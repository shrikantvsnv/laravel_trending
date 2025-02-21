<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChecksumMiddleware
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
        $secretKey = env('CHECKSUM_SECRET_KEY', 'your-secret-key');
        $checksumHeader = $request->header('X-Checksum');

        if (!$checksumHeader) {
            return response()->json(['error' => 'Checksum header missing'], 400);
        }

        // Compute the checksum from the request data
        $data = $request->getContent();
        $computedChecksum = hash_hmac('sha256', $data, $secretKey);

        if ($computedChecksum !== $checksumHeader) {
            return response()->json(['error' => 'Invalid checksum'], 400);
        }

        return $next($request);
    }
}
    