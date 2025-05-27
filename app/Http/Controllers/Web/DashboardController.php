<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\NewsService;
use App\Services\ToDoService;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __construct(
        protected readonly ToDoService  $toDoService,
        protected readonly NewsService $newsService
    ) {}

    public function index()
    {
        $todoList = $this->toDoService->list();
        $newsList = $this->newsService->list();
        $todoStatus = config("enums.todo.status");
        return Inertia::render('Dashboard', ['todoList' => $todoList, 'newsList' => $newsList, 'todoStatus' => $todoStatus]);
    }
}
