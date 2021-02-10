<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\ForgotRequest;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class ForgotController extends Controller
{
    public function forgot(Request $request)
    {
        $email = $request->input('email');

        if(User::whereEmail($email)->doesntExist()){
            return response([
                'message' => 'E-mail doesn\'t exist!'
            ]);
        }

        $token = Str::random(10);

        try{
            DB::table('password_resets')->insert([
                'email' => $email,
                'token' => $token
            ]);

            // Mail::send('Mails.forgot', ['token' => $token], function(Message $message) use ($email){
            //     $message->to($email);
            //     $message->subject('Reset your password');
            // });

            return response([
                'message' => 'Check your e-mail'
            ]);
        }catch(\Exception $exception){
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'password' => 'required|confirmed',
        ]);

        $token = $request->input('token');

        if(!$passwordResets = DB::table('password_resets')->whereToken($token)->first()){
            return response([
                'message' => 'Invalid token!'
            ], 400);
        }

        /** @var User $user */
        if(!$user = User::whereEmail($passwordResets->email)->first()){
            return response([
                'message' => 'User doesn\'t exist!'
            ]);
        }

        $user->password = bcrypt($request->input('password'));
        $user->save();

        return response([
            'message' => 'success'
        ]);
    }
}
