<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function allUsers(Request $request){
        $users = User::all('id','name','email');
        return response()->json($users);
    }
}
