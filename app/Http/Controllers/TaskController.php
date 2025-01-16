<?php

namespace App\Http\Controllers;

    use App\Models\Task;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    
    class TaskController extends Controller
    {
        public function index(Request $request)
        {
    
         $status = $request->get('status');
         $sortOrder = $request->get('sort', 'asc'); 

         $query = Task::where('user_id', Auth::id());

         if ($status) {
          $query->where('status', $status);
         }
         
         $tasks = $query->orderBy('due_date', $sortOrder)->get();

         return view('tasks.index', compact('tasks', 'status', 'sortOrder'));
        }

        public function create()
        {
            return view('tasks.create');
        }
    
        public function store(Request $request)
        {
            $request->validate([
                'title' => 'required|max:255',
                'description' => 'required',
                'due_date' => 'required|date',
            ]);
    
            Task::create([
                'user_id' => Auth::id(),
                'title' => $request->title,
                'description' => $request->description,
                'due_date' => $request->due_date,
            ]);
    
            return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
        }
    
        public function edit(Task $task)
        {
            if ($task->user_id !== Auth::id()) {
                abort(403);
            }
            return view('tasks.edit', compact('task'));
        }
    
        public function update(Request $request, Task $task)
        {
            if ($task->user_id !== Auth::id()) {
                abort(403);
            }
    
            $request->validate([
                'title' => 'required|max:255',
                'description' => 'required',
                'due_date' => 'required|date',
            ]);
    
            $task->update($request->only('title', 'description', 'due_date', 'status'));
    
            return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
        }
    
        public function destroy(Task $task)
        {
            if ($task->user_id !== Auth::id()) {
                abort(403);
            }
    
            $task->delete();
            return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
        }
    }
    
