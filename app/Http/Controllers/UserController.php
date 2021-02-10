<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
        {
            $users=User::all();
            return response()->json($users);
        }
    public function list(Request $request)
        {
            $users=User::whereNull('deleted_at')->get();
            return response()->json($users);  
        }

    public function save(Request $request)
        {
            $user=User::create ($request->all());
            return response()->json($user, 200);
        }

    public function update(Request $request, User $user)
        {
            $user->update($request->all());
            return response()->json($user, 201);
        }
    public function destroy(User $user)
        {
            $user->deleted_at = now();
            $user->update();
            return response()->json(array('success'=>true));
        }
}
