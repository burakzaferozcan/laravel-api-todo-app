<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function register(Request $request)
    {
        $requestData = $request->all();
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ], [
            'name.required' => "İsim alanı zorunlu!",
            "name.max" => "İsim alanı en fazla 255 karakter olabilir!",
            'email.required' => "Email alanı zorunlu!",
            "email.max" => "E-posta alanı en fazla 255 karakter olabilir!",
            "email.unique" => "Bu e-posta ile oluşturulmuş bir hesap zaten var!",
            'password.required' => "Şifre alanı zorunlu!",
            "password.min" => "Şifre en az 6 karakterden oluşmalıdır!"
        ]);
        $data = User::create([
            "name" => $requestData["name"],
            "email" => $requestData["email"],
            "password" => $requestData["password"],
        ]);
        return apiResponse("register message", 200, $data);
    }

    public function login(Request $request)
    {
        $data = $request->all();
        return apiResponse("login message", 200, $data);
    }
}
