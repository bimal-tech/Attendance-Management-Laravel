<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class AuthController extends Controller
{
    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        $authenticated =  Auth::attempt($request->only(['email', 'password']));
        if (!$authenticated) {
            return ["success" => false, "msg" => "Not Authenticated"];
        } else {
            $user = User::where('email', $email)->firstOrFail();
            if ($user) {
                $token = $user->createToken('auth_token')->plainTextToken;
            }
            return ["success" => true, "msg" => "Authenticated", "token" => "Bearer " . $token];
        }
    }
}
