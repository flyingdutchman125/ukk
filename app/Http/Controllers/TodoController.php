<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Todo::query();

        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $todos = $query->get();

        return view('todo.index', compact('todos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'prioritas' => 'required|in:1,2,3,4,5',
        ]);

        Todo::create([
            'name' => $request->name,
            'prioritas' => $request->prioritas,
            'status' => false,
            'tgl_dicentang' => null,
        ]);

        return redirect()->route('todo.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $todo = Todo::findOrFail($id);
        $todos = Todo::all();
        return view('todo.index', compact('todos', 'todo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'prioritas' => 'required|in:1,2,3,4,5',
        ]);

        $todo = Todo::findOrFail($id);
        $todo->update([
            'name' => $request->name,
            'prioritas' => $request->prioritas,
        ]);

        return redirect()->route('todo.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();
        return redirect()->route('todo.index');
    }

    public function updateStatus(Request $request, $id)
    {
        $todo = Todo::findOrFail($id);
        $todo->status = !$todo->status;
        $todo->tgl_dicentang = $todo->status ? Carbon::now() : null;
        $todo->save();

        return redirect()->route('todo.index');
    }
}
