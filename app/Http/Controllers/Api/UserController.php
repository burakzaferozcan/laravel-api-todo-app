<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    //
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

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

        $data = $this->userService->register($requestData);
        return apiResponse("Kayıt başarıyla oluşturuldu.", 200, ["user" => $data]);
    }

    public function login(Request $request)
    {
        $user = $this->userService->login($request->only('email', 'password'));
        if ($user) {
            $token = $user->createToken("api_case")->accessToken;
            return apiResponse("Giriş başarılı", 200, ["token" => $token, "user" => $user]);
        }
        return apiResponse("Unauthorized", 401);
    }

    public function logout(Request $request)
    {
        if (Auth::guard("api")->check()) {
            Auth::guard("api")->user()->token()->revoke();;
            return apiResponse("Başarıyla çıkış yapıldı.", 200, ["user" => auth()->user()]);

        } else {
            return apiResponse("Çıkış yapıldı.", 404);
        }
    }

    public function myProfile(Request $request)
    {
        return Auth::guard("api")->user();
    }
}
