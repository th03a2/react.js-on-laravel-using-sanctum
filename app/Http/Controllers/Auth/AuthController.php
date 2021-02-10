<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\Actor\User;
use Auth,File,Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
        {
            try{
                if(Auth::attempt($request->only( 'email', 'password' ))){
                    /** @var User $user */
                    $user = Auth::user();
                    $token = $user->createToken('my-app-token')->plainTextToken;

                    return response([
                        'message' => 'success',
                        'token' => $token,
                        'user' => $user
                    ], 201);
                }
            }catch(\Exception $exception){
                return response([
                    'message' => $exception->getMessage()
                ], 400);
            }

            return response([
                'message' => 'Invalid username/password'
            ], 401);
        }

    public function user()
        {
            return Auth::user();
        }

    public function register(Request $request)
        {
            try{
                $validator = Validator::make($request->all(), [
                    'name' => 'required|string|between:2,100',
                ]);

                if ($validator->fails()) {
                    return response([
                        'message' => 'ERROR 401:Something went wrong.'
                    ], 401);
                }else{
                    $user = User::create([
                        'name' => $request->input('name'),
                        'email' => $request->input('email'),
                        'password' => bcrypt($request->input('password'))
                    ]);

                    return response()->json(['status' => 'success', 'user' => $user],  200);
                }
            } catch (\Exception $exception){
                return response([
                    'message' => $exception->getMessage()
                ], 400);
            }
        }
    public function exist(Request $request)
        {
            $user = User::where('email', $request->email)->first();
                if ($user) {
                    return response([
                        'message' => 'Email is already taken!'
                    ], 401);
                }else{
                    $validator = Validator::make($request->all(), [
                        'email' => 'required|string|email|max:100|unique:users',
                        'confirmed' => 'required',
                        'password' => 'required|min:8|same:confirmed' // password_confirmation
                    ]);
                    if ($validator->fails()) {
                        return response([
                            'message' => 'something went wrong..'
                        ], 401);
                    }else{
                    return response()->json(['status' => 'success', 'user' => $request->email]);
                }
                }

        }
}
