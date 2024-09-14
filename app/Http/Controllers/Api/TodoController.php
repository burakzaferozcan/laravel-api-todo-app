<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TodoResource;
use App\Services\TodoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    //
    protected $todoService;

    public function __construct(TodoService $todoService)
    {
        $this->todoService = $todoService;
    }

    public function index(Request $request)
    {
        $todos = TodoResource::collection($this->todoService->getAll());
        return apiResponse(("Todo'lar geldi"), 200, $todos);
    }

    public function getById($id, Request $request)
    {
        return $todos = $this->todoService->find($id);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required',
        ], [
            "name.required" => "Başlık alanı zorunlu!"
        ]);
        if ($validator->fails()) {
            return apiResponse(("Validation error"), 401, ["errors" => $validator->errors()]);
        }
        $todo = $this->todoService->store($data);
        return apiResponse(("Todo oluşturuldu."), 200, $todo);
    }

    public function update($id, Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required',
        ], [
            "name.required" => "Başlık alanı zorunlu!"
        ]);
        if ($validator->fails()) {
            return apiResponse(("Validation error"), 401, ["errors" => $validator->errors()]);
        }
        $todo = $this->todoService->update($id, $data);
        return apiResponse(("Todo Güncellendi."), 200, $data);
    }
}
