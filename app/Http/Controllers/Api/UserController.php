<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
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

    public function register(RegisterRequest $request)
    {
        $requestData = $request->all();
        $data = $this->userService->register($requestData);
        return apiResponse("Kayıt başarıyla oluşturuldu.", 200, ["user" => $data]);
    }

    public function login(LoginRequest $request)
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

    public function updateUserImage(Request $request)
    {
        $user = $this->userService->updateUserImage(auth()->user()->id, $request->file('image'));
        if ($user) {
            return apiResponse("Updated Image", 200, ["user" => new UserResource($user)]);
        }
        return apiResponse("Information is incorrect", 400);
    }
}
