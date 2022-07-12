<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function signup() {
        $attr = request()->validate([
            'username' => ['required', 'max:255', Rule::unique('users', 'username')],
            'password' => ['required', 'min:7', 'max:255', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/']
        ]);
        User::create($attr);
        return ['msg' => 'User created.'];
    }

    public function login() {
        $attr = request()->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        $user = User::where('username', request('username'))->first();
        if(!$user) {
            return ['msg' => 'Invalid credentials'];
        } elseif(!auth()->attempt($attr)) {
            return ['msg' => 'Invalid credentials'];
        } else {
            $token = $user->createToken('authToken')->plainTextToken;
            return ['token' => $token];
        }
    }

    public function logout() {
        request()->user()->currentAccessToken()->delete();
        return ['msg' => 'Logged out.'];
    }
}
