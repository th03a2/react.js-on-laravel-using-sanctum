# react.js-on-laravel-using-sanctum
React.js<br>
Laravel8<br>
Sanctum-Auth

<h2>Laravel Sanctum</h2>
  Laravel Sanctum provides a <i>featherweight authentication system for SPAs (single page applications), mobile applications, and simple, token based APIs</i>. Sanctum allows each user of your application to generate multiple API tokens for their account. These tokens may be granted abilities / scopes which specify which actions the tokens are allowed to perform..
<br>
From what I understand, Sanctum is a lighter auth system to be used in SPA under the same domain as the API. while <b>Passport</b> allows to sign in from a SPA on another domain like  but the user is redirected to the backend on login, <i>which is not very user friendly</i>. <b>Token and JWT</b> just seem older and more complicated to manage.
<br><br>
<h2>Follow few steps to get following web services</h2>

Login API <br>
Details API

<h2>Getting Started</h2>
<h2>Step 1: setup database in .env file</h2>
<pre>DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=</pre>
<pre>*** Create database name laravel</pre>

<h2>Step 2: Install Laravel Sanctum.</h2>
<pre>composer require laravel/sanctum</pre>

<h2>Step 3: Publish the Sanctum configuration and migration files .</h2>
<pre>php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"</pre>

<h2>Step 4: Run database migrations.</h2>
<pre>php artisan migrate</pre>

<h2>Step 5: Add Sanctum's middleware.</h2>
<pre>../app/Http/Kernel.php</pre>
<pre>
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

...

    protected $middlewareGroups = [
        ...

        'api' => [
            EnsureFrontendRequestsAreStateful::class,
            'throttle:60,1',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    ...
],</pre>

<h2>Step 6: Implement tokens on users.</h2>
<pre>use Laravel\Sanctum\HasApiTokens;<br>
class User extends Authenticatable
        {
            use HasApiTokens, Notifiable;
            ...
        }</pre>

<h2>Step 7: Let's create a seeder</h2>
<pre>php artisan make:seeder UsersSeeder</pre>

<h2>Step 8: Now let's insert a record</h2>
<pre>
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
...
...
DB::table('users')->insert([
    'name' => 'Juan Dela Cruz',
    'email' => 'jdc@phil.com',
    'password' => Hash::make('password')
]);</pre>

<h2>Step 9: Seeding the informations</h2>
<pre>php artisan db:seed --class=UsersSeeder</pre>

<h2>Step 10: Create a controller</h2>
<pre>Http/Controllers/api.php</pre>
<pre><?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    // 

    function look(Request $request)
    {
        $user= User::where('email', $request->email)->first();
        // print_r($data);
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response([
                    'message' => ['These credentials do not match our records.']
                ], 404);
            }
        
             $token = $user->createToken('my-app-token')->plainTextToken;
        
            $response = [
                'user' => $user,
                'token' => $token
            ];
        
            return response($response, 201);
    }
}</pre>
<h2>Step 11: Route update</h2>
<pre>routes/api.php</pre>
<pre>use App\Http\Controllers\UserController;

.....
Route::prefix('/users')->group(function () {
    Route::get('/look', [UserController::class, 'look']);
});

</pre>

<h2>Step 12: Test with postman, Result will be below</h2>
<pre>{
    "user": {
        "id": 1,
        "name": "Juan Dela Cruz",
        "email": "jdc@phil.com",
        "email_verified_at": null,
        "created_at": null,
        "updated_at": null
    },
    "token": "thisIsAsampleTokenOnly..."
}</pre>

<h2>Step 13: Make Details API or any other with secure route</h2>
<pre>Route::group(['middleware' => 'auth:sanctum'], function(){
    //All secure URL's

    });


<pre>Route::post("login",[UserController::class,'index']);</pre>
