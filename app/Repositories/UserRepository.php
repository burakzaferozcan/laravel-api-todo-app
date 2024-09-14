<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class UserRepository
{
    protected $model;

    public function __constructor(User $model)
    {
        $this->model = $model;
    }

    public function register($data)
    {
        try {
            return User::create([
                "name" => $data["name"],
                "email" => $data["email"],
                "password" => $data["password"],
            ]);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return response()->json(["error" => "The email address is already in use"]);
            }
            throw $e;
        }
    }

    public function login($data)
    {

        if (auth()->attempt(["email" => $data["email"], "password" => $data["password"]])) {
            return auth()->user();
        }
    }


    public function updateUserImage($userId, $image)
    {
        $user = $this->find($userId);
        if ($user) {
            removeImage($user->image);
            $folderName = "img/user";
            $fileName = "profile";
            $imageUrl = uploadImage($image, $fileName, $folderName);

            $user->image = $imageUrl;
            $user->save();
            return $user;
        }
        return null;
    }

}
