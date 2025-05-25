<?php

namespace App\Services;

use App\Models\ToDo;

class ToDoService
{
    public function list(array $filters = [])
    {
        $todos = ToDo::query()
            ->where('user_id', auth()->user()->id)
            ->when($filters['status'] ?? null, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($filters['due_date'] ?? null, function ($query, $dueDate) {
                return $query->whereDate('due_date', $dueDate);
            })
            ->orderBy('created_at', 'desc');

        if (isset($filters["all"])){
            return $todos->get();
        }elseif(isset($filters["per_page"])){
            return $todos->paginate($filters["per_page"]);
        }else{
            return $todos->paginate(12);
        }
    }

    public function details(int $id)
    {
        $todo = ToDo::where('user_id', auth()->user()->id)->find($id);

        return $todo;
    }

    public function create(array $data)
    {
        $todo = new ToDo();
        $todo->user_id = auth()->user()->id;
        $todo->title = $data['title'];
        $todo->description = $data['description'];
        $todo->due_date = $data['due_date'] ?? null;
        $todo->status = $data['status'] ?? 'pending';
        $todo->save();

        return $todo;
    }

    public function update(array $data, int $id)
    {
        $todo = $this->details($id);
        if (!$todo) {
            return false;
        }
        $todo->title = $data['title'];
        $todo->description = $data['description'];
        $todo->due_date = $data['due_date'] ?? null;
        $todo->update();

        return $todo;
    }

    public function updateStatus(array $data, int $id)
    {
        $todo = $this->details($id);
        if (!$todo) {
            return false;
        }
        $todo->status = $data['status'];
        $todo->update();

        return $todo;
    }

    public function delete(int $id)
    {
        $todo = $this->details($id);
        if (!$todo) {
            return false;
        }
        $todo->delete();

        return true;
    }
}
