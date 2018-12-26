<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Notifications\AccountVerification;

class RegisterController extends Controller
{
    /**
     * Create a new user instance after a valid registration.
     */
    protected function create(RegisterRequest $request)
    {
        // User::create([
        //     'email' => $request['email'],
        //     'username' => $request['username'],
        //     'name' => $request['name'],
        //     'type' => $request['type'],
        //     'password' => Hash::make("123456"),
        //     'activation_token' => str_random(60)
        // ]);

        $user = new User([
            'email' => $request['email'],
            'username' => $request['username'],
            'name' => $request['name'],
            'type' => $request['type'],
            'password' => Hash::make("123456"),
            'activation_token' => str_random(60),
        ]);

        //Guartar na BD
        $user->save();

        //Enviar email
        $user->notify(new AccountVerification($user));

        return response()->json([
            'msg' => 'Register successfully',
        ]);
    }

    public function accountValidate($token)
    {
        $user = User::where('id', $token)->first();

        if (!$user) {
            return response()->json([
                'message' => 'This activation token is invalid.'
            ], 404);
        }

        if($user->email_verified_at) {
            return response()->json([
                'message' => 'This account is already activated.'
            ], 406);
        }

        $user->email_verified_at = date("Y-m-d H:i:s");

        $user->save();

        return view('validate');
    }
}
