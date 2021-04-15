# React.js on Laravel 8 with Laravel Sanctum
React.js<br>
Laravel 8<br>
Sanctum-OAuth
MySql | MongoDB

<h2>Laravel Sanctum</h2>
  Laravel Sanctum provides a <i>featherweight authentication system for SPAs (single page applications), mobile applications, and simple, token based APIs</i>. Sanctum allows each user of your application to generate multiple API tokens for their account. These tokens may be granted abilities / scopes which specify which actions will the tokens are allowed to perform..
<br>
While <b>Passport</b> allows to sign in from a SPA on another domain like  but the user is redirected to the backend on login, <i>which is not very user friendly</i>. <b>Token and JWT</b> just seem older and more complicated to manage.
<br><br>
<h2>Follow few steps to get following web services</h2>

Login API <br>
Details API

<h2>Getting Started</h2>
<h2>Step 1: Create new Project</h2>
<pre> Create Folder MyProject</pre>
<pre>Inside MyProject Create your project..
  ***Laravel new backend 
  *** Create react project</pre>
  
<h2>Step 2: Update database info in .env</h2>
<pre>
  *** MySQL
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=backend
  DB_USERNAME=root
  DB_PASSWORD
</pre>
<pre>
  *** MongoDB
  DB_CONNECTION=mongodb
  DB_HOST=127.0.0.1
  DB_PORT=27017
  DB_DATABASE=backend
  DB_USERNAME=
  DB_PASSWORD=
</pre>

<h2>Step 2: Install Laravel Sanctum.</h2>
<pre>composer require laravel/sanctum</pre>

<h2>Step 3: Publish the Sanctum configuration and migration files .</h2>
<pre>php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"</pre>

<h2>Step 4: Setup XAMPP environment (For MongoDB)</h2>
<pre>
  a. check your xampp version (ext. 7.4)
  b. Download your library <a href="http://pecl.php.net/package/mongodb/1.8.0beta1/windows">here(.dll)</a> base on your XAMPP version
    ext. dll: 7.4 Thread Safe (TS) x64
  c. Extract and past on: C:\xampp\php\ext
    *** php_mongodb.dll
  d. update the C:\xampp\php php.ini
    *** 	......
      extension=mbstring
      extension=exif      ; Must be after mbstring as it depends on it
      extension=php_mongodb.dll ; insert this on the file.
      extension=mysqli
  e. add folder: C:\data\db



</pre>

<pre>config/app.php</pre>
<pre>
  ....
  'providers' => [
    .....
        /*
        * Package Service Providers...
        */
	      // mongodb
        Jenssegers\Mongodb\MongodbServiceProvider::class,
        ...
</pre>

<pre>config/databse.php</pre>
<pre>
  ...
  */
  
	'default' => env('DB_CONNECTION', 'mongodb'),
  
  /*
  ...
  ...
  'connections' => [
 	'mongodb' => [
            'driver' => 'mongodb',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', 27017),
            'database' => env('DB_DATABASE'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'options' => [
                'database' => env('DB_AUTHENTICATION_DATABASE', 'admin'), 
            ],
        ],
  'sqlite' => [
  ...
</pre>
<h3>Install</h3>
<pre>composer require jenssegers/mongodb</pre>
			or if error
<pre>composer require jenssegers/mongodb --ignore-platform-reqs</pre>

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
<pre>
  ***mySQL
  ...
  use Laravel\Sanctum\HasApiTokens;
  
  class User extends Model implements Authenticatable {
          {
              	use HasApiTokens, Notifiable;		
              	...
          }
</pre>

<pre>
  ***MongoDB
    ...
    use Laravel\Sanctum\HasApiTokens;
    use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
    use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
    use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

    class User extends Eloquent implements AuthenticatableContract {
        use Notifiable, HasFactory, HasApiTokens, AuthenticatableTrait;
        protected $connection = 'mongodb';
        protected $softDelete = true;
        ...
        </pre>
<h2>Step 7: Let's create a AuthController</h2>
<pre>Copy the code on this project</pre>

<h2>Step 8: Let's create a PersonalAccessToken</h2>
<pre>Copy the cope on this project</pre>

<h2>Step 9: Let's update app/Providers/AppServiceProvider</h2>
<pre>
 ...
 use Illuminate\Foundation\AliasLoader;<br>
 
 ...
 public function boot()
    {
      AliasLoader::getInstance()->alias(\Laravel\Sanctum\PersonalAccessToken::class, \App\Models\Sanctum\PersonalAccessToken::class);
    }</pre>

<h2>Step 10: Let's create a seeder</h2>
<pre>php artisan make:seeder UsersSeeder</pre>

<h2>Step 11: Now let's insert a record</h2>
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

<h2>Step 12: Run database migrations with seeder.</h2>
<pre>php artisan migrate --seed</pre>

<h2>Step 13: Create a controller</h2>
<pre>Php artisan make:controller UserController -mrs</pre>
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
<h2>Step 14: Route update</h2>
<pre>routes/api.php</pre>
<pre>use App\Http\Controllers\UserController;

.....
Route::prefix('/users')->group(function () {
    Route::get('/look', [UserController::class, 'look']);
});

</pre>

<h2>Step 16: Test with postman, Result will be below</h2>
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

<h2>Step 15: Make Details API or any other with secure route</h2>
<pre>Route::post("login",[UserController::class,'index']);</pre>
<pre>
	Route::prefix('/auth')->group(function () {
	    Route::post('/login', [AuthController::class, 'login']);
	    Route::post('/register', [AuthController::class, 'register']);
	    Route::post('/email/exist', [AuthController::class, 'exist']);
	    Route::post('/forgot', [ForgotController::class, 'forgot']);
	    Route::post('/reset', [ForgotController::class, 'reset']);
	});

	Route::group(['middleware' => 'auth:sanctum'], function (){
	    //All secure URL's
	    Route::prefix('/users')->group(function () {
		Route::get('/', [UserController::class, 'index']);
		Route::get('/list', [UserController::class, 'list']);
		Route::post('/save', [UserController::class, 'save']);
		Route::put('/{user}/update', [UserController::class, 'update']);
		Route::post('/{user}/upload', [UserController::class, 'upload']);
		Route::delete('/{user}/destroy', [UserController::class, 'destroy']);
	    });
	});
</pre>
