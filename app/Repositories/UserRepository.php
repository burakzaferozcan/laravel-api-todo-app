<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\QueryException;

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

    public function login()
    {

    }

    public function find()
    {

    }

    public function user()
    {

    }

    public function updateUserImage()
    {

    }

}
