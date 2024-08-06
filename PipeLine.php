<?php

namespace App\Pipes;

interface Pipe
{
    /**
     * Handle the data.
     *
     * @param mixed $content
     * @param \Closure $next
     * @return mixed
     */
    public function handle($content, \Closure $next);
}

<?php

namespace App\Pipes;

class TrimStrings implements Pipe
{
    public function handle($content, \Closure $next)
    {
        $content = array_map('trim', $content);
        return $next($content);
    }
}

<?php

namespace App\Pipes;

class UppercaseStrings implements Pipe
{
    public function handle($content, \Closure $next)
    {
        $content = array_map('strtoupper', $content);
        return $next($content);
    }
}

<?php
use Illuminate\Pipeline\Pipeline;
use App\Pipes\TrimStrings;
use App\Pipes\UppercaseStrings;

// Sample data
$data = ['  hello  ', ' world  '];

// Define the pipeline stages
$pipes = [
    TrimStrings::class,
    UppercaseStrings::class,
];

// Process the data through the pipeline
$processedData = app(Pipeline::class)
    ->send($data)
    ->through($pipes)
    ->thenReturn();

print_r($processedData);

<?php
Route::get('/pipeline-test', function () {
    $data = ['  hello  ', ' world  '];

    $pipes = [
        \App\Pipes\TrimStrings::class,
        \App\Pipes\UppercaseStrings::class,
    ];

    $processedData = app(\Illuminate\Pipeline\Pipeline::class)
        ->send($data)
        ->through($pipes)
        ->thenReturn();

    return response()->json($processedData);
});