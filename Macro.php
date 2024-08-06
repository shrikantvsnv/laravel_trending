<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Collection;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Collection::macro('recursiveHtmlspecialchars', function () {
            $sanitize = function ($value) use (&$sanitize) {
                if (is_array($value)) {
                    return array_map($sanitize, $value);
                }

                if (is_string($value)) {
                    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
                }

                return $value;
            };

            return $this->map($sanitize);
        });
    }
}

#User macro
use Illuminate\Support\Collection;

// Sample data
$data = [
    'name' => '<b>John Doe</b>',
    'email' => 'john@example.com',
    'address' => [
        'city' => '<i>New York</i>',
        'zip' => '10001'
    ],
];

// Convert array to collection
$collection = collect($data);

// Apply the macro
$sanitizedData = $collection->recursiveHtmlspecialchars();

// Convert back to array if needed
$sanitizedArray = $sanitizedData->toArray();

print_r($sanitizedArray);
