<?php

namespace App\Repositories;

use App\Models\Todo;
use Illuminate\Support\Facades\Hash;

class TodoRepository
{
    protected $model;

    public function __constructor(Todo $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        $todo = Todo::get();

        return $todo;
    }

    public function find($id)
    {
        return $this->model->findorfail($id);
    }

    public function store($data)
    {
        return Todo::create([
            'name' => $data['name'],
            "completed" => $data['completed'],
        ]);
    }

    public function update($id, $data)
    {
//        $contact = Contact::findorfail($id)->update($request->all())
        return Todo::findorfail($id)->update([
            'name' => $data['name'],
            "completed" => $data['completed'],
        ]);
    }
}
