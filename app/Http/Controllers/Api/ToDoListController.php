<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ToDoRequest;
use App\Http\Requests\ToDoStatusRequest;
use App\Services\ToDoService;
use Illuminate\Http\Request;
use Throwable;

class ToDoListController extends Controller
{
    public function __construct(
        protected readonly ToDoService  $toDoService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $toDoList = $this->toDoService->list($request->all());
            return response()->json($toDoList);
        } catch (Throwable $e) {
            return response()->json(['error', $e->getMessage(), 500]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ToDoRequest $request)
    {
        try {
            $toDo = $this->toDoService->create($request->all());
            return response()->json(["data" => $toDo], 201);
        } catch (Throwable $e) {
            return response()->json(['error', $e->getMessage(), 500]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $toDo = $this->toDoService->details($id);
            if (!$toDo) {
                return response()->json(['error' => 'Tarefa não encontrada'], 404);
            }
            return response()->json(["data" => $toDo]);
        } catch (Throwable $e) {
            return response()->json(['error', $e->getMessage(), 500]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ToDoRequest $request, string $id)
    {
        try {
            $toDo = $this->toDoService->update($request->all(), $id);
            if (!$toDo) {
                return response()->json(['error' => 'Tarefa não encontrada'], 404);
            }
            return response()->json(["data" => $toDo]);
        } catch (Throwable $e) {
            return response()->json(['error', $e->getMessage(), 500]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateStatus(ToDoStatusRequest $request, string $id)
    {
        try {
            $toDo = $this->toDoService->updateStatus($request->all(), $id);
            if (!$toDo) {
                return response()->json(['error' => 'Tarefa não encontrada'], 404);
            }
            return response()->json(["data" => $toDo]);
        } catch (Throwable $e) {
            return response()->json(['error', $e->getMessage(), 500]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $todo = $this->toDoService->delete($id);
            if (!$todo) {
                return response()->json(['error' => 'Tarefa não encontrada'], 404);
            }
            return response()->json(['message' => 'Tarefa deletada com sucesso']);
        } catch (Throwable $e) {
            return response()->json(['error', $e->getMessage(), 500]);
        }
    }
}
