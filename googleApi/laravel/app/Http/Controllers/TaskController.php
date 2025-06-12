<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{
    // タスク一覧を取得（React に渡す）
    public function index()
    {
        $tasks = Task::all();
        return Inertia::render('Todo', ['tasks' => $tasks]);
    }

    // タスクを追加
    public function store(Request $request)
    {
        $request->validate(['title' => 'required']);
        Task::create(['title' => $request->title]);
        return redirect()->route('todo');
    }

    // タスクを編集
    public function update(Request $request, Task $task)
    {
        $request->validate(['title' => 'required']);
        $task->update([
            'title' => $request->input('title')
        ]);
        return redirect()->route('todo');
    }

    // タスクを削除
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('todo');
    }

    // タスクの完了・未完了を更新
    public function toggleComplete($id)
    {
        $task = Task::findOrFail($id);
        $task->completed = !$task->completed;
        $task->save();
        return redirect()->route('todo');
    }
}
