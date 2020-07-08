<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => ['required'],
                'email' => ['required', 'email', 'unique:users'],
                'password' => ['required', 'min:8', 'confirmed']
            ]);
        if ($validator->fails()) {
            return $validator->errors();
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return $user;
    }
}
