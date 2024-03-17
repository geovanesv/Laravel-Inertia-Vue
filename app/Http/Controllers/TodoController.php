<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;

use App\Models\Todo;


class TodoController extends Controller
{
    public function todos()
    {
        return Inertia::render('Todo', [
            'todos' => Todo::oldest('status')->latest()->get()
        ]);
    }

    public function store()
    {
        $validator = Validator::make(request()->all(), [
            'title' => 'required|string|max:500'
        ]);

        if ($validator->fails()) return response()->json($validator->errors()->first(), 400);

        Todo::create(request()->all());
        return response()->json("Task adicionada com sucesso");
    }

    public function update()
    {
        $validator = Validator::make(request()->all(), [
            'id' => 'required|integer',
            'title' => 'required|string|max:500'
        ]);

        if ($validator->fails()) return response()->json($validator->errors()->first(), 400);

        Todo::where('id', request('id'))->update([
            'title' => request('title')
        ]);
        return response()->json("Task Atualizada com sucesso");
    }

    public function change_status()
    {
        $validator = Validator::make(request()->all(), [
            'id' => 'required|integer',
            'status' => 'required|bool|max:1'
        ]);

        if ($validator->fails()) return response()->json($validator->errors()->first(), 400);

        Todo::where('id', request('id'))->update(request()->all());
        return response()->json("Task status changed successo");
    }

    public function delete($id)
    {
        $todo = Todo::find($id);
        if($todo) {
            $todo->delete();
            return response()->json("Task deletada successo");
        }
        else{
            return response()->json("Task not found", 404);
        }
    }
}