<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Create a new user instance after a valid registration.
     */
    protected function create(RegisterRequest $request)
    {
        User::create([
            'email' => $request['email'],
            'username' => $request['username'],
            'name' => $request['name'],
            'type' => $request['type'],
            'password' => Hash::make("123456"),
        ]);

        return response()->json([
            'msg' => 'Register successfully',
        ]);
    }
}
