<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'email' => ['required'],
                'password' => ['required']
            ]);
        if ($validator->fails()) {
            return $validator->errors();
        }
        if (Auth::attempt($request->only('email', 'password'))) {
            return ['token' => Auth::user()->createToken('AppName')->plainTextToken];
        }
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.']
        ]);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();

        return ['message' => 'logout complete'];
    }
}

