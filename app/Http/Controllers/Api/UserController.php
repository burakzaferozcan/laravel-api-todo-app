<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController;

use Illuminate\Http\Request;

class UserController extends BaseController
{
    //
    public function index()
    {
        $data = "test";
        $this->sendResponse($data, "mesaj");
    }
}
