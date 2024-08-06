1. Create the Contract (Interface)
Define an interface that specifies the methods for generating JSON responses.

app/Contracts/JSONResponseInterface.php
php
Copy code
<?php

namespace App\Contracts;

interface JSONResponseInterface
{
    public function success($data = null, $message = 'Success', $statusCode = 200);
    public function error($message = 'Error', $statusCode = 400, $errors = null);
}
2. Create the Service Class
Implement the contract in a service class.

app/Services/JSONResponseService.php
php
Copy code
<?php

namespace App\Services;

use App\Contracts\JSONResponseInterface;

class JSONResponseService implements JSONResponseInterface
{
    public function success($data = null, $message = 'Success', $statusCode = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    public function error($message = 'Error', $statusCode = 400, $errors = null)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors,
        ], $statusCode);
    }
}
3. Create the Facade
Create a facade class that will provide a static interface to the service.

app/Facades/JSONResponse.php
php
Copy code
<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class JSONResponse extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'json.response';
    }
}
4. Register the Service and Facade
Bind the service class to the interface in a service provider and register the facade alias.

app/Providers/AppServiceProvider.php
php
Copy code
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\JSONResponseInterface;
use App\Services\JSONResponseService;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(JSONResponseInterface::class, JSONResponseService::class);

        $this->app->singleton('json.response', function ($app) {
            return $app->make(JSONResponseInterface::class);
        });
    }

    public function boot()
    {
        //
    }
}
config/app.php
Add the facade alias to the aliases array in the config/app.php file.

php
Copy code
'aliases' => [
    // Other aliases
    'JSONResponse' => App\Facades\JSONResponse::class,
],
5. Use the Facade in Controllers
Now you can use the JSONResponse facade in your controllers.

app/Http/Controllers/AuthController.php
php
Copy code
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JSONResponse;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $payload = [
                'sub' => $user->id,
                'email' => $user->email,
                'iat' => time(),
                'exp' => time() + 60*60 // Token expiration time (1 hour)
            ];

            $token = app('App\Contracts\JWTServiceInterface')->generateToken($payload);

            return JSONResponse::success(['token' => $token], 'Login successful');
        }

        return JSONResponse::error('Unauthorized', 401);
    }

    public function getUser(Request $request)
    {
        $token = $request->bearerToken();
        $payload = app('App\Contracts\JWTServiceInterface')->getPayload($token);

        if ($payload) {
            return JSONResponse::success(['user' => $payload], 'User retrieved successfully');
        }

        return JSONResponse::error('Invalid Token', 401);
    }
}